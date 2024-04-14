<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FormToken;
use App\Http\Requests\RailwayStationStoreRequest as StoreRequest;
use App\Http\Requests\RailwayStationEditRequest as EditRequest;
use App\Http\Requests\RailwayStationUpdateRequest as UpdateRequest;
use App\Models\RailwayStationEventStream as EventStream;
use App\Models\RailwayStationStoreRequest as StoreModel;
use App\Models\RailwayStationUpdateRequest as UpdateModel;
use App\Models\RailwayLine;
use App\Models\RailwayStation;
use App\Models\RailwayStationDetail;
use App\Models\RailwayStationHistory;
use App\Models\RailwayStationHistoryDetail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class RailwayStationController extends Controller
{
    public function index()
    {
        return view('admin.railway_stations.index');
    }

    public function create()
    {
        return view('admin.railway_stations.create', ['initialParams' => [
            'token' => FormToken::make(),
        ]]);
    }

    public function store(StoreRequest $request)
    {
        if (StoreModel::existsToken($request->input('token'))) {
            throw ValidationException::withMessages([
                'token' => ['このトークンは使用済みです。フォームを再読み込みし、入力し直してください。'],
            ]);
        }

        $railwayRoute = RailwayLine::find($request->input('railway_line_id'));
        if ($railwayRoute === null) {
            throw ValidationException::withMessages([
                'railway_line_id' => ['不正な路線会社IDです。'],
            ]);
        }

        DB::transaction(function () use ($request) {
            $eventStream = new EventStream();
            $eventStream->save();

            (new StoreModel())
                ->fill($request->all())
                ->fill([
                    'railway_station_event_stream_id' => $eventStream['id'],
                ])
                ->save();
        });

        return redirect()->route('admin.railway_stations.index');
    }

    public function edit(EditRequest $request)
    {
        $railwayStation = RailwayStation::findOrFail($request->input('railway_station_id'));
        $railwayStationHistory = RailwayStationHistory::where('railway_station_id', $request->input('railway_station_id'))
            ->orderBy('id', 'desc')
            ->firstOrFail();
        $railwayStationHistoryDetails = RailwayStationHistoryDetail::where('railway_station_history_id', $railwayStationHistory['id'])
            ->get();
        $railwayStationDetail = RailwayStationDetail::whereIn('id', $railwayStationHistoryDetails->pluck('railway_station_detail_id'))
            ->orderBy('valid_from', 'desc')
            ->firstOrFail();

        return view('admin.railway_stations.edit', [
            'railwayStationId' => $railwayStation['id'],
            'initialParams' => [
                'token' => FormToken::make(),
                'valid_from' => $railwayStationDetail['valid_from'],
                'railway_line_id' => $railwayStationDetail['railway_line_id'],
                'name' => $railwayStationDetail['name'],
                'nickname' => $railwayStationDetail['nickname'],
            ]
        ]);
    }

    public function update(UpdateRequest $request)
    {
        if (UpdateModel::existsToken($request->input('token'))) {
            throw ValidationException::withMessages([
                'token' => ['このトークン使用済みです。フォームを再読み込みし、入力し直してください。'],
            ]);
        }

        $railwayRoute = RailwayLine::find($request->input('railway_line_id'));
        if ($railwayRoute === null) {
            throw ValidationException::withMessages([
                'railwayRouteId' => ['不正な鉄道路線IDです。'],
            ]);
        }

        $railwayStation = RailwayStation::findOrFail($request->input('railway_station_id'));

        (new UpdateModel())
            ->fill($request->all())
            ->fill([
                'railway_station_event_stream_id' => $railwayStation['railway_station_event_stream_id'],
                'railway_station_id' => $railwayStation['id'],
            ])->save();

        return redirect()->route('admin.railway_stations.index');
    }
}

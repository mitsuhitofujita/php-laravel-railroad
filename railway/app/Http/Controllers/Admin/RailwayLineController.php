<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FormToken;
use App\Http\Requests\RailwayLineStoreRequest as StoreRequest;
use App\Http\Requests\RailwayLineEditRequest as EditRequest;
use App\Http\Requests\RailwayLineUpdateRequest as UpdateRequest;
use App\Models\RailwayLineEventStream as EventStream;
use App\Models\RailwayLineStoreRequest as StoreModel;
use App\Models\RailwayLineUpdateRequest as UpdateModel;
use App\Models\RailwayProvider;
use App\Models\RailwayLine;
use App\Models\RailwayLineDetail;
use App\Models\RailwayLineHistory;
use App\Models\RailwayLineHistoryDetail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class RailwayLineController extends Controller
{
    public function index()
    {
        return view('admin.railway_lines.index');
    }

    public function create()
    {
        return view('admin.railway_lines.create', ['initialParams' => [
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

        $railwayProvider = RailwayProvider::find($request->input('railway_provider_id'));
        if ($railwayProvider === null) {
            throw ValidationException::withMessages([
                'railway_provider_id' => ['不正な路線会社IDです。'],
            ]);
        }

        DB::transaction(function () use ($request) {
            $eventStream = new EventStream();
            $eventStream->save();

            (new StoreModel())
                ->fill($request->all())
                ->fill([
                    'railway_line_event_stream_id' => $eventStream['id'],
                ])
                ->save();
        });

        return redirect()->route('admin.railway_lines.index');
    }

    public function edit(EditRequest $request)
    {
        $railwayRoute = RailwayLine::findOrFail($request->input('railway_line_id'));
        $railwayRouteHistory = RailwayLineHistory::where('railway_line_id', $request->input('railway_line_id'))
            ->orderBy('id', 'desc')
            ->firstOrFail();
        $railwayRouteHistoryDetails = RailwayLineHistoryDetail::where('railway_line_history_id', $railwayRouteHistory['id'])
            ->get();
        $railwayRouteDetail = RailwayLineDetail::whereIn('id', $railwayRouteHistoryDetails->pluck('railway_line_detail_id'))
            ->orderBy('valid_from', 'desc')
            ->firstOrFail();

        return view('admin.railway_lines.edit', [
            'railwayRouteId' => $railwayRoute['id'],
            'initialParams' => [
                'token' => FormToken::make(),
                'valid_from' => $railwayRouteDetail['valid_from'],
                'railway_provider_id' => $railwayRouteDetail['railway_provider_id'],
                'name' => $railwayRouteDetail['name'],
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

        $railwayProvider = RailwayProvider::find($request->input('railway_provider_id'));
        if ($railwayProvider === null) {
            throw ValidationException::withMessages([
                'railwayProviderId' => ['不正な路線会社IDです。'],
            ]);
        }

        $railwayRoute = RailwayLine::findOrFail($request->input('railway_line_id'));

        (new UpdateModel())
            ->fill($request->all())
            ->fill([
                'railway_line_event_stream_id' => $railwayRoute['railway_line_event_stream_id'],
                'railway_line_id' => $railwayRoute['id'],
            ])->save();

        return redirect()->route('admin.railway_lines.index');
    }
}

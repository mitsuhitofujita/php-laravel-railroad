<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FormToken;
use App\Http\Requests\RailwayRouteStoreRequest as StoreRequest;
use App\Http\Requests\RailwayRouteEditRequest as EditRequest;
use App\Http\Requests\RailwayRouteUpdateRequest as UpdateRequest;
use App\Models\RailwayRouteEventStream as EventStream;
use App\Models\RailwayRouteStoreRequest as StoreModel;
use App\Models\RailwayRouteUpdateRequest as UpdateModel;
use App\Models\RailwayProvider;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
use App\Models\RailwayRouteHistory;
use App\Models\RailwayRouteHistoryDetail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class RailwayRouteController extends Controller
{
    public function index()
    {
        return view('admin.railway_routes.index');
    }

    public function create()
    {
        return view('admin.railway_routes.create', ['initialParams' => [
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
                    'railway_route_event_stream_id' => $eventStream['id'],
                ])
                ->save();
        });

        return redirect()->route('admin.railway_routes.index');
    }

    public function edit(EditRequest $request)
    {
        $railwayRoute = RailwayRoute::findOrFail($request->input('railway_route_id'));
        $railwayRouteHistory = RailwayRouteHistory::where('railway_route_id', $request->input('railway_route_id'))
            ->orderBy('id', 'desc')
            ->firstOrFail();
        $railwayRouteHistoryDetails = RailwayRouteHistoryDetail::where('railway_route_history_id', $railwayRouteHistory['id'])
            ->get();
        $railwayRouteDetail = RailwayRouteDetail::whereIn('id', $railwayRouteHistoryDetails->pluck('railway_route_detail_id'))
            ->orderBy('valid_from', 'desc')
            ->firstOrFail();

        return view('admin.railway_routes.edit', [
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

        $railwayRoute = RailwayRoute::findOrFail($request->input('railway_route_id'));

        (new UpdateModel())
            ->fill($request->all())
            ->fill([
                'railway_route_event_stream_id' => $railwayRoute['railway_route_event_stream_id'],
                'railway_route_id' => $railwayRoute['id'],
            ])->save();

        return redirect()->route('admin.railway_routes.index');
    }
}

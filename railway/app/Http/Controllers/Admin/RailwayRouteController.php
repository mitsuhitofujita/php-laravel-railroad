<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FormToken;
use App\Http\Requests\StoreRailwayRouteRequest as StoreRequest;
use App\Http\Requests\EditRailwayRouteRequest as EditRequest;
use App\Http\Requests\UpdateRailwayRouteRequest as UpdateRequest;
use App\Models\RailwayRouteEventStream as EventStream;
use App\Models\StoreRailwayRouteRequest as StoreModel;
use App\Models\UpdateRailwayRouteRequest as UpdateModel;
use App\Models\RailwayProvider;
use App\Models\RailwayRoute;
use App\Models\RailwayRouteDetail;
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

        $railwayProvider = RailwayProvider::find($request->input('railwayProviderId'));
        if ($railwayProvider === null) {
            throw ValidationException::withMessages([
                'railwayProviderId' => ['不正な路線会社IDです。'],
            ]);
        }

        DB::transaction(function () use ($request) {
            $eventStream = new EventStream();
            $eventStream->save();

            (new StoreModel())->fill([
                'token' => $request->input('token'),
                'railway_route_event_stream_id' => $eventStream['id'],
                'railway_provider_id' => $request->input('railwayProviderId'),
                'name' => $request->input('name'),
            ])->save();
        });

        return view('admin.railway_routes.index');
    }

    public function edit(EditRequest $request)
    {
        $railwayRoute = RailwayRoute::findOrFail($request->input('railwayRouteId'));
        $railwayRouteDetail = RailwayRouteDetail::where(['railway_route_id' => $railwayRoute->id])->orderBy('id', 'desc')->first();

        return view('admin.railway_routes.edit', [
            'id' => $railwayRoute['id'],
            'initialParams' => [
                'token' => FormToken::make(),
                'railwayProviderId' => $railwayRouteDetail['railway_provider_id'],
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

        $railwayProvider = RailwayProvider::find($request->input('railwayProviderId'));
        if ($railwayProvider === null) {
            throw ValidationException::withMessages([
                'railwayProviderId' => ['不正な路線会社IDです。'],
            ]);
        }

        $railwayRoute = RailwayRoute::findOrFail($request->input('railwayRouteId'));

        (new UpdateModel())->fill([
            'token' => $request->input('token'),
            'railway_route_event_stream_id' => $railwayRoute['railway_route_event_stream_id'],
            'railway_route_id' => $railwayRoute['id'],
            'railway_provider_id' => $request->input('railwayProviderId'),
            'name' => $request->input('name'),
        ])->save();
        return view('admin.railway_routes.index');
    }
}

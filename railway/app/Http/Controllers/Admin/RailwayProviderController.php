<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\FormToken;
use App\Http\Requests\StoreRailwayProviderRequest as StoreRequest;
use App\Http\Requests\EditRailwayProviderRequest as EditRequest;
use App\Http\Requests\UpdateRailwayProviderRequest as UpdateRequest;
use App\Models\RailwayProviderEventStream as EventStream;
use App\Models\StoreRailwayProviderRequest as StoreModel;
use App\Models\UpdateRailwayProviderRequest as UpdateModel;
use App\Models\RailwayProvider;
use App\Models\RailwayProviderDetail;
use Illuminate\Validation\ValidationException;

class RailwayProviderController extends Controller
{
    public function index()
    {
        return view('admin.railway_providers.index');
    }

    public function create()
    {
        return view(
            'admin.railway_providers.create',
            [
                'initialValues' => [
                    'token' => FormToken::make(),
                ]
            ]
        );
    }

    public function store(StoreRequest $request)
    {
        if (StoreModel::existsToken($request->input('token'))) {
            throw ValidationException::withMessages([
                'token' => ['このトークン使用済みです。フォームを再読み込みし、入力し直してください。'],
            ]);
        }

        $eventStream = new EventStream();
        $eventStream->save();

        (new StoreModel())
            ->fill($request->all())
            ->fill([
                'railway_provider_event_stream_id' => $eventStream['id'],
            ])
            ->save();
        return redirect()->route('admin.railway_providers.index');
    }

    public function edit(EditRequest $request)
    {
        $railwayProvider = RailwayProvider::findOrFail($request->input('railway_provider_id'));

        return view('admin.railway_providers.edit', [
            'railwayProviderId' => $railwayProvider['id'],
            'initialValues' => [
                'token' => FormToken::make(),
                'valid_from' => $railwayProvider['valid_from'],
                'name' => $railwayProvider['name'],
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

        $railwayProvider = RailwayProvider::findOrFail($request->input('railway_provider_id'));

        (new UpdateModel())
            ->fill($request->all())
            ->fill([
                'railway_provider_event_stream_id' => $railwayProvider['railway_provider_event_stream_id'],
                'railway_provider_id' => $railwayProvider['id'],
            ])
            ->save();
        return redirect()->route('admin.railway_providers.index');
    }
}

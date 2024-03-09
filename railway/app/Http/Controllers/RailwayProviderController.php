<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRailwayProviderRequest as StoreRequest;
use App\Models\RailwayProviderEventStream as EventStream;
use App\Models\StoreRailwayProviderRequest as StoreModel;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RailwayProviderController extends Controller
{
    public function index()
    {
        return view('railway_providers.index');
    }

    public function create()
    {
        return view('railway_providers.create', ['initialParams' => [
            'token' => Str::random(64),
        ]]);
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

        (new StoreModel())->fill(
            array_merge(
                $request->all(),
                ['railway_provider_event_stream_id' => $eventStream['id']],
            )
        )->save();
        return view('railway_providers.index');
    }
}

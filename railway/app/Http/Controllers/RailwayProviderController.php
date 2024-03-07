<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRailwayProviderRequest;
use App\Models\RailwayProviderRequest;
use Illuminate\Support\Facades\Log;
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

    public function store(StoreRailwayProviderRequest $request)
    {
        $railwayProviderRequest = (new RailwayProviderRequest())->fill($request->all());
        if ($railwayProviderRequest->existsUniqueToken()) {
            throw ValidationException::withMessages([
                'token' => [ 'このトークン使用済みです。フォームを再読み込みし、入力し直してください。' ],
            ]);
        }
        $railwayProviderRequest->save();
        return view('railway_providers.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRailwayProviderRequest;

class RailwayProviderController extends Controller
{
    public function index()
    {
      return view('railway_providers.index');
    }

    public function create()
    {
      return view('railway_providers.create');
    }

    public function store(StoreRailwayProviderRequest $request)
    {
      return view('railway_providers.index');
    }
}

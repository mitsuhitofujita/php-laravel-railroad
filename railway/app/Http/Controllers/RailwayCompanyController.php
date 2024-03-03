<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRailwayCompanyRequest;

class RailwayCompanyController extends Controller
{
    public function index()
    {
      return view('railway_companies.index');
    }

    public function create()
    {
      return view('railway_companies.create');
    }

    public function store(StoreRailwayCompanyRequest $request)
    {
      return view('railway_companies.index');
    }
}

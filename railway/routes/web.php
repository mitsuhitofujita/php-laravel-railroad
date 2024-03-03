<?php

use App\Http\Controllers\RailwayCompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/railway_companies', [RailwayCompanyController::class, 'index'])->name('railway_companies.index');
Route::get('/railway_companies/create', [RailwayCompanyController::class, 'create'])->name('railway_companies.create');
Route::post('/railway_companies/store', [RailwayCompanyController::class, 'store'])->name('railway_companies.store');

<?php

use App\Http\Controllers\RailwayProviderController;
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

Route::get('/railway_providers', [RailwayProviderController::class, 'index'])->name('railway_providers.index');
Route::get('/railway_providers/create', [RailwayProviderController::class, 'create'])->name('railway_providers.create');
Route::post('/railway_providers/store', [RailwayProviderController::class, 'store'])->name('railway_providers.store');

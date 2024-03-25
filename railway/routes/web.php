<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\RailwayProviderController;
use App\Http\Controllers\Admin\RailwayProviderDetailController;
use App\Http\Controllers\Admin\RailwayRouteController;
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
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index.index');

    Route::prefix('/railway_providers')->name('railway_providers.')->group(function () {
        Route::get('/', [RailwayProviderController::class, 'index'])->name('index');
        Route::get('/create', [RailwayProviderController::class, 'create'])->name('create');
        Route::post('/', [RailwayProviderController::class, 'store'])->name('store');
        Route::get('/{railway_provider_id}/edit', [RailwayProviderController::class, 'edit'])->name('edit');
        Route::put('/{railway_provider_id}', [RailwayProviderController::class, 'update'])->name('update');
    });
    Route::prefix('/railway_routes')->name('railway_routes.')->group(function () {
        Route::get('/', [RailwayRouteController::class, 'index'])->name('index');
        Route::get('/create', [RailwayRouteController::class, 'create'])->name('create');
        Route::post('/', [RailwayRouteController::class, 'store'])->name('store');
        Route::get('/{railwayRouteId}/edit', [RailwayRouteController::class, 'edit'])->name('edit');
        Route::put('/{railwayRouteId}', [RailwayRouteController::class, 'update'])->name('update');
    });
    // Route::prefix('/railway_stations')->name('railway_stations.')->group(function () {
    //     Route::get('/', [RailwayStationController::class, 'index'])->name('index');
    //     Route::get('/create', [RailwayStationController::class, 'create'])->name('create');
    //     Route::post('/', [RailwayStationController::class, 'store'])->name('store');
    //     Route::get('/{railwayStationId}/edit', [RailwayStationController::class, 'edit'])->name('edit');
    //     Route::put('/{railwayStationId}', [RailwayStationController::class, 'update'])->name('update');
    // });
});

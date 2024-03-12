<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\RailwayProviderController;
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
Route::prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('admin.index.index');
    Route::get('/railway_providers', [RailwayProviderController::class, 'index'])->name('admin.railway_providers.index');
    Route::get('/railway_providers/create', [RailwayProviderController::class, 'create'])->name('admin.railway_providers.create');
    Route::post('/railway_providers', [RailwayProviderController::class, 'store'])->name('admin.railway_providers.store');
    Route::get('/railway_providers/{id}/edit', [RailwayProviderController::class, 'edit'])->name('admin.railway_providers.edit');
    Route::put('/railway_providers/{id}', [RailwayProviderController::class, 'update'])->name('admin.railway_providers.update');
});

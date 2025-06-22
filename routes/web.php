<?php

use App\Http\Controllers\Admin\CarpinteriaController;
use App\Http\Controllers\Admin\ConsultaController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\SerieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('consultas', [ConsultaController::class, 'store'])->name('consultas.store');

Route::prefix('/dashboard')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', function () {
        return redirect()->route('consultas.index');
    })->name('dashboard');
    Route::resource('consultas', ConsultaController::class)->except(['store', 'create','edit','update']);
    Route::resource('carpinterias', CarpinteriaController::class)->except(['show']);
    Route::resource('carpinterias.productos', ProductoController::class)->shallow();
    Route::resource('series', SerieController::class)->except(['show'])->parameters(['series' => 'serie']);
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\TipoProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('/dashboard')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', function () {
        return redirect()->route('productos.index');
    })->name('dashboard');
    Route::resource('productos', ProductoController::class);
    Route::resource('tipos', TipoProductoController::class);
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\Admin\CarpinteriaController;
use App\Http\Controllers\Admin\ConsultaController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProductoSerieController;
use App\Http\Controllers\Admin\SerieController;
use App\Http\Controllers\Admin\TrabajoController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/productos/{any}', function () {
    return view('welcome'); //ya no busca rutas internas pasa el control a React
})->where('any', '.*');

Route::post('consultas', [ConsultaController::class, 'store'])->name('consultas.store');

Route::prefix('/dashboard')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', function () {
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->esEmpleado())) {
            return redirect()->route('consultas.index');
        } else {
            return redirect()->route('welcome');
        }
    })->name('dashboard');
    Route::resource('consultas', ConsultaController::class)->except(['store', 'create','edit','update']);
    Route::resource('carpinterias', CarpinteriaController::class)->except(['show']);
    Route::resource('carpinterias.productos', ProductoController::class)->except(['show'])->shallow();
    Route::resource('productos.series', ProductoSerieController::class)->parameters(['series' => 'serie']);
    Route::resource('series', SerieController::class)->except(['show'])->parameters(['series' => 'serie']);
    Route::resource('trabajos', TrabajoController::class)->except(['show']);
    Route::resource('usuarios', UserController::class)->except(['create','store','show','destroy'])->parameters(['usuarios' => 'user']);
});

require __DIR__.'/auth.php';

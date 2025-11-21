<?php

use App\Http\Controllers\Admin\CarpinteriaController;
use App\Http\Controllers\Admin\ConsultaController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProductoSerieController;
use App\Http\Controllers\Admin\SerieController;
use App\Http\Controllers\Admin\TrabajoController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { //vista principal
    return view('welcome');
})->name('welcome');

Route::get('/productos/{any}', function () {
    return view('welcome'); //ya no busca rutas internas pasa el control a React
})->where('any', '.*');

Route::post('consultas', [ConsultaController::class, 'store'])->name('consultas.store'); //ruta para mandar la consulta del cliente

Route::prefix('/dashboard')->middleware(['auth'])->group(function() { //rutas dashboard protegidas
    Route::get('/', function () {
        if(Auth::user()->rol_id === null) { //si el rol_id es null entonces se la cierra y le retorna la vista de login esto pasa cuando se desactiva el usuario Empleado
            Auth::logout();
            return view('auth.login');
        }
        if(Auth::user()->isAdmin()) {
            return redirect()->route('consultas.index'); //si su rol es administrador lleva a consultas
        } else {
            return redirect()->route('carpinterias.index'); //si su rol no es administrador lleva a carpinterías
        }
    })->name('dashboard');
    //resource para generar las rutas de los recursos automáticamente y except para excluir ciertas rutas del conjunto
    Route::resource('consultas', ConsultaController::class)->except(['store', 'create','edit','update']);
    Route::resource('carpinterias', CarpinteriaController::class)->except(['show']);
    Route::resource('carpinterias.productos', ProductoController::class)->except(['show'])->shallow();
    Route::resource('productos.series', ProductoSerieController::class)->parameters(['series' => 'serie']);
    Route::resource('series', SerieController::class)->except(['show'])->parameters(['series' => 'serie']);
    Route::resource('trabajos', TrabajoController::class)->except(['show']);
    Route::resource('horarios', HorarioController::class)->except(['create', 'store', 'show']);
    Route::resource('usuarios', UserController::class)->except(['create','store','show'])->parameters(['usuarios' => 'user']);
});

require __DIR__.'/auth.php'; //incluye el archivo de rutas de auth para el login

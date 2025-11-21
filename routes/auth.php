<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () { //para usuarios no autenticados...
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login'); //muestra el formulario de login

    Route::post('login', [AuthenticatedSessionController::class, 'store']); //procesa el formulario de login
});

Route::middleware('auth')->group(function () { //para usuarios autenticados...
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout'); //cierra la sesión del usuario
});
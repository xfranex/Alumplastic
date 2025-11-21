<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarpinteriaController;
use App\Http\Controllers\API\ProductoController;

//prefix api/v1
Route::prefix('v1')->middleware('token.api')->group(function() {
    Route::get('/carpinterias', [CarpinteriaController::class, 'carpinterias']); //obtiene las carpinterías
    Route::get('/carpinterias/{carpinteria}/productos', [CarpinteriaController::class, 'productos']); //obtiene los productos de una carpintería
    Route::get('/productos/{producto}/series', [ProductoController::class,'series']); //obtiene las series de un producto
    Route::get('/productos/{producto}/series/{serie}', [ProductoController::class, 'virsualizar']); //obtiene la información de una serie en concreto de un producto
});
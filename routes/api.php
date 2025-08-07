<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarpinteriaController;
use App\Http\Controllers\API\ProductoController;

//prefix api/v1
Route::prefix('v1')->middleware('token.api')->group(function() {
    Route::get('/carpinterias', [CarpinteriaController::class, 'carpinterias']);
    Route::get('/carpinterias/{carpinteria}/productos', [CarpinteriaController::class, 'productos']);
    Route::get('/productos/{producto}/series', [ProductoController::class,'series']);
    Route::get('/productos/{producto}/series/{serie}', [ProductoController::class, 'virsualizar']);
});
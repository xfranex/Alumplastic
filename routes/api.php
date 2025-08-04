<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CarpinteriaController;
use App\Http\Controllers\API\ProductoController;

//prefix api/v1
Route::prefix('v1')->middleware('token.api')->group(function() {
    Route::get('/carpinterias', [CarpinteriaController::class, 'index']);
    Route::get('/carpinterias/{id}/productos', [CarpinteriaController::class, 'productos']);
    Route::get('/productos/{id}/series', [ProductoController::class,'series']);
});
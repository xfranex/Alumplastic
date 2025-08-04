<?php

use Illuminate\Support\Facades\Route;

//prefix api/v1
Route::prefix('v1')->group(function() {
    Route::get('/', function () {
        return response()->json(['mensaje' => 'API publica funcionando']);
    });
});
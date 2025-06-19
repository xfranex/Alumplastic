<?php

use Illuminate\Support\Facades\Route;

//prefix api
Route::get('/mensaje', function () {
    return response()->json(['mensaje' => 'API funcionando']);
});
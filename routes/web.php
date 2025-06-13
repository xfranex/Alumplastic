<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('/dashboard')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/', function () {
        return redirect()->route('productos.index');
    })->name('dashboard');
});

require __DIR__.'/auth.php';

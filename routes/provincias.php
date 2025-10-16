<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvinciaController;

Route::prefix('provincias')->group(function () {
    Route::get('/', [ProvinciaController::class, 'obtenerProvincias']);
    Route::get('/{codigo}',[ProvinciaController::class,'obtenerLocalidadesPorProvincia']);
});
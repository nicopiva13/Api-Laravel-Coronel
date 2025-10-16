<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalidadController;

Route::prefix('localidades')->group(function () {
    Route::get('/', [LocalidadController::class, 'obtenerLocalidades']);
    Route::get('/{codigo}',[LocalidadController::class,'obtenerLocalidadesPorProvincia']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogisticaController;

Route::prefix('logistica')->group(function () {
    Route::get('/', [LogisticaController::class, 'obtenerClientes']);
    Route::get('/{codigo}',[LogisticaController::class,'obtenerClientesPorCodigo']);
});
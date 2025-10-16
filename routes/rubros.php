<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RubroController;

Route::prefix('rubros')->group(function () {
    Route::get('/', [RubroController::class, 'obtenerRubros']);
    Route::get('/{codigo}', [RubroController::class, 'obtenerArticulosPorRubro']);
});
Route::get('/rubrosxlinea/{linea}', [RubroController::class, 'obtenerRubrosPorLinea']);
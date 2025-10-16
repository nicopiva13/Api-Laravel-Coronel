<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondIvaController;

Route::prefix('CondicionIva')->group(function () {
    Route::get('/', [CondIvaController::class, 'obtenerCondicionesIva']);
    Route::get('/{id}',[CondIvaController::class,'obtenerCondicionIva']);
});
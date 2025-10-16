<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovimientoController;

Route::get('/movimiento/{codigo}', [MovimientoController::class, 'obtenerMovimientos']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransporteController;

Route::get('/transporte', [TransporteController::class, 'obtenerTransporte']);

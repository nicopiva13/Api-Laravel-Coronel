<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondVtaController;

Route::get('/condvta', [CondVtaController::class, 'obtenerCondVta']);
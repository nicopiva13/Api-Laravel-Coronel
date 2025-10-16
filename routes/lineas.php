<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LineaController;

Route::get('/lineas/{marca}', [LineaController::class, 'obtenerLineas']);
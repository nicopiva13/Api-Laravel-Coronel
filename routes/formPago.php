<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormPagoController;

Route::get('/formpago', [FormPagoController::class, 'obtenerFormasDePago']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrecioController;

Route::get('/precio', [PrecioController::class, 'obtenerPrecio']);
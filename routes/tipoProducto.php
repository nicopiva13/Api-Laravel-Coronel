<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoProductoController;

Route::get('/tipoProducto', [TipoProductoController::class, 'obtenerTiposProducto']);
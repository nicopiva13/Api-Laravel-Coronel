<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;

Route::get('/marcas', [MarcaController::class, 'obtenerMarcas']);
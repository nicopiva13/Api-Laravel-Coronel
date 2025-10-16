<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Novedad\NovedadObtenerNovedadesController;
use App\Http\Controllers\Novedad\NovedadObtenerTiposDeNovedadController;


Route::get('/obtenerNovedades', [NovedadObtenerNovedadesController::class, 'obtenerNovedades']);
Route::get('/obtenerCategoriasNovedades', [NovedadObtenerTiposDeNovedadController::class, 'obtenerCategoriasEnNovedad']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfertaObtenerOfertaController;
use App\Http\Controllers\OfertaArticuloEnOfertaController;
use App\Http\Controllers\OfertaArticulosEnOFertaSegunCategoriaController;
use App\Http\Controllers\OfertaObtenerCategoriasOfertaController;
use App\Http\Controllers\OfertaVerificarOfertaController;

Route::get('/ofertas', [OfertaObtenerOfertaController::class, 'obtenerOfertas']);
Route::get('/categoriasOferta', [OfertaObtenerCategoriasOfertaController::class, 'obtenerCategoriaOferta']);
Route::get('/ofertasArticulos', [OfertaArticulosEnOFertaSegunCategoriaController::class, 'articulosEnOfertaSegunCategoria']);
Route::get('/articulosOfertas', [OfertaArticuloEnOfertaController::class, 'articuloEnOferta']);
Route::get('/verificarOferta', [OfertaVerificarOfertaController::class, 'verificarOferta']);
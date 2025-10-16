<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Articulo\ArticuloObtenerArticuloController;
use App\Http\Controllers\Articulo\ArticuloObtenerArticuloAdicionalController;
use App\Http\Controllers\Articulos\ArticulosObtenerArticulosController;
use App\Http\Controllers\Articulos\ArticulosObtenerArticulosPorCategoriayRubroController;
use App\Http\Controllers\Articulos\ArticulosObtenerArticulosFiltradosController;
use App\Http\Controllers\Articulos\ArticulosObtenerArticulosPorFabricaController;
use App\Http\Controllers\Articulos\ArticulosObtenerArticulosPorRubroController;
use App\Http\Controllers\Articulos\ArticulosObtenerArticulosDescriController;
use App\Http\Controllers\Articulos\ArticulosObtenerArticulosNovedadController;
use App\Http\Controllers\Articulos\ArticulosListarPreciosController;

Route::get('/articulos', [ArticulosObtenerArticulosController::class, 'obtenerArticulos']);
Route::get('/artic2/{fabrica}/{codigo}/{clicod}/{BanderaVen}/{cli_categoria}', [ArticuloObtenerArticuloController::class, 'obtenerArticulo']);
Route::get('/artic2/{fabrica}/{codigo}/{adicional}/{clicod}/{BanderaVen}/{cli_categoria}', [ArticuloObtenerArticuloAdicionalController::class, 'obtenerArticuloAdicional']);
Route::get('/articulosxrubro/{rubro}/{usu_clicod}/{BanderaVen}/{cli_categoria}', [ArticulosObtenerArticulosPorRubroController::class, 'obtenerArticulosPorRubro']);
Route::get('/articulosNovedad/{tipoCliente}/{tipoBusq}/{cat}/{fec1}/{fec2}', [ArticulosObtenerArticulosNovedadController::class,'obtenerArticulosNovedad']);
Route::get('/articulosCategoriaRubro', [ArticulosObtenerArticulosPorCategoriayRubroController::class, 'obtenerArticulosPorCategoriayRubro']);
Route::get('/articulos/{fabrica}', [ArticulosObtenerArticulosPorFabricaController::class, 'obtenerArticulosPorFabrica']);
Route::get('/articulosfiltrados/{marca}/{linea}/{rubro}/{categoria}/{fecdesde}/{fechasta}', [ArticulosObtenerArticulosFiltradosController::class, 'obtenerArticulosFiltrados']);
Route::get('/articulosDescri/{fabrica}/{codigo}', [ArticulosObtenerArticulosDescriController::class, 'obtenerArticulosDescri']);
Route::get('/listaPrecios/{fabrica}', [ArticulosListarPreciosController::class, 'listaPrecios']);
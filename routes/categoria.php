<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Categorias\CategoriaObtenerCategoriasController;
use App\Http\Controllers\Categorias\CategoriaObtenerCategoriasPorTipoProductoController;
use App\Http\Controllers\Categorias\CategoriaObtenerCategoriasPorRubroController;
use App\Http\Controllers\Categorias\CategoriaObtenerCategoriasPorLineaController;
use App\Http\Controllers\Categorias\CategoriaObtenerCategoriasPorFabricaController;
use App\Http\Controllers\Categorias\CategoriaObtenerCategoriasPorRubrosController;


Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaObtenerCategoriasController::class, 'obtenerCategorias']);
    Route::get('/{tipoProducto}', [CategoriaObtenerCategoriasPorTipoProductoController::class, 'obtenerCategoriasPorTipoProducto']);
    Route::get('/{tipoProducto}/{rubro}', [CategoriaObtenerCategoriasPorRubroController::class, 'obtenerCategoriasPorRubro']);
    Route::get('/{tipoProducto}/{rubro}/{linea}', [CategoriaObtenerCategoriasPorLineaController::class, 'obtenerCategoriasPorLinea']);
    Route::get('/{tipoProducto}/{rubro}/{linea}/{fabrica}', [CategoriaObtenerCategoriasPorFabricaController::class, 'obtenerCategoriasPorFabrica']);
});
Route::get('/categoriasxrubro/{rubro}', [CategoriaObtenerCategoriasPorRubrosController::class, 'obtenerCategoriasPorRubros']);
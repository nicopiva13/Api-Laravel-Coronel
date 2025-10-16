<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cliente\ClienteObtenerClienteController;
use App\Http\Controllers\Cliente\ClienteObtenerClientesController;
use App\Http\Controllers\Cliente\ClienteObtenerDatosClienteController;
use App\Http\Controllers\Cliente\ClienteObtenerCondicionClienteController;
use App\Http\Controllers\Cliente\ClienteEstadoFacturacionClienteController;
use App\Http\Controllers\Cliente\ClienteCambiarEstadoFacturacionController;
use App\Http\Controllers\Cliente\ClienteActualizarClienteClienteController;

Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteObtenerClientesController::class, 'obtenerClientes']);
    Route::get('/{codigo}',[ClienteObtenerClienteController::class,'obtenerCliente']);
});
Route::get('/DatosClientePDF/{NumCliente}', [ClienteObtenerDatosClienteController::class, 'obtenerDatosCliente']);
Route::get('/condicionCliente', [ClienteObtenerCondicionClienteController::class, 'obtenerCondicionCliente']);
Route::get('/EstadoFacturacionCliente/{cli_codigo}', [ClienteEstadoFacturacionClienteController::class, 'estadoFacturacionCliente']);
Route::put('/CambiarEstadoFacturacion/{cli_codigo}', [ClienteCambiarEstadoFacturacionController::class, 'cambiarEstadoFacturacion']);
Route::put('/registroCliente/{id}', [ClienteActualizarClienteClienteController::class, 'actualizarCliente']);
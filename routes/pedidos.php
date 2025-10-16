<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;

Route::get('/pedidos/{codigo}', [PedidoController::class, 'obtenerPedidosPorCodigo']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumenDeCuentaClienteController;
use App\Http\Controllers\ResumenDeCuentaVendedorController;

Route::get('/resumenDeCuenta', [ResumenDeCuentaClienteController::class, 'resumenCliente']);
Route::get('/resumenDeCuentaVendedor', [ResumenDeCuentaVendedorController::class, 'resumenVendedor']);
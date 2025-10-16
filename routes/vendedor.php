<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendedorController;

Route::get('/vendedores', [VendedorController::class, 'obtenerVendedores']);
Route::get('/ClientesDelVendedor', [VendedorController::class, 'clientesDelVendedor']);
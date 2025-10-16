<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;

Route::get('/empresa', [EmpresaController::class, 'obtenerEmpresa']);
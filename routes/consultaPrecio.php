<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaPrecioController;

Route::get('/consultaPrecio/{codtex}/{codnum}/{adicod?}', [ConsultaPrecioController::class, 'consultaPrecio']);
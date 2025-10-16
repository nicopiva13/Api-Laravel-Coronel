<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ValidarVigenciaController;

Route::get('/validar/{art_codnum}/{art_codtex}/{art_adicod?}', [ValidarVigenciaController::class, 'validarVigencia']);
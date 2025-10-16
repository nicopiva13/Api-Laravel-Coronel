
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParametroController;

Route::get('/parametros', [ParametroController::class, 'obtenerParametros']);
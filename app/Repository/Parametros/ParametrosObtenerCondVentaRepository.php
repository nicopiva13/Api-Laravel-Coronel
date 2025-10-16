<?php

namespace App\Repository\Parametros;

use Illuminate\Support\Facades\DB;

class ParametrosObtenerCondVentaRepository
{
    public function obtenerCondVenta()
    {
        return DB::table('Parametro')
            ->select('par_apliFormaPago as CondVenta')
            ->first();
    }
}
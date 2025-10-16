<?php

namespace App\Repository\Transporte;

use Illuminate\Support\Facades\DB;

class TipoProductoObtenerTiposProductosRepository
{
    public function obtenerTiposProducto()
    {
        return DB::table('TipProd')
            ->select('tpp_codigo', 'tpp_descri')
            ->get();
    }
}
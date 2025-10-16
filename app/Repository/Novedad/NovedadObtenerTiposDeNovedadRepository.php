<?php

namespace App\Repository\Novedad;

use Illuminate\Support\Facades\DB;

class NovedadObtenerTiposDeNovedadRepository
{
    public function obtenerTiposDeNovedades()
    {
        return DB::table('Articulo')
            ->leftJoin('TipProd', 'Articulo.art_tipprod', '=', 'TipProd.tpp_codigo')
            ->where('Articulo.art_vigencia', 1)
            ->where('Articulo.art_carrito', 1)
            ->where('Articulo.art_novedadWEB', 1)
            ->groupBy('TipProd.tpp_descri', 'TipProd.tpp_codigo')
            ->orderBy('TipProd.tpp_descri', 'asc')
            ->select('TipProd.tpp_descri', 'TipProd.tpp_codigo')
            ->get();
    }
}
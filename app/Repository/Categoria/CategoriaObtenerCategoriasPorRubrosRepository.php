<?php

namespace App\Repository\Categoria;

use Illuminate\Support\Facades\DB;

class CategoriaObtenerCategoriasPorRubrosRepository
{
    public function obtenerCategoriasPorRubros($rubro)
    {
        return DB::table('TipProd')
            ->join('Articulo', 'Articulo.art_tipprod', '=', 'TipProd.tpp_codigo')
            ->where('Articulo.art_rubro', $rubro)
            ->select('tpp_codigo', 'tpp_descri')
            ->distinct()
            ->get();
    }
}
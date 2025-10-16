<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticulosPorRubroRepository
{
    public function obtenerArticulosPorRubro($codigo)
    {
        return DB::table('Articulo')
            ->where('art_rubro', $codigo)
            ->select('art_codtex', 'art_codnum', 'art_descri', 'art_linea', 'art_rubro', 'art_codbarra')
            ->get();
    }
}
<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticulosPorFabricaRepository
{
    public function obtenerArticulosPorFabrica($fabrica)
    {
        $articulos = DB::table('articulo')
            ->where('art_codtex', $fabrica)
            ->where('art_vigencia', 1)
            ->where('art_carrito', 1)
            ->select(
                'art_codtex',
                'art_codnum',
                'art_linea',
                'art_rubro',
                'art_codbarra',
                DB::raw('ISNULL(art_CtrlMayoWEB, 0) AS art_CtrlMayo'),
                DB::raw('ISNULL(art_CtrlMinoWEB, 0) AS art_CtrlMino')
            )
            ->get();

        return response()->json($articulos, 200);
    }
}
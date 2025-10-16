<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloListarPrecioArticulosRepository
{
    public function listaPreciosArticulos($fabrica)
    {
        if ($fabrica == 'CAN') {
            $lineas = DB::table('Articulo')
                ->where('art_carrito', 1)
                ->where('art_vigencia', 1)
                ->select('art_codtex', 'art_codnum', 'art_descri', 'art_codbarra', 'art_preclista', 'art_aliva')
                ->orderBy('art_codtex', 'ASC')
                ->get();
        } else {
            $lineas = DB::table('Articulo')
                ->where('art_tipprod', $fabrica)
                ->where('art_carrito', 1)
                ->where('art_vigencia', 1)
                ->select('art_codtex', 'art_codnum', 'art_descri', 'art_codbarra', 'art_preclista', 'art_aliva')
                ->orderBy('art_tipprod', 'ASC')
                ->get();
        }
        return $lineas;
    }
}
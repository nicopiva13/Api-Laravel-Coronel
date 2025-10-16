<?php

namespace App\Repository\Novedad;

use Illuminate\Support\Facades\DB;

class NovedadContarCantidadNovededRepository
{
    public function cantidadNovedad($condicionTipoProd)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM Articulo
                LEFT JOIN AdicionalxArtic 
                  ON Articulo.art_codtex = AdicionalxArtic.ada_codtex 
                 AND Articulo.art_codnum = AdicionalxArtic.ada_codnum 
                 AND AdicionalxArtic.ada_vigencia = 1
                WHERE Articulo.art_vigencia = 1 
                  AND Articulo.art_carrito = 1 
                  AND Articulo.art_novedadWEB = 1
                  $condicionTipoProd";

        $result = DB::selectOne($sql);

        return (int) $result->total;
    }
}
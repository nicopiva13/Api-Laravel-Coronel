<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloContarArticuloRepository
{
    public function contarArticulo($COND)
    {
        $sql_cant = " SELECT COUNT(*) AS total FROM Articulo
        LEFT JOIN AdicionalxArtic ON (Articulo.art_codtex = AdicionalxArtic.ada_codtex AND Articulo.art_codnum = AdicionalxArtic.ada_codnum AND AdicionalxArtic.ada_vigencia=1)
        WHERE Articulo.art_vigencia=1 AND art_carrito = 1 $COND";

        return DB::select($sql_cant);
    }
}
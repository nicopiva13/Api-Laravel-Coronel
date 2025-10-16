<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticuloPrecioRepository
{
    public function obtenerArticuloPrecio($codtex, $codnum, $columnaprecio, $cantdecimales, $datos)
    {
        $precioSQL = DB::raw("ROUND($columnaprecio, 
           CASE WHEN ISNULL(art_decimales,'') = '' THEN $cantdecimales 
           ELSE LEN(ISNULL(art_decimales,'')) END) AS precio");

        $query = DB::table('articulo')
            ->select('art_codtex', 'art_codnum', 'art_rubro', 'art_linea', 'art_aliva', 'art_preclista', $precioSQL)
            ->where('art_vigencia', 1)
            ->where('art_carrito', 1)
            ->where('art_codtex', $codtex)
            ->where('art_codnum', $codnum);

        if (!empty($datos->joinAdicional)) {
            $query->leftJoin(DB::raw('AdicionalxArtic'), function ($join) {
                $join->on('Articulo.art_codtex', '=', 'AdicionalxArtic.ada_codtex')
                    ->on('Articulo.art_codnum', '=', 'AdicionalxArtic.ada_codnum');
            });
        }

        if (!empty($datos->filtroAdicional)) {
            $query->whereRaw($datos->filtroAdicional);
        }

        $articulo = $query->first();

        if ($articulo) {
            return [
                'fabrica'     => $articulo->art_codtex,
                'articulo'    => $articulo->art_codnum,
                'rubro'       => $articulo->art_rubro,
                'linea'       => $articulo->art_linea,
                'precioLista' => $articulo->art_preclista,
                'precio'      => $articulo->precio,
                'iva'         => $articulo->art_aliva
            ];
        } else {
            return null;
        }
    }
}
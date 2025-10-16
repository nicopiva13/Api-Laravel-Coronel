<?php

namespace App\Helper\Precios;

class ConstruirJoinYFiltros{

    public function construirJoinYFiltro(object $datos): object
    {
        return (object) [
            'joinAdicional' => self::generarJoin($datos),
            'filtroAdicional' => self::generarFiltro($datos),
        ];
    }

    private static function generarJoin(object $datos): string
    {
        if (empty($datos->adicod)) {
            return '';
        }

        return " LEFT JOIN AdicionalxArtic ON Articulo.art_codtex = AdicionalxArtic.ada_codtex AND Articulo.art_codnum = AdicionalxArtic.ada_codnum";
    }

    private static function generarFiltro(object $datos): string
    {
        if (empty($datos->adicod)) {
            return '';
        }

        $adicod = str_replace("'", "''", $datos->adicod);
        return " AND REPLACE(AdicionalxArtic.ada_adicional, '/', '-') = '$adicod' AND AdicionalxArtic.ada_vigencia = 1";
    }
    
    // private function obtenerJoinYFiltroAdicional($datos)
    // {
    //     $resultado = new \stdClass();
    //     $resultado->joinAdicional = '';
    //     $resultado->filtroAdicional = '';

    //     if (!empty($datos->adicod)) {
    //         $resultado->joinAdicional = " LEFT JOIN AdicionalxArtic ON Articulo.art_codtex = AdicionalxArtic.ada_codtex AND Articulo.art_codnum = AdicionalxArtic.ada_codnum";
    //         $resultado->filtroAdicional = " AND REPLACE(AdicionalxArtic.ada_adicional, '/', '-') = '$datos->adicod' AND AdicionalxArtic.ada_vigencia = 1";
    //     }

    //     return $resultado;
    // }
}
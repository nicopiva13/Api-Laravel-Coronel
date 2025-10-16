<?php

namespace App\Repository\Vigencia;

use Illuminate\Support\Facades\DB;

class ValidarVigenciaRepository
{
    public function validarVigencia($art_codnum, $art_codtex, $art_adicod)
    {
        $query = DB::table('Articulo')
            ->select('art_vigencia')
            ->where('art_vigencia', 1)
            ->where('art_carrito', 1)
            ->where('art_codnum', $art_codnum)
            ->where('art_codtex', $art_codtex);

        if (!empty($art_adicod) && $art_adicod != 0) {
            $query->leftJoin('AdicionalxArtic', function ($join) {
                $join->on('Articulo.art_codtex', '=', 'AdicionalxArtic.ada_codtex')
                    ->on('Articulo.art_codnum', '=', 'AdicionalxArtic.ada_codnum');
            })
                ->whereRaw("REPLACE(AdicionalxArtic.ada_adicional, '/', '-') = ?", [$art_adicod])
                ->where('AdicionalxArtic.ada_vigencia', 1)
                ->addSelect(DB::raw("CASE WHEN AdicionalxArtic.ada_vigencia IS NULL THEN '' ELSE AdicionalxArtic.ada_vigencia END AS ada_vigencia"));
        }

        return $query->get();
    }
}
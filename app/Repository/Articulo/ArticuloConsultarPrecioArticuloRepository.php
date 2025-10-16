<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloConsultarPrecioArticuloRepository
{
    public function consultaPrecio($codtex, $codnum, $adicod, $hostIMG)
    {
        return DB::table('Articulo as a')
            ->leftJoin('AdicionalxArtic as axa', function ($join) {
                $join->on('axa.ada_codtex', '=', 'a.art_codtex')
                    ->on('axa.ada_codnum', '=', 'a.art_codnum');
            })
            ->leftJoin('Adicional as ad', 'axa.ada_adicional', '=', 'ad.adi_codigo')
            ->leftJoin('Medida as m', 'a.art_medida', '=', 'm.med_codigo')
            ->leftJoin('TipEmbalaje as te', 'a.art_tipemb', '=', 'te.tem_codigo')
            ->leftJoin('Ubicacion as u', function ($join) {
                $join->on('u.ubi_codtex', '=', 'a.art_codtex')
                    ->on('u.ubi_codnum', '=', 'a.art_codnum')
                    ->whereRaw("COALESCE(u.ubi_adicional, '') = COALESCE(axa.ada_adicional, '')")
                    ->where('u.ubi_predef', '=', 1);
            })
            ->select([
                'a.*',
                DB::raw("u.ubi_ubica1 + '-' + u.ubi_ubica2 + '-' + u.ubi_ubica3 + '-' + u.ubi_ubica4 AS Ubi"),
                DB::raw("ROUND(a.art_precmayo * 1.21, 2) AS art_precmayo"),
                DB::raw("ROUND(a.art_precmino * 1.21, 2) AS art_precmino"),
                DB::raw("REPLACE(a.art_pathfoto, 'Z:\\SISTEMAS\\CORONEL\\FOTOS\\', '$hostIMG') AS art_pathfoto")
            ])
            ->where('a.art_codtex', $codtex)
            ->where('a.art_codnum', $codnum)
            ->when(!empty($adicod) && $adicod !== "false", function ($query) use ($adicod) {
                return $query->where('axa.ada_adicional', $adicod);
            })
            ->get();
    }
}
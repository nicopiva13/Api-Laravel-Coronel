<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticulosFiltradosRepository
{
    public function obtenerArticulosFiltrados($marca, $linea, $rubro, $categoria, $fecdesde, $fechasta)
    {
        return DB::table('articulo')
            ->join('adicionalxartic', 'articulo.art_codtex', '=', 'adicionalxartic.ada_codtex')
            ->join('RubxLineaxFabrica', 'articulo.art_codtex', '=', 'RubxLineaxFabrica.rlf_fabrica')
            ->join('adicional', 'adicional.adi_codigo', '=', 'adicionalxartic.ada_adicional')
            ->leftJoin('Ubicacion', function ($join) {
                $join->on('articulo.art_codtex', '=', 'Ubicacion.ubi_codtex')
                    ->on('articulo.art_codnum', '=', 'Ubicacion.ubi_codnum')
                    ->whereRaw("COALESCE(AdicionalxArtic.ada_adicional, '') = COALESCE(Ubicacion.ubi_adicional, '')")
                    ->where('Ubicacion.ubi_predef', '=', 1);
            })
            ->select(
                'articulo.art_codtex',
                'articulo.art_codnum',
                'articulo.art_descri',
                'adicional.adi_descri',
                'articulo.art_codfab',
                DB::raw("ISNULL(Ubicacion.ubi_ubica1 + '-' + Ubicacion.ubi_ubica2 + '-' + Ubicacion.ubi_ubica3 + '-' + Ubicacion.ubi_ubica4, 'NO TIENE') AS Ubicacion"),
                'adicionalxartic.ada_adicional'
            )
            ->where('articulo.art_codtex', $marca)
            ->where('RubxLineaxFabrica.rlf_linea', $linea)
            ->where('RubxLineaxFabrica.rlf_rubro', $rubro)
            ->where('articulo.art_tipprod', $categoria)
            ->whereBetween('articulo.art_fecalta', [$fecdesde, $fechasta])
            ->get();
    }
}
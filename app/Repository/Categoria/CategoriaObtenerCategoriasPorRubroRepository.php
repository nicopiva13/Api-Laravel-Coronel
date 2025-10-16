<?php

namespace App\Repository\Categoria;

use Illuminate\Support\Facades\DB;

class CategoriaObtenerCategoriasPorRubroRepository
{
    public function obtenerCategoriasPorRubro($tipoProducto, $rubro)
    {
        return DB::table('articulo as a')
            ->join('tipprod as tpp', 'a.art_tipprod', '=', 'tpp.tpp_codigo')
            ->join('rubro as r', 'a.art_rubro', '=', 'r.rub_codigo')
            ->join('RubxLineaxFabrica as rlf', function ($join) {
                $join->on('a.art_codtex', '=', 'rlf.rlf_fabrica')
                    ->on('a.art_linea', '=', 'rlf.rlf_linea')
                    ->where('rlf.rlf_rubro', '=', '0');
            })
            ->select(
                'rlf.rlf_linea as id',
                'rlf.rlf_lindescri as nombre',
                DB::raw('COUNT(*) as total'),
                'tpp.tpp_codigo as tppCodigo',
                'tpp.tpp_descri as tipoProducto',
                'r.rub_codigo as rubCodigo',
                'r.rub_descri as rubro'
            )
            ->where('a.art_vigencia', 1)
            ->where('a.art_carrito', 1)
            ->where('a.art_rubro', $rubro)
            ->where('a.art_tipprod', $tipoProducto)
            ->groupBy('tpp.tpp_codigo', 'tpp.tpp_descri', 'r.rub_codigo', 'r.rub_descri', 'rlf.rlf_linea', 'rlf.rlf_lindescri')
            ->orderBy('rlf.rlf_lindescri', 'ASC')
            ->get();
    }
}
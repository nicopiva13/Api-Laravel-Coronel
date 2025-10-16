<?php

namespace App\Repository\Categoria;

use Illuminate\Support\Facades\DB;

class CategoriaObtenerCategoriasPorTipoProductoRepository
{
    public function obtenerCategoriasPorTipoProducto($tipoProducto)
    {
        $categorias = DB::table('articulo as a')
            ->join('tipprod as tpp', 'a.art_tipprod', '=', 'tpp.tpp_codigo')
            ->join('rubro as r', 'a.art_rubro', '=', 'r.rub_codigo')
            ->select(
                'a.art_rubro as id',
                'r.rub_descri as nombre',
                DB::raw('COUNT(a.art_descri) as total'),
                'tpp.tpp_codigo as tppCodigo',
                'tpp.tpp_descri as tipoProducto'
            )
            ->where('a.art_vigencia', 1)
            ->where('a.art_carrito', 1)
            ->where('a.art_tipprod', $tipoProducto)
            ->groupBy('tpp.tpp_codigo', 'tpp.tpp_descri', 'a.art_rubro', 'r.rub_descri')
            ->orderBy('r.rub_descri', 'ASC')
            ->get();

        if ($categorias->isEmpty()) {
            return response()->json(['message' => 'No existen artículos de ese rubro en la BD'], 404);
        }

        return $categorias;
    }
}
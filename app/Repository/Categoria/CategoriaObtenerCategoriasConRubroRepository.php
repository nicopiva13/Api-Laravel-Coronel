<?php

namespace App\Repository\Categoria;

use Illuminate\Support\Facades\DB;

class CategoriaObtenerCategoriasConRubroRepository
{
    public function obtenerCategoriasConRubros()
    {
        $categorias = DB::table('tipprod as tpp')
            ->join('articulo as a', 'a.art_tipprod', '=', 'tpp.tpp_codigo')
            ->select('tpp.tpp_codigo as id', 'tpp.tpp_descri as nombre', DB::raw('COUNT(*) as total'))
            ->where('a.art_vigencia', 1)
            ->where('a.art_carrito', 1)
            ->groupBy('tpp.tpp_codigo', 'tpp.tpp_descri')
            ->orderBy('tpp.tpp_descri')
            ->get();

        $rubros = DB::table('rubro as r')
            ->join('articulo as a', 'a.art_rubro', '=', 'r.rub_codigo')
            ->select('a.art_tipprod as categoria_id', 'r.rub_codigo as id', 'r.rub_descri as nombre', DB::raw('COUNT(*) as total'))
            ->where('a.art_vigencia', 1)
            ->where('a.art_carrito', 1)
            ->groupBy('a.art_tipprod', 'r.rub_codigo', 'r.rub_descri')
            ->orderBy('r.rub_descri')
            ->get();

        $categorias->each(function ($categoria) use ($rubros) {
            $categoria->rubros = $rubros->where('categoria_id', $categoria->id)->values();
        });

        return $categorias;
    }
}
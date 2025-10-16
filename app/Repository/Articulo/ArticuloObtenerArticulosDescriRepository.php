<?php

namespace App\Repository\Articulo;

use Illuminate\Support\Facades\DB;

class ArticuloObtenerArticulosDescriRepository
{
    public function obtenerArticulosDescri($codtex, $codnum)
    {
        return DB::table('Articulo as a')
            ->select(['a.art_descri', 'a.art_descriabrev', 'a.art_descriWeb'])
            ->where('a.art_codtex', $codtex)
            ->where('a.art_codnum', $codnum)
            ->get();
    }
}
<?php

namespace App\Repository\Linea;

use Illuminate\Support\Facades\DB;

class LineaObtenerLineasPorMarcaRepository
{
    public function obtenerLineasPorMarca($marca)
    {
        return DB::table('RubxLineaxFabrica')
            ->where('rlf_fabrica', $marca)
            ->where('rlf_lindescri', '<>', '')
            ->select('rlf_linea', 'rlf_lindescri')
            ->distinct()
            ->orderBy('rlf_lindescri', 'asc')
            ->get();
    }
}
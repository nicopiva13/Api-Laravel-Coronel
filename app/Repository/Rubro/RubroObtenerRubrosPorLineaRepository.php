<?php

namespace App\Repository\Rubro;

use Illuminate\Support\Facades\DB;

class RubroObtenerRubrosPorLineaRepository
{
    public function obtenerRubrosPorLinea($linea)
    {
        return DB::table('RubxLineaxFabrica')
            ->join('rubro', 'rubro.rub_codigo', '=', 'RubxLineaxFabrica.rlf_rubro')
            ->where('RubxLineaxFabrica.rlf_linea', $linea)
            ->where('RubxLineaxFabrica.rlf_rubro', '<>', '0')
            ->select('rubro.rub_codigo', 'rubro.rub_descri')
            ->distinct()
            ->orderBy('rubro.rub_descri')
            ->get();
    }
}
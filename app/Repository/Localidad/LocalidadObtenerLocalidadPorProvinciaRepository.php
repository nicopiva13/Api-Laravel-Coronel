<?php

namespace App\Repository\Localidad;

use Illuminate\Support\Facades\DB;

class LocalidadObtenerLocalidadPorProvinciaRepository
{
    public function obtenerLocalidadesPorProvincia($codigo)
    {
        return DB::table('Localidad')
            ->where('loc_provin', $codigo)
            ->select('loc_cod1', 'loc_nombre')
            ->orderBy('loc_nombre', 'ASC')
            ->get();
    }
}
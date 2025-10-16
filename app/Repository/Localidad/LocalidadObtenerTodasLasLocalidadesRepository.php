<?php

namespace App\Repository\Localidad;

use Illuminate\Support\Facades\DB;

class LocalidadObtenerTodasLasLocalidadesRepository
{
    public function obtenerTodasLasLocalidades()
    {
        return DB::table('Localidad')
            ->select('loc_cod1', 'loc_nombre')
            ->orderBy('loc_nombre', 'asc')
            ->get();
    }
}
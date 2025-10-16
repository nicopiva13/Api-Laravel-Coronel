<?php

namespace App\Repository\Rubro;

use Illuminate\Support\Facades\DB;

class RubroObtenerRubrosRepository
{
    public function obtenerRubros()
    {
        return DB::table('rubro')
            ->select('rub_codigo', 'rub_descri')
            ->get();
    }
}
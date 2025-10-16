<?php

namespace App\Repository\Provincia;

use Illuminate\Support\Facades\DB;

class ProvinciaObtenerProvinciasRepository
{
    public function obtenerProvincias()
    {
        return DB::table('Provincia')
            ->select('pro_codigo', 'pro_descri')
            ->orderBy('pro_descri', 'ASC')
            ->get();
    }
}
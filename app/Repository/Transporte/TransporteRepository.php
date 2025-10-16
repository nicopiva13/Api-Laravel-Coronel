<?php

namespace App\Repository\Transporte;

use Illuminate\Support\Facades\DB;

class TransporteRepository
{
    public function obtenerTransporte($codigo)
    {
        $query = DB::table('Transporte');

        if (!is_null($codigo)) {
            $query->where('tra_codigo', $codigo);
        }

        return $query->get();
    }
}
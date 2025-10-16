<?php

namespace App\Repository\Parametros;

use Illuminate\Support\Facades\DB;

class ParametrosObtenerParametrosRepository
{
    public function obtenerParametros()
    {
        return DB::table('Parametro')
            ->select([
                'par_PoliticaVta', 'par_categoria', 'par_condvta', 'par_formpago',
                'par_minorista', 'par_ivaMi', 'par_mayorista', 'par_ivaMa',
                'par_decimales', 'par_listaporc', 'par_ListaPDef'
            ])
            ->first();
    }
}
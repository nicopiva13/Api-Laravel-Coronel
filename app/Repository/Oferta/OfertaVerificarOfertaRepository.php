<?php

namespace App\Repository\Oferta;

use Illuminate\Support\Facades\DB;

class OfertaVerificarOfertaRepository
{
    public function verificarOferta($cli_categoria, $ofe_codtex, $ofe_codnum)
    {
        return DB::table('Oferta')
            ->select(
                'ofe_codtex',
                'ofe_codnum',
                'ofe_linea',
                'ofe_rubro',
                'ofe_secuencia',
                'ofe_dto1',
                'ofe_dto2',
                'ofe_dto3',
                'ofe_dto4',
                'ofe_dto5',
                'ofe_dto6',
                'ofe_desde',
                'ofe_hasta',
                'ofe_categoria',
                'ofe_fecact',
                'ofe_usuario',
                'ofe_hora',
                'ofe_minimo',
                'ofe_cdisp',
                'ofe_vendedor',
                'ofe_formpag',
                'ofe_condvta',
                'ofe_AplicaWEB'
            )
            ->where('ofe_categoria', $cli_categoria)
            ->where('ofe_codtex', $ofe_codtex)
            ->where(function ($query) use ($ofe_codnum) {
                $query->where('ofe_codnum', 0)
                      ->orWhere('ofe_codnum', $ofe_codnum);
            })
            ->get();
    }
}

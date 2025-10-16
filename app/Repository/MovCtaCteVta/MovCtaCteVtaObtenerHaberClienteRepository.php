<?php

namespace App\Repository\MovCtaCteVta;

use Illuminate\Support\Facades\DB;

class MovCtaCteVtaObtenerHaberClienteRepository
{
    //Esto va en coronel
    // public function obtenerHaber($clicod, $fechaDesde)
    // {
    //     return DB::connection('sqlsrv_resumenCliente')->table('MovCtaCteVta')
    //         ->select(DB::raw('ISNULL(SUM(cta_total), 0) AS SalIni'))
    //         ->leftJoin('TipMov', 'cta_tipmov', '=', 'tmo_codigo')
    //         ->leftJoin('MovVta', function ($join) {
    //             $join->on('vta_tipmov', '=', 'cta_tipmov')
    //                 ->on('vta_ctacli', '=', 'cta_ctacli')
    //                 ->on('vta_cpbte', '=', 'cta_cpbte');
    //         })
    //         ->whereRaw('cta_fecemi < ?', [$fechaDesde])
    //         ->where('tmo_tipo', 1)
    //         ->whereRaw('ISNULL(tmo_ResumenCta, 0) = 1')
    //         ->where('tmo_ctrl', 2)
    //         ->where('cta_ctacli', $clicod)
    //         ->value(DB::raw('ISNULL(SUM(cta_total), 0) AS SalIni'));
    // }

    public function obtenerHaberCliente($clicod, $fechaDesde)
    {
        return DB::connection('sqlsrv')->table('MovCtaCteVta')
            ->select(DB::raw('ISNULL(SUM(cta_total), 0) AS SalIni'))
            ->leftJoin('TipMov', 'cta_tipmov', '=', 'tmo_codigo')
            ->leftJoin('MovVta', function ($join) {
                $join->on('vta_tipmov', '=', 'cta_tipmov')
                    ->on('vta_ctacli', '=', 'cta_ctacli')
                    ->on('vta_cpbte', '=', 'cta_cpbte');
            })
            ->whereRaw('cta_fecemi < ?', [$fechaDesde])
            ->where('tmo_tipo', 1)
            ->whereRaw('ISNULL(tmo_ResumenCta, 0) = 1')
            ->where('tmo_ctrl', 2)
            ->where('cta_ctacli', $clicod)
            ->value(DB::raw('ISNULL(SUM(cta_total), 0) AS SalIni'));
    }
}
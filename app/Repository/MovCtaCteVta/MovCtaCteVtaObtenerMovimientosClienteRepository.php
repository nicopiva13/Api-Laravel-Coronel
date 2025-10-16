<?php

namespace App\Repository\MovCtaCteVta;

use Illuminate\Support\Facades\DB;

class MovCtaCteVtaObtenerMovimientosClienteRepository
{
    //Esto va en coronel
    // public function obtenerMovimientos($clicod, $fechaDesde, $fechaHasta)
    // {
    //     $query = DB::connection('sqlsrv_resumenCliente')->table('MovCtaCteVta')
    //         ->select(
    //             'tmo_codigo',
    //             'cta_tipmov',
    //             'cta_cpbte',
    //             'cta_fecemi',
    //             'tmo_abrev',
    //             'vta_observa',
    //             'tmo_ctrl',
    //             'vta_formpag',
    //             'vta_condvta',
    //             'vta_conceptocont',
    //             DB::raw('SUM(cta_total) AS cta_total'),
    //             DB::raw('SUM(vta_dto) AS vta_totdto'),
    //             DB::raw('SUM(cta_saldo) AS cta_saldo')
    //         )
    //         ->leftJoin('TipMov', 'cta_tipmov', '=', 'tmo_codigo')
    //         ->leftJoin('Cliente', 'cta_ctacli', '=', 'cli_codigo')
    //         ->leftJoin('Localidad', function ($join) {
    //             $join->on('cli_codpos1', '=', 'loc_cod1')
    //                 ->on('cli_codpos2', '=', 'loc_cod2');
    //         })
    //         ->leftJoin('MovVta', function ($join) {
    //             $join->on('vta_ctacli', '=', 'cta_ctacli')
    //                 ->on('vta_tipmov', '=', 'cta_tipmov')
    //                 ->on('vta_cpbte', '=', 'cta_cpbte');
    //         })
    //         ->where('vta_ctacli', $clicod)
    //         ->where('tmo_tipo', 1)
    //         ->whereRaw('ISNULL(tmo_ResumenCta, 0) = 1')
    //         ->where('cta_fecemi', '>=', $fechaDesde)
    //         ->where('cta_fecemi', '<=', $fechaHasta)
    //         ->groupBy(
    //             'tmo_codigo',
    //             'cta_tipmov',
    //             'cta_cpbte',
    //             'cta_fecemi',
    //             'tmo_abrev',
    //             'vta_observa',
    //             'tmo_ctrl',
    //             'vta_formpag',
    //             'vta_condvta',
    //             'vta_conceptocont'
    //         )
    //         ->orderBy('cta_fecemi')
    //         ->orderBy('cta_tipmov')
    //         ->orderBy('cta_cpbte');

    //     return $query->get();
    // }

    public function obtenerMovimientosCliente($clicod, $fechaDesde, $fechaHasta)
    {
        $query = DB::connection('sqlsrv')->table('MovCtaCteVta')
            ->select(
                'tmo_codigo',
                'cta_tipmov',
                'cta_cpbte',
                'cta_fecemi',
                'tmo_abrev',
                'vta_observa',
                'tmo_ctrl',
                'vta_formpag',
                'vta_condvta',
                'vta_conceptocont',
                DB::raw('SUM(cta_total) AS cta_total'),
                DB::raw('SUM(vta_dto) AS vta_totdto'),
                DB::raw('SUM(cta_saldo) AS cta_saldo')
            )
            ->leftJoin('TipMov', 'cta_tipmov', '=', 'tmo_codigo')
            ->leftJoin('Cliente', 'cta_ctacli', '=', 'cli_codigo')
            ->leftJoin('Localidad', function ($join) {
                $join->on('cli_codpos1', '=', 'loc_cod1')
                    ->on('cli_codpos2', '=', 'loc_cod2');
            })
            ->leftJoin('MovVta', function ($join) {
                $join->on('vta_ctacli', '=', 'cta_ctacli')
                    ->on('vta_tipmov', '=', 'cta_tipmov')
                    ->on('vta_cpbte', '=', 'cta_cpbte');
            })
            ->where('vta_ctacli', $clicod)
            ->where('tmo_tipo', 1)
            ->whereRaw('ISNULL(tmo_ResumenCta, 0) = 1')
            ->where('cta_fecemi', '>=', $fechaDesde)
            ->where('cta_fecemi', '<=', $fechaHasta)
            ->groupBy(
                'tmo_codigo',
                'cta_tipmov',
                'cta_cpbte',
                'cta_fecemi',
                'tmo_abrev',
                'vta_observa',
                'tmo_ctrl',
                'vta_formpag',
                'vta_condvta',
                'vta_conceptocont'
            )
            ->orderBy('cta_fecemi')
            ->orderBy('cta_tipmov')
            ->orderBy('cta_cpbte');

        return $query->get();
    }
}
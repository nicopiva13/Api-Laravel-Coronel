<?php

namespace App\Repository\AuxResumenVta;

use Illuminate\Support\Facades\DB;
use Exception;

class AuxResumenVtaProcesarMovimientosClienteRepository
{
    //Esto va en coronel
    // public function procesarMovimientos($resultado1, $clicod, $saldoInicial)
    // {
    //     $acum = floatval($saldoInicial);
    //     $z = 0;

    //     DB::connection('sqlsrv_resumenCliente')->beginTransaction();

    //     try {
    //         foreach ($resultado1 as $movimiento) {
    //             $z++;
    //             $vtaTotDto = str_replace(",", ".", $movimiento->vta_totdto);
    //             $ctaSaldo = str_replace(",", ".", $movimiento->cta_saldo);
    //             $ctaTotal = str_replace(",", ".", $movimiento->cta_total);

    //             $data = [
    //                 'res_ctapro' => $clicod,
    //                 'res_terminal' => $clicod,
    //                 'res_fecha' => date('Y-m-d', strtotime($movimiento->cta_fecemi)),
    //                 'res_tipmov' => $movimiento->tmo_abrev,
    //                 'res_nrocomp' => $movimiento->cta_cpbte,
    //                 'res_fecven' => date('Y-m-d', strtotime($movimiento->cta_fecemi)),
    //                 'res_dtos' => $vtaTotDto,
    //                 'res_acumulado' => null,
    //                 'res_cancel' => $ctaSaldo,
    //                 'res_control' => $z,
    //                 'res_comentario1' => $movimiento->vta_observa,
    //                 'res_condvta' => $movimiento->vta_condvta,
    //                 'res_observa' => $movimiento->vta_observa,
    //                 'res_refe' => '',
    //                 'res_codmov' => $movimiento->tmo_codigo,
    //                 'res_conceptocont' => $movimiento->vta_conceptocont,
    //                 'res_dias' => 0,
    //                 'res_codigo' => 0,
    //                 'res_debe' => 0,
    //                 'res_haber' => 0,
    //             ];

    //             if ($movimiento->tmo_ctrl == 2 && $movimiento->vta_formpag == 2) {
    //                 $acum -= floatval($movimiento->cta_total);
    //                 $acum = round($acum, 2);
    //                 $data['res_acumulado'] = str_replace(",", ".", $acum);
    //                 $data['res_haber'] = $ctaTotal;
    //                 $data['res_debe'] = 0;
    //             } elseif ($movimiento->tmo_ctrl == 1 && $movimiento->vta_formpag == 2) {
    //                 $acum += floatval($movimiento->cta_total);
    //                 $acum = round($acum, 2);
    //                 $data['res_acumulado'] = str_replace(",", ".", $acum);
    //                 $data['res_debe'] = $ctaTotal;
    //                 $data['res_haber'] = 0;
    //             }

    //             DB::connection('sqlsrv_resumenCliente')
    //                 ->table('Aux_ResumenVta')
    //                 ->insert($data);
    //         }

    //         DB::connection('sqlsrv_resumenCliente')->commit();
    //     } catch (Exception $e) {
    //         DB::connection('sqlsrv_resumenCliente')->rollBack();
    //         throw $e;
    //     }
    // }

    public function procesarMovimientosCliente($resultado1, $clicod, $saldoInicial)
    {
        $acum = floatval($saldoInicial);
        $z = 0;

        DB::connection('sqlsrv')->beginTransaction();

        try {
            foreach ($resultado1 as $movimiento) {
                $z++;
                $vtaTotDto = str_replace(",", ".", $movimiento->vta_totdto);
                $ctaSaldo = str_replace(",", ".", $movimiento->cta_saldo);
                $ctaTotal = str_replace(",", ".", $movimiento->cta_total);

                $data = [
                    'res_ctapro' => $clicod,
                    'res_terminal' => $clicod,
                    'res_fecha' => date('Y-m-d', strtotime($movimiento->cta_fecemi)),
                    'res_tipmov' => $movimiento->tmo_abrev,
                    'res_nrocomp' => $movimiento->cta_cpbte,
                    'res_fecven' => date('Y-m-d', strtotime($movimiento->cta_fecemi)),
                    'res_dtos' => $vtaTotDto,
                    'res_acumulado' => null,
                    'res_cancel' => $ctaSaldo,
                    'res_control' => $z,
                    'res_comentario1' => $movimiento->vta_observa,
                    'res_condvta' => $movimiento->vta_condvta,
                    'res_observa' => $movimiento->vta_observa,
                    'res_refe' => '',
                    'res_codmov' => $movimiento->tmo_codigo,
                    'res_conceptocont' => $movimiento->vta_conceptocont,
                    'res_dias' => 0,
                    'res_codigo' => 0,
                    'res_debe' => 0,
                    'res_haber' => 0,
                ];

                if ($movimiento->tmo_ctrl == 2 && $movimiento->vta_formpag == 2) {
                    $acum -= floatval($movimiento->cta_total);
                    $acum = round($acum, 2);
                    $data['res_acumulado'] = str_replace(",", ".", $acum);
                    $data['res_haber'] = $ctaTotal;
                    $data['res_debe'] = 0;
                } elseif ($movimiento->tmo_ctrl == 1 && $movimiento->vta_formpag == 2) {
                    $acum += floatval($movimiento->cta_total);
                    $acum = round($acum, 2);
                    $data['res_acumulado'] = str_replace(",", ".", $acum);
                    $data['res_debe'] = $ctaTotal;
                    $data['res_haber'] = 0;
                }

                DB::connection('sqlsrv')
                    ->table('Aux_ResumenVta')
                    ->insert($data);
            }

            DB::connection('sqlsrv')->commit();
        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollBack();
            throw $e;
        }
    }
}

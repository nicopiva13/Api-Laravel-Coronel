<?php

namespace App\Repository\AuxResumenVta;

use Illuminate\Support\Facades\DB;
use Exception;

class AuxResumenVtaProcesarMovimientosVendedorRepository
{
    //Esto va en coronel
    // public function procesarMovimientosVendedor($resultado1, $clicod, $saldoInicial)
    // {
    //     $acum = floatval($saldoInicial);
    //     $z = 0;

    //     DB::connection('sqlsrv_vendedor')->beginTransaction();

    //     try {
    //         foreach ($resultado1 as $movimiento) {
    //             $z++;

    //             $vtaTotDto = floatval(str_replace(",", ".", $movimiento->vta_totdto));
    //             $ctaSaldo  = floatval(str_replace(",", ".", $movimiento->cta_saldo));
    //             $ctaTotal  = floatval(str_replace(",", ".", $movimiento->cta_total));

    //             $data = [
    //                 'res_ctapro'       => $clicod,
    //                 'res_terminal'     => $clicod,
    //                 'res_fecha'        => date('Y-d-m', strtotime($movimiento->cta_fecemi)),
    //                 'res_tipmov'       => $movimiento->tmo_abrev,
    //                 'res_nrocomp'      => $movimiento->cta_cpbte,
    //                 'res_fecven'       => date('Y-d-m', strtotime($movimiento->cta_fecemi)),
    //                 'res_dtos'         => $vtaTotDto,
    //                 'res_acumulado'    => null,
    //                 'res_cancel'       => $ctaSaldo,
    //                 'res_control'      => $z,
    //                 'res_comentario1'  => $movimiento->vta_observa,
    //                 'res_condvta'      => $movimiento->vta_condvta,
    //                 'res_observa'      => $movimiento->vta_observa,
    //                 'res_refe'         => '',
    //                 'res_codmov'       => $movimiento->tmo_codigo,
    //                 'res_conceptocont' => $movimiento->vta_conceptocont,
    //                 'res_dias'         => 0,
    //                 'res_codigo'       => 0,
    //                 'res_debe'         => 0,
    //                 'res_haber'        => 0,
    //             ];

    //             if ($movimiento->tmo_ctrl == 2 && $movimiento->vta_formpag == 2) {
    //                 $acum -= $ctaTotal;
    //                 $acum = round($acum, 2);
    //                 $data['res_acumulado'] = $acum;
    //                 $data['res_haber'] = $ctaTotal;
    //             } elseif ($movimiento->tmo_ctrl == 1 && $movimiento->vta_formpag == 2) {
    //                 $acum += $ctaTotal;
    //                 $acum = round($acum, 2);
    //                 $data['res_acumulado'] = $acum;
    //                 $data['res_debe'] = $ctaTotal;
    //             }

    //             DB::connection('sqlsrv_vendedor')
    //                 ->table('aux_resumen_vta')
    //                 ->insert($data);
    //         }

    //         DB::connection('sqlsrv_vendedor')->commit();
    //     } catch (Exception $e) {
    //         DB::connection('sqlsrv_vendedor')->rollBack();
    //         throw $e;
    //     }
    // }

    public function procesarMovimientosVendedor($resultado1, $clicod, $saldoInicial)
    {
        $acum = floatval($saldoInicial);
        $z = 0;

        DB::connection('sqlsrv')->beginTransaction();

        try {
            foreach ($resultado1 as $movimiento) {
                $z++;

                $vtaTotDto = floatval(str_replace(",", ".", $movimiento->vta_totdto));
                $ctaSaldo  = floatval(str_replace(",", ".", $movimiento->cta_saldo));
                $ctaTotal  = floatval(str_replace(",", ".", $movimiento->cta_total));

                $data = [
                    'res_ctapro'       => $clicod,
                    'res_terminal'     => $clicod,
                    'res_fecha'        => date('Y-m-d', strtotime($movimiento->cta_fecemi)),
                    'res_tipmov'       => $movimiento->tmo_abrev,
                    'res_nrocomp'      => $movimiento->cta_cpbte,
                    'res_fecven'       => date('Y-m-d', strtotime($movimiento->cta_fecemi)),
                    'res_dtos'         => $vtaTotDto,
                    'res_acumulado'    => null,
                    'res_cancel'       => $ctaSaldo,
                    'res_control'      => $z,
                    'res_comentario1'  => $movimiento->vta_observa,
                    'res_condvta'      => $movimiento->vta_condvta,
                    'res_observa'      => $movimiento->vta_observa,
                    'res_refe'         => '',
                    'res_codmov'       => $movimiento->tmo_codigo,
                    'res_conceptocont' => $movimiento->vta_conceptocont,
                    'res_dias'         => 0,
                    'res_codigo'       => 0,
                    'res_debe'         => 0,
                    'res_haber'        => 0,
                ];

                if ($movimiento->tmo_ctrl == 2 && $movimiento->vta_formpag == 2) {
                    $acum -= $ctaTotal;
                    $acum = round($acum, 2);
                    $data['res_acumulado'] = $acum;
                    $data['res_haber'] = $ctaTotal;
                } elseif ($movimiento->tmo_ctrl == 1 && $movimiento->vta_formpag == 2) {
                    $acum += $ctaTotal;
                    $acum = round($acum, 2);
                    $data['res_acumulado'] = $acum;
                    $data['res_debe'] = $ctaTotal;
                }

                DB::connection('sqlsrv')
                    ->table('aux_resumen_vta')
                    ->insert($data);
            }

            DB::connection('sqlsrv')->commit();
        } catch (Exception $e) {
            DB::connection('sqlsrv')->rollBack();
            throw $e;
        }
    }
}
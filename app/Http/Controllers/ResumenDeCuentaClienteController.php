<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResumenDeCuenta\ResumenRequest;
use App\Services\MovCtaCteVta\MovCtaCteVtaService;
use App\Services\AuxResumenVta\AuxResumenVtaService;
use App\Helper\ApiResponse;

class ResumenDeCuentaClienteController extends Controller
{
    protected $movCtaCteVtaService;
    protected $auxResumenVtaService;
    protected $apiResponse;

    public function __construct(
        MovCtaCteVtaService $movCtaCteVtaService,
        AuxResumenVtaService $auxResumenVtaService,
        ApiResponse $apiResponse
    ) {
        $this->movCtaCteVtaService = $movCtaCteVtaService;
        $this->auxResumenVtaService = $auxResumenVtaService;
        $this->apiResponse = $apiResponse;
    }

    public function resumenCliente(ResumenRequest $request)
    {
        try {
            set_time_limit(300);
            $datosObtenidos = $request->obtenerParametrosResumen();

            $movimientos = $this->movCtaCteVtaService->obtenerMovimientosCliente(
                $datosObtenidos->clicod,
                $datosObtenidos->fechaDesde,
                $datosObtenidos->fechaHasta
            );

            if ($movimientos->isEmpty()) {
                return $this->apiResponse->notFound('No se encontraron movimientos para el cliente');
            }

            $debe = $this->movCtaCteVtaService->obtenerDebeCliente($datosObtenidos->clicod, $datosObtenidos->fechaDesde);
            $haber = $this->movCtaCteVtaService->obtenerHaberCliente($datosObtenidos->clicod, $datosObtenidos->fechaDesde);
            $saldoInicial = $debe - $haber;

            $this->auxResumenVtaService->limpiarSaldoCliente($datosObtenidos->clicod);
            $this->auxResumenVtaService->procesarMovimientosCliente($movimientos, $datosObtenidos->clicod, $saldoInicial);
            $movimientosProcesados = $this->auxResumenVtaService->obtenerMovimientosClientes($datosObtenidos->clicod);

            return response()->json([
                'movimientos' => $movimientosProcesados,
                'saldoInicial' => $saldoInicial,
            ], 200);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}
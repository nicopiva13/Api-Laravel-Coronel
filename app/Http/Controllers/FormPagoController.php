<?php

namespace App\Http\Controllers;

use App\Services\FormaDePago\FormaDePagoService;
use App\Helper\ApiResponse;

class FormPagoController extends Controller
{
    protected $formaDePagoService;
    protected $apiResponse;

    public function __construct(
        FormaDePagoService $formaDePagoService,
        ApiResponse $apiResponse
    ) {
        $this->formaDePagoService = $formaDePagoService;
        $this->apiResponse = $apiResponse;
    }

    public function obtenerFormasDePago()
    {
        try {
            $formasPago = $this->formaDePagoService->obtenerFormasDePago();

            if ($formasPago->isEmpty()) {
                return $this->apiResponse->notFound('No existen formas de pago en la BD');
            }

            return response()->json($formasPago);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}
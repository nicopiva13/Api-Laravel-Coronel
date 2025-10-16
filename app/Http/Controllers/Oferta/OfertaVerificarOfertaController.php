<?php

namespace App\Http\Controllers\Novedad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Oferta\VerificarOfertaRequest;
use App\Services\Oferta\OfertaService;
use App\Helper\ApiResponse;

class OfertaVerificarOfertaController extends Controller
{
    protected $ofertaService;
    protected $apiResponse;

    public function __construct(
        OfertaService $ofertaService,
        ApiResponse $apiResponse
    ) {
        $this->ofertaService = $ofertaService;
        $this->apiResponse = $apiResponse;
    }

    public function verificarOferta(VerificarOfertaRequest $request)
    {
        try {
            $cli_categoria = $request->cli_categoria;
            $ofe_codtex = $request->ofe_codtex;
            $ofe_codnum = $request->ofe_codnum;

            $resultados = $this->ofertaService->verificarOferta($cli_categoria, $ofe_codtex, $ofe_codnum);

            if ($resultados->isEmpty()) {
                return $this->apiResponse->notFound("No se encontraron ofertas para los parámetros proporcionados");
            }

            return response()->json($resultados);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, "Ocurrió un error al procesar la solicitud.");
        }
    }
}
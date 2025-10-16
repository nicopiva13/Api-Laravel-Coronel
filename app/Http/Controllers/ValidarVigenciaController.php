<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponse;
use App\Services\Vigencia\ValidarVigenciaService;

class ValidarVigenciaController extends Controller
{
    protected $apiResponse;
    protected $validarVigeciaService;

    public function __construct(
        ApiResponse $apiResponse,
        ValidarVigenciaService $validarVigeciaService,
    ) {
        $this->apiResponse = $apiResponse;
        $this->validarVigeciaService = $validarVigeciaService;
    }

    public function validarVigencia($art_codnum, $art_codtex, $art_adicod = null)
    {
        try {
            $result = $this->validarVigeciaService->validarVigencia($art_codnum, $art_codtex, $art_adicod);

            if ($result->isEmpty()) {
                return response()->json(['message' => 'El articulo no tiene vigencia']);
            }

            return response()->json(['message' => 'El articulo tiene vigencia', 'articulo' => $result]);
        } catch (\Throwable  $e) {
            return $this->apiResponse->serverError($e);
        }
    }
}
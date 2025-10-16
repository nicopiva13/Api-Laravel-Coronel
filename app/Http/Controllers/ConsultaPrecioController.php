<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class ConsultaPrecioController extends Controller
{
    protected $articuloService;
    protected $apiResponse;

    public function __construct(
        ArticuloService $articuloService,
        ApiResponse $apiResponse
    ) {
        $this->articuloService = $articuloService;
        $this->apiResponse = $apiResponse;
    }

    public function consultaPrecio(Request $request, $codtex, $codnum, $adicod = null)
    {
        try {
            $hostIMG = $this->determinarHostIMG($request->ip());
            $articulos = $this->articuloService->consultaPrecio($codtex, $codnum, $adicod, $hostIMG);

            if ($articulos->isEmpty()) {
                return $this->apiResponse->notFound('No existe el artículo');
            }

            return response()->json([
                'message' => 'Artículo encontrado',
                'articulo' => $articulos
            ]);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e, 'Error interno del servidor');
        }
    }

    private function determinarHostIMG(string $ip): string
    {
        $ipsLocales = ["127.0.0.1", "10.15.20.203"];

        return in_array($ip, $ipsLocales)
            ? "https://10.15.20.201:70/"
            : "https://imgcoronel.dyndns.org:70/";
    }
}
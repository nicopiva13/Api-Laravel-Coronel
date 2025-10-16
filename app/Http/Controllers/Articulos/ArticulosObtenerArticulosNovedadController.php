<?php

namespace App\Http\Controllers\Articulos;

use App\Http\Controllers\Controller;
use App\Services\Articulo\ArticuloService;
use App\Helper\ApiResponse;

class ArticulosObtenerArticulosNovedadController extends Controller
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

    public function obtenerArticulosNovedad($tipoCliente, $tipoBusqueda, $categoria, $fechaDesde, $fechaHasta)
    {
        try {
            $hostIMG = $this->determinarHostIMG(request()->getHost());
            $art_precio = $this->obtenerPrecioPorTipoCliente($tipoCliente);
            $condicion_fecha = $this->obtenerCondicionFecha($tipoBusqueda, $fechaDesde, $fechaHasta);
            $T = $this->obtenerCondicionCategoria($categoria);

            $articulosNovedad = $this->articuloService->obtenerNovedades($hostIMG, $art_precio, $T, $condicion_fecha);

            return response()->json($articulosNovedad);
        } catch (\Throwable $e) {
            return $this->apiResponse->serverError($e);
        }
    }

    private function determinarHostIMG($host)
    {
        $ipsLocales = ["localhost", "10.15.20.203"];
        return in_array($host, $ipsLocales) ? "https://10.15.20.201:70/" : "https://imgcoronel.dyndns.org:70/";
    }

    private function obtenerPrecioPorTipoCliente(int $tipoCliente): string
    {
        return match ($tipoCliente) {
            1 => " art_precmino as art_preclista, ",
            2 => " art_precmayo as art_preclista, ",
            default => " art_precmayo as art_preclista, ",
        };
    }

    private function obtenerCondicionFecha(int $tipoBusqueda, string $desde, string $hasta): string
    {
        return match ($tipoBusqueda) {
            1 => " and art_fecalta >= '{$desde}' and art_fecalta <= '{$hasta}' ",
            2 => " and art_fectip >= '{$desde}' and art_fectip <= '{$hasta}' and art_tip <> 0",
            default => "",
        };
    }

    private function obtenerCondicionCategoria(?string $categoria): string
    {
        return !empty($categoria) ? " AND art_tipprod = '{$categoria}'" : "";
    }
}
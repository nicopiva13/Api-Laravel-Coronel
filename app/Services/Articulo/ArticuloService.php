<?php

namespace App\Services\Articulo;

use App\Repository\Articulo\ArticuloContarArticuloRepository;
use App\Repository\Articulo\ArticuloObtenerArticuloRepository;
use App\Repository\Articulo\ArticuloObtenerArticuloAdicionalRepository;
use App\Repository\Articulo\ArticuloListarPrecioArticulosRepository;
use App\Repository\Articulo\ArticuloObtenerArticulosFiltradosRepository;
use App\Repository\Articulo\ArticuloObtenerArticulosPorFabricaRepository;
use App\Repository\Articulo\ArticuloObtenerTodosLosArticulosPorRubroRepository;
use App\Repository\Articulo\ArticuloObtenerArticulosDescriRepository;
use App\Repository\Articulo\ArticuloContarArticulosRepository;
use App\Repository\Articulo\ArticuloObtenerArticulosRepository;
use App\Repository\Articulo\ArticuloContarArticulosPorCategoriayRubroRepository;
use App\Repository\Articulo\ArticuloObtenerArticulosPorCategoriayRubroRepository;
use App\Repository\Articulo\ArticuloObtenerArticulosNovedadRepository;
use App\Repository\Articulo\ArticuloConsultarPrecioArticuloRepository;
use App\Repository\Articulo\ArticuloObtenerArticulosPorRubroRepository;
use App\Repository\Articulo\ArticuloObtenerArticuloPrecioRepository;

class ArticuloService
{
    protected ArticuloContarArticuloRepository $articuloContarArticuloRepo;
    protected ArticuloObtenerArticuloRepository $articuloObtenerArticuloRepo;
    protected ArticuloObtenerArticuloAdicionalRepository $articuloObtenerArticuloAdicionalRepo;
    protected ArticuloObtenerArticulosFiltradosRepository $articuloObtenerArticulosFiltradosRepo;
    protected ArticuloObtenerArticulosPorFabricaRepository $articuloObtenerArticulosPorFabricaRepo;
    protected ArticuloObtenerTodosLosArticulosPorRubroRepository $articuloObtenerTodosLosArticulosPorRubroRepo;
    protected ArticuloObtenerArticulosDescriRepository $articuloObtenerArticulosDescriRepo;
    protected ArticuloListarPrecioArticulosRepository $articuloListarPrecioArticulosRepo;
    protected ArticuloContarArticulosRepository $articuloContarArticulosRepo;
    protected ArticuloObtenerArticulosRepository $articuloObtenerArticulosRepo;
    protected ArticuloContarArticulosPorCategoriayRubroRepository $articuloContarArticulosPorCategoriayRubroRepo;
    protected ArticuloObtenerArticulosPorCategoriayRubroRepository $articuloObtenerArticulosPorCategoriayRubroRepo;
    protected ArticuloObtenerArticulosNovedadRepository $articuloObtenerArticulosNovedadRepo;
    protected ArticuloConsultarPrecioArticuloRepository $articuloConsultarPrecioArticuloRepo;
    protected ArticuloObtenerArticulosPorRubroRepository $articuloObtenerArticulosPorRubroRepo;
    protected ArticuloObtenerArticuloPrecioRepository $articuloObtenerArticuloPrecioRepo;

    public function __construct(
        ArticuloContarArticuloRepository $articuloContarArticuloRepo,
        ArticuloObtenerArticuloRepository $articuloObtenerArticuloRepo,
        ArticuloObtenerArticuloAdicionalRepository $articuloObtenerArticuloAdicionalRepo,
        ArticuloObtenerArticulosFiltradosRepository $articuloObtenerArticulosFiltradosRepo,
        ArticuloObtenerArticulosPorFabricaRepository $articuloObtenerArticulosPorFabricaRepo,
        ArticuloObtenerTodosLosArticulosPorRubroRepository $articuloObtenerTodosLosArticulosPorRubroRepo,
        ArticuloObtenerArticulosDescriRepository $articuloObtenerArticulosDescriRepo,
        ArticuloListarPrecioArticulosRepository $articuloListarPrecioArticulosRepo,
        ArticuloContarArticulosRepository $articuloContarArticulosRepo,
        ArticuloObtenerArticulosRepository $articuloObtenerArticulosRepo,
        ArticuloContarArticulosPorCategoriayRubroRepository $articuloContarArticulosPorCategoriayRubroRepo,
        ArticuloObtenerArticulosPorCategoriayRubroRepository $articuloObtenerArticulosPorCategoriayRubroRepo,
        ArticuloObtenerArticulosNovedadRepository $articuloObtenerArticulosNovedadRepo,
        ArticuloConsultarPrecioArticuloRepository $articuloConsultarPrecioArticuloRepo,
        ArticuloObtenerArticulosPorRubroRepository $articuloObtenerArticulosPorRubroRepo,
        ArticuloObtenerArticuloPrecioRepository $articuloObtenerArticuloPrecioRepo,
    ) {
        $this->articuloContarArticuloRepo = $articuloContarArticuloRepo;
        $this->articuloObtenerArticuloRepo = $articuloObtenerArticuloRepo;
        $this->articuloObtenerArticuloAdicionalRepo = $articuloObtenerArticuloAdicionalRepo;
        $this->articuloObtenerArticulosFiltradosRepo = $articuloObtenerArticulosFiltradosRepo;
        $this->articuloObtenerArticulosPorFabricaRepo = $articuloObtenerArticulosPorFabricaRepo;
        $this->articuloObtenerTodosLosArticulosPorRubroRepo = $articuloObtenerTodosLosArticulosPorRubroRepo;
        $this->articuloObtenerArticulosDescriRepo = $articuloObtenerArticulosDescriRepo;
        $this->articuloListarPrecioArticulosRepo = $articuloListarPrecioArticulosRepo;
        $this->articuloContarArticulosRepo = $articuloContarArticulosRepo;
        $this->articuloObtenerArticulosRepo = $articuloObtenerArticulosRepo;
        $this->articuloContarArticulosPorCategoriayRubroRepo = $articuloContarArticulosPorCategoriayRubroRepo;
        $this->articuloObtenerArticulosPorCategoriayRubroRepo = $articuloObtenerArticulosPorCategoriayRubroRepo;
        $this->articuloObtenerArticulosNovedadRepo = $articuloObtenerArticulosNovedadRepo;
        $this->articuloConsultarPrecioArticuloRepo = $articuloConsultarPrecioArticuloRepo;
        $this->articuloObtenerArticulosPorRubroRepo = $articuloObtenerArticulosPorRubroRepo;
        $this->articuloObtenerArticuloPrecioRepo = $articuloObtenerArticuloPrecioRepo;
    }
    
    public function contarArticulo($COND)
    {
        return $this->articuloContarArticuloRepo->contarArticulo($COND);
    }

    public function obtenerArticulo($hostIMG, $precioObtenido, $cli_categoria, $COND)
    {
        return $this->articuloObtenerArticuloRepo->obtenerArticulo($hostIMG, $precioObtenido, $cli_categoria, $COND);
    }

    public function obtenerArticuloAdicional($hostIMG, $precioObtenido, $cli_categoria, $fabrica, $codigo, $adicional)
    {
        return $this->articuloObtenerArticuloAdicionalRepo->obtenerArticuloAdicional($hostIMG, $precioObtenido, $cli_categoria, $fabrica, $codigo, $adicional);
    }

    public function obtenerArticulosFiltrados($marca, $linea, $rubro, $categoria, $fecdesde, $fechasta)
    {
        return $this->articuloObtenerArticulosFiltradosRepo->obtenerArticulosFiltrados($marca, $linea, $rubro, $categoria, $fecdesde, $fechasta);
    }

    public function obtenerArticulosPorFabrica($fabrica)
    {
        return $this->articuloObtenerArticulosPorFabricaRepo->obtenerArticulosPorFabrica($fabrica);
    }

    public function obtenerTodosLosArticulosPorRubro($hostIMG, $precioObtenido, $cli_categoria, $rubro)
    {
        return $this->articuloObtenerTodosLosArticulosPorRubroRepo->obtenerTodosLosArticulosPorRubro($hostIMG, $precioObtenido, $cli_categoria, $rubro);
    }

    public function obtenerArticulosDescri($codtex, $codnum)
    {
        return $this->articuloObtenerArticulosDescriRepo->obtenerArticulosDescri($codtex, $codnum);
    }

    public function listaPreciosArticulos($fabrica)
    {
        return $this->articuloListarPrecioArticulosRepo->listaPreciosArticulos($fabrica);
    }

    public function contarArticulos($query, $params, $busquedas, $tipoBusqueda)
    {
        switch ($tipoBusqueda) {
            case 1:
                return $this->articuloContarArticulosRepo->contarArticulos($query, $params, $busquedas);
            case 2:
                return $this->articuloContarArticulosRepo->contarArticulosPrimerBusqueda($query, $params, $busquedas);
            case 3:
                return $this->articuloContarArticulosRepo->contarArticulosSegundaBusqueda($query, $params, $busquedas);
            case 4:
                return $this->articuloContarArticulosRepo->contarArticulosTerceraBusqueda($query, $params, $busquedas);
        }
    }

    public function obtenerArticulos($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion, $tipoBusqueda)
    {
        switch ($tipoBusqueda) {
            case 1:
                return $this->articuloObtenerArticulosRepo->obtenerArticulos($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion);
            case 2:
                return $this->articuloObtenerArticulosRepo->obtenerArticulosPrimerBusqueda($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion);
            case 3:
                return $this->articuloObtenerArticulosRepo->obtenerArticulosSegundaBusqueda($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion);
            case 4:
                return $this->articuloObtenerArticulosRepo->obtenerArticulosTerceraBusqueda($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $busquedas, $paginacion);
        }
    }

    public function contarArticulosPorCategoriayRubro($query, $params)
    {
        return $this->articuloContarArticulosPorCategoriayRubroRepo->contarArticulosPorCategoriayRubro($query, $params);
    }

    public function obtenerArticulosPorCategoriayRubro($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $paginacion)
    {
        return $this->articuloObtenerArticulosPorCategoriayRubroRepo->obtenerArticulosPorCategoriayRubro($hostIMG, $art_precio, $precioObtenido, $order_by, $params, $query, $paginacion);
    }

    public function obtenerNovedades($hostIMG, $art_precio, $T, $condicion_fecha)
    {
        return $this->articuloObtenerArticulosNovedadRepo->obtenerNovedades($hostIMG, $art_precio, $T, $condicion_fecha);
    }

    public function consultaPrecio($codtex, $codnum, $adicod = null, $hostIMG)
    {
        return $this->articuloConsultarPrecioArticuloRepo->consultaPrecio($codtex, $codnum, $adicod, $hostIMG);
    }

    public function obtenerArticulosPorRubro($codigo)
    {
        return $this->articuloObtenerArticulosPorRubroRepo->obtenerArticulosPorRubro($codigo);
    }
    
    public function obtenerArticuloPrecio($codtex, $codnum, $columnaprecio, $cantdecimales, $datos)
    {
        return $this->articuloObtenerArticuloPrecioRepo->obtenerArticuloPrecio($codtex, $codnum, $columnaprecio, $cantdecimales, $datos);
    }
}
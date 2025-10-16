<?php

namespace App\Services\Oferta;

use App\Repository\Oferta\OfertaObtenerOfertaPrecioRepository;
use App\Repository\Oferta\OfertaContarOfertasRepository;
use App\Repository\Oferta\OfertaObtenerOfertasRepository;
use App\Repository\Oferta\OfertaObtenerArticuloPorCategoriaRepository;
use App\Repository\Oferta\OfertaObtenerCategoriasOfertasRepository;
use App\Repository\Oferta\OfertaObtenerArticulosEnOfertaRepository;
use App\Repository\Oferta\OfertaVerificarOfertaRepository;

class OfertaService
{
    protected OfertaObtenerOfertaPrecioRepository $ofertaObtenerOfertaPrecioRepo;
    protected OfertaContarOfertasRepository $ofertaContarOfertasRepo;
    protected OfertaObtenerOfertasRepository $ofertaObtenerOfertasRepo;
    protected OfertaObtenerArticuloPorCategoriaRepository $ofertaObtenerArticuloPorCategoriaRepo;
    protected OfertaObtenerCategoriasOfertasRepository $ofertaObtenerCategoriasOfertasRepo;
    protected OfertaObtenerArticulosEnOfertaRepository $ofertaObtenerArticulosEnOfertaRepo;
    protected OfertaVerificarOfertaRepository $ofertaVerificarOfertaRepo;

    public function __construct(
        OfertaObtenerOfertaPrecioRepository $ofertaObtenerOfertaPrecioRepo,
        OfertaContarOfertasRepository $ofertaContarOfertasRepo,
        OfertaObtenerOfertasRepository $ofertaObtenerOfertasRepo,
        OfertaObtenerArticuloPorCategoriaRepository $ofertaObtenerArticuloPorCategoriaRepo,
        OfertaObtenerCategoriasOfertasRepository $ofertaObtenerCategoriasOfertasRepo,
        OfertaObtenerArticulosEnOfertaRepository $ofertaObtenerArticulosEnOfertaRepo,
        OfertaVerificarOfertaRepository $ofertaVerificarOfertaRepo,
    ) {
        $this->ofertaObtenerOfertaPrecioRepo = $ofertaObtenerOfertaPrecioRepo;
        $this->ofertaContarOfertasRepo = $ofertaContarOfertasRepo;
        $this->ofertaObtenerOfertasRepo = $ofertaObtenerOfertasRepo;
        $this->ofertaObtenerArticuloPorCategoriaRepo = $ofertaObtenerArticuloPorCategoriaRepo;
        $this->ofertaObtenerCategoriasOfertasRepo = $ofertaObtenerCategoriasOfertasRepo;
        $this->ofertaObtenerArticulosEnOfertaRepo = $ofertaObtenerArticulosEnOfertaRepo;
        $this->ofertaVerificarOfertaRepo = $ofertaVerificarOfertaRepo;
    }

    public function obtenerOfertaPrecio($categoria, $fabrica, $articulo, $cantidad, $linea, $rubro, $vendedor)
    {
        return $this->ofertaObtenerOfertaPrecioRepo->obtenerOfertaPrecio($categoria, $fabrica, $articulo, $cantidad, $linea, $rubro, $vendedor);
    }

    public function contarOfertas($OfeDesde, $OfeHasta, $CAT, $TIPPROD)
    {
        return $this->ofertaContarOfertasRepo->contarOfertas($OfeDesde, $OfeHasta, $CAT, $TIPPROD);
    }
    
    public function obtenerOfertas($order_by, $TIPPROD, $art_precio, $hostIMG, $CAT, $min, $max)
    {
        return $this->ofertaObtenerOfertasRepo->obtenerOfertas($order_by, $TIPPROD, $art_precio, $hostIMG, $CAT, $min, $max);
    }

    public function obtenerArticulosPorCategoria($cli_categoria)
    {
        return $this->ofertaObtenerArticuloPorCategoriaRepo->obtenerArticulosPorCategoria($cli_categoria);
    }

    
    public function obtenerCategoriasOferta($categ)
    {
        return $this->ofertaObtenerCategoriasOfertasRepo->obtenerCategoriasOferta($categ);
    }

    
    public function obtenerArticulosEnOferta($cli_categoria, $cod_tex)
    {
        return $this->ofertaObtenerArticulosEnOfertaRepo->obtenerArticulosEnOferta($cli_categoria, $cod_tex);
    }

    public function verificarOferta($cli_categoria, $ofe_codtex, $ofe_codnum)
    {
        return $this->ofertaVerificarOfertaRepo->verificarOferta($cli_categoria, $ofe_codtex, $ofe_codnum);
    }
}
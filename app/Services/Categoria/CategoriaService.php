<?php

namespace App\Services\Categoria;

use App\Repository\Categoria\CategoriaObtenerCategoriasConRubroRepository;
use App\Repository\Categoria\CategoriaObtenerCategoriasPorTipoProductoRepository;
use App\Repository\Categoria\CategoriaObtenerCategoriasPorRubroRepository;
use App\Repository\Categoria\CategoriaObtenerCategoriasPorLineaRepository;
use App\Repository\Categoria\CategoriaObtenerCategoriasPorFabricaRepository;
use App\Repository\Categoria\CategoriaObtenerCategoriasPorRubrosRepository;

class CategoriaService
{
    protected CategoriaObtenerCategoriasConRubroRepository $categoriaObtenerCategoriasRepo;
    protected CategoriaObtenerCategoriasPorTipoProductoRepository $categoriaObtenerCategoriasPorTipoProductoRepo;
    protected CategoriaObtenerCategoriasPorRubroRepository $categoriaObtenerCategoriasPorRubroRepo;
    protected CategoriaObtenerCategoriasPorLineaRepository $categoriaObtenerCategoriasPorLineaRepo;
    protected CategoriaObtenerCategoriasPorFabricaRepository $categoriaObtenerCategoriasPorFabricaRepo;
    protected CategoriaObtenerCategoriasPorRubrosRepository $categoriaObtenerCategoriasPorRubrosRepo;

    public function __construct(
        CategoriaObtenerCategoriasConRubroRepository $categoriaObtenerCategoriasRepo,
        CategoriaObtenerCategoriasPorTipoProductoRepository $categoriaObtenerCategoriasPorTipoProductoRepo,
        CategoriaObtenerCategoriasPorRubroRepository $categoriaObtenerCategoriasPorRubroRepo,
        CategoriaObtenerCategoriasPorLineaRepository $categoriaObtenerCategoriasPorLineaRepo,
        CategoriaObtenerCategoriasPorFabricaRepository $categoriaObtenerCategoriasPorFabricaRepo,
        CategoriaObtenerCategoriasPorRubrosRepository $categoriaObtenerCategoriasPorRubrosRepo,
    ) {
        $this->categoriaObtenerCategoriasRepo = $categoriaObtenerCategoriasRepo;
        $this->categoriaObtenerCategoriasPorTipoProductoRepo = $categoriaObtenerCategoriasPorTipoProductoRepo;
        $this->categoriaObtenerCategoriasPorRubroRepo = $categoriaObtenerCategoriasPorRubroRepo;
        $this->categoriaObtenerCategoriasPorLineaRepo = $categoriaObtenerCategoriasPorLineaRepo;
        $this->categoriaObtenerCategoriasPorFabricaRepo = $categoriaObtenerCategoriasPorFabricaRepo;
        $this->categoriaObtenerCategoriasPorRubrosRepo = $categoriaObtenerCategoriasPorRubrosRepo;
    }

    public function obtenerCategoriasConRubros()
    {
        return $this->categoriaObtenerCategoriasRepo->obtenerCategoriasConRubros();
    }

    public function obtenerCategoriasPorTipoProducto($tipoProducto)
    {
        return $this->categoriaObtenerCategoriasPorTipoProductoRepo->obtenerCategoriasPorTipoProducto($tipoProducto);
    }
    
    public function obtenerCategoriasPorRubro($tipoProducto, $rubro)
    {
        return $this->categoriaObtenerCategoriasPorRubroRepo->obtenerCategoriasPorRubro($tipoProducto, $rubro);
    }

    public function obtenerCategoriasPorLinea($tipoProducto, $rubro, $linea)
    {
        return $this->categoriaObtenerCategoriasPorLineaRepo->obtenerCategoriasPorLinea($tipoProducto, $rubro, $linea);
    }

    public function obtenerCategoriasPorFabrica($tipoProducto, $rubro, $linea, $fabrica)
    {
        return $this->categoriaObtenerCategoriasPorFabricaRepo->obtenerCategoriasPorFabrica($tipoProducto, $rubro, $linea, $fabrica);
    }

    public function obtenerCategoriasPorRubros($rubro)
    {
        return $this->categoriaObtenerCategoriasPorRubrosRepo->obtenerCategoriasPorRubros($rubro);
    }
}
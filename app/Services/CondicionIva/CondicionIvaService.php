<?php

namespace App\Services\CondicionIva;

use App\Repository\CondicionIva\CondicionIvaObtenerCondicionesIvaVigenteRepository;
use App\Repository\CondicionIva\CondicionIvaObtenerCondicionIvaPorIdRepository;

class CondicionIvaService
{
    protected CondicionIvaObtenerCondicionesIvaVigenteRepository $condicionIvaObtenerCondicionesIvaVigentesRepo;
    protected CondicionIvaObtenerCondicionIvaPorIdRepository $condicionIvaObtenerCondicionIvaPorIdRepo;

    public function __construct(
        CondicionIvaObtenerCondicionesIvaVigenteRepository $condicionIvaObtenerCondicionesIvaVigentesRepo,
        CondicionIvaObtenerCondicionIvaPorIdRepository $condicionIvaObtenerCondicionIvaPorIdRepo,
    ) {
        $this->condicionIvaObtenerCondicionesIvaVigentesRepo = $condicionIvaObtenerCondicionesIvaVigentesRepo;
        $this->condicionIvaObtenerCondicionIvaPorIdRepo = $condicionIvaObtenerCondicionIvaPorIdRepo;
    }

    public function obtenerCondicionesIvaVigentes()
    {
        return $this->condicionIvaObtenerCondicionesIvaVigentesRepo->obtenerCondicionesIvaVigentes();
    } 

    public function obtenerCondicionIvaPorId($id)
    {
        return $this->condicionIvaObtenerCondicionIvaPorIdRepo->obtenerCondicionIvaPorId($id);
    } 
}
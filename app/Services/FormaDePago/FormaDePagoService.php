<?php

namespace App\Services\FormaDePago;

use App\Repository\FormaDePago\FormaDePagoObtenerFormasDePagoRepository;

class FormaDePagoService
{
    protected FormaDePagoObtenerFormasDePagoRepository $formaDePagoObtenerFormasDePagoRepo;

    public function __construct(
        FormaDePagoObtenerFormasDePagoRepository $formaDePagoObtenerFormasDePagoRepo,
    ) {
        $this->formaDePagoObtenerFormasDePagoRepo = $formaDePagoObtenerFormasDePagoRepo;
    }

    public function obtenerFormasDePago()
    {
        return $this->formaDePagoObtenerFormasDePagoRepo->obtenerFormasDePago();
    } 
}
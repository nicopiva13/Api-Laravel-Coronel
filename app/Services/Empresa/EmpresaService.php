<?php

namespace App\Services\Empresa;

use App\Repository\Empresa\EmpresaObtenerEmpresaRepository;

class EmpresaService
{
    protected EmpresaObtenerEmpresaRepository $empresaObtenerEmpresaRepo;

    public function __construct(
        EmpresaObtenerEmpresaRepository $empresaObtenerEmpresaRepo,
    ) {
        $this->empresaObtenerEmpresaRepo = $empresaObtenerEmpresaRepo;
    }

    public function obtenerEmpresa()
    {
        return $this->empresaObtenerEmpresaRepo->obtenerEmpresa();
    } 
}
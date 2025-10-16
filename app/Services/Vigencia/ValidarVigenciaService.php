<?php

namespace App\Services\Vigencia;

use App\Repository\Vigencia\ValidarVigenciaRepository;

class ValidarVigenciaService
{
    protected ValidarVigenciaRepository $validarVigenciaRepo;

    public function __construct(
        ValidarVigenciaRepository $validarVigenciaRepo,
    ) {
        $this->validarVigenciaRepo = $validarVigenciaRepo;
    }

    public function validarVigencia($art_codnum, $art_codtex, $art_adicod = null)
    {
        return $this->validarVigenciaRepo->validarVigencia($art_codnum, $art_codtex, $art_adicod);
    }
}
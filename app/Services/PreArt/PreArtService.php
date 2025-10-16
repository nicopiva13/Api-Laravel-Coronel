<?php

namespace App\Services\PreArt;

use App\Repository\PreArt\PreArtObtenerDescuentosUsuarioRepository;

class PreArtService
{
    protected PreArtObtenerDescuentosUsuarioRepository $preArtObtenerDescuentosUsuarioRepo;

    public function __construct(
        PreArtObtenerDescuentosUsuarioRepository $preArtObtenerDescuentosUsuarioRepo,
    ) {
        $this->preArtObtenerDescuentosUsuarioRepo = $preArtObtenerDescuentosUsuarioRepo;
    }

    public function obtenerDescuentos($clicod, $fabrica, $condvta, $articulo, $linea, $rubro, $cantidad)
    {
        return $this->preArtObtenerDescuentosUsuarioRepo->obtenerDescuentos($clicod, $fabrica, $condvta, $articulo, $linea, $rubro, $cantidad);
    }    
}
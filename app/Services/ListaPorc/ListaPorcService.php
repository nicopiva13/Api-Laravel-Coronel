<?php

namespace App\Services\ListaPorc;

use App\Repository\ListaPorc\ListaPorcObtenerListaDataRepository;

class ListaPorcService
{
    protected ListaPorcObtenerListaDataRepository $listaPorcObtenerListaDataRepo;

    public function __construct(
        ListaPorcObtenerListaDataRepository $listaPorcObtenerListaDataRepo,
    ) {
        $this->listaPorcObtenerListaDataRepo = $listaPorcObtenerListaDataRepo;
    }

    public function obtenerListaData($listac, $listaPDefParam, $listapd)
    {
        return $this->listaPorcObtenerListaDataRepo->obtenerListaData($listac, $listaPDefParam, $listapd);
    }
}
<?php

namespace App\Services\Cliente;

use App\Repository\Cliente\ClienteObtenerClientesRepository;
use App\Repository\Cliente\ClienteObtenerDatosClienteRepository;
use App\Repository\Cliente\ClienteObtenerEstadoFacturacionRepository;
use App\Repository\Cliente\ClienteObtenerCondicionClienteRepository;
use App\Repository\Cliente\ClienteObtenerClienteRepository;
use App\Repository\Cliente\ClienteBuscarCategoriaRepository;
use App\Repository\Cliente\ClienteActualizarClienteRepository;
use App\Repository\Cliente\ClienteActualizarEstadoFacturacionRepository;
use App\Repository\Cliente\ClienteCalcularPorcentajesClienteRepository;
use App\Repository\Cliente\ClienteObtenerClientesLogisticaRepository;
use App\Repository\Cliente\ClienteObtenerClientePorCodigoLogisticaRepository;
use App\Repository\Cliente\ClienteObtenerDatosClientePrecioRepository;

class ClienteService
{
    protected ClienteObtenerClientesRepository $clienteObtenerClientesRepo;
    protected ClienteObtenerDatosClienteRepository $clienteObtenerDatosClienteRepo;
    protected ClienteObtenerEstadoFacturacionRepository $clienteObtenerEstadoFacturacionRepo;
    protected ClienteObtenerCondicionClienteRepository $clienteObtenerCondicionClienteRepo;
    protected ClienteObtenerClienteRepository $clienteObtenerClienteRepo;
    protected ClienteBuscarCategoriaRepository $clienteBuscarCategoriaClienteRepo;
    protected ClienteActualizarClienteRepository $clienteActualizarClienteRepo;
    protected ClienteActualizarEstadoFacturacionRepository $clienteActualizarEstadoFacturacionRepo;
    protected ClienteCalcularPorcentajesClienteRepository $clienteCalcularPorcentajesClienteRepo;
    protected ClienteObtenerClientesLogisticaRepository $clienteObtenerClientesLogisticaRepo;
    protected ClienteObtenerClientePorCodigoLogisticaRepository $clienteObtenerClientePorCodigoLogisticaRepo;
    protected ClienteObtenerDatosClientePrecioRepository $clienteObtenerDatosClientePrecioRepo;

    public function __construct(
        ClienteObtenerClientesRepository $clienteObtenerClientesRepo,
        ClienteObtenerDatosClienteRepository $clienteObtenerDatosClienteRepo,
        ClienteObtenerEstadoFacturacionRepository $clienteObtenerEstadoFacturacionRepo,
        ClienteObtenerCondicionClienteRepository $clienteObtenerCondicionClienteRepo,
        ClienteObtenerClienteRepository $clienteObtenerClienteRepo,
        ClienteBuscarCategoriaRepository $clienteBuscarCategoriaClienteRepo,
        ClienteActualizarClienteRepository $clienteActualizarClienteRepo,
        ClienteActualizarEstadoFacturacionRepository $clienteActualizarEstadoFacturacionRepo,
        ClienteCalcularPorcentajesClienteRepository $clienteCalcularPorcentajesClienteRepo,
        ClienteObtenerClientesLogisticaRepository $clienteObtenerClientesLogisticaRepo,
        ClienteObtenerClientePorCodigoLogisticaRepository $clienteObtenerClientePorCodigoLogisticaRepo,
        ClienteObtenerDatosClientePrecioRepository $clienteObtenerDatosClientePrecioRepo,
    ) {
        $this->clienteObtenerClientesRepo = $clienteObtenerClientesRepo;
        $this->clienteObtenerDatosClienteRepo = $clienteObtenerDatosClienteRepo;
        $this->clienteObtenerEstadoFacturacionRepo = $clienteObtenerEstadoFacturacionRepo;
        $this->clienteObtenerCondicionClienteRepo = $clienteObtenerCondicionClienteRepo;
        $this->clienteObtenerClienteRepo = $clienteObtenerClienteRepo;
        $this->clienteBuscarCategoriaClienteRepo = $clienteBuscarCategoriaClienteRepo;
        $this->clienteActualizarClienteRepo = $clienteActualizarClienteRepo;
        $this->clienteActualizarEstadoFacturacionRepo = $clienteActualizarEstadoFacturacionRepo;
        $this->clienteCalcularPorcentajesClienteRepo = $clienteCalcularPorcentajesClienteRepo;
        $this->clienteObtenerClientesLogisticaRepo = $clienteObtenerClientesLogisticaRepo;
        $this->clienteObtenerClientePorCodigoLogisticaRepo = $clienteObtenerClientePorCodigoLogisticaRepo;
        $this->clienteObtenerDatosClientePrecioRepo = $clienteObtenerDatosClientePrecioRepo;
    }

    public function obtenerClientes($cuit = '', $dni = '')
    {
        return $this->clienteObtenerClientesRepo->obtenerClientes($cuit, $dni);
    }

    public function obtenerDatosCliente($numCliente)
    {
        return $this->clienteObtenerDatosClienteRepo->obtenerDatosCliente($numCliente);
    }

    public function obtenerEstadoFacturacion($cli_codigo)
    {
        return $this->clienteObtenerEstadoFacturacionRepo->obtenerEstadoFacturacion($cli_codigo);
    }

    public function obtenerCondicionCliente($cli_codigo)
    {
        return $this->clienteObtenerCondicionClienteRepo->obtenerCondicionCliente($cli_codigo);
    }

    public function obtenerCliente($codigo)
    {
        return $this->clienteObtenerClienteRepo->obtenerCliente($codigo);
    }

    public function buscarCategoria($cli_cod)
    {
        return $this->clienteBuscarCategoriaClienteRepo->buscarCategoria($cli_cod);
    }

    public function actualizarCliente($id, array $datos)
    {
        return $this->clienteActualizarClienteRepo->actualizarCliente($id, $datos);
    }

    public function actualizarEstadoFacturacion($cli_codigo, $nuevoEstado)
    {
        return $this->clienteActualizarEstadoFacturacionRepo->actualizarEstadoFacturacion($cli_codigo, $nuevoEstado);
    }

    public function calcularPorcentajeCliente($clicod)
    {
        return $this->clienteCalcularPorcentajesClienteRepo->calcularPorcentajeCliente($clicod);
    }

    public function obtenerClientesLogistica($provincia = null)
    {
        return $this->clienteObtenerClientesLogisticaRepo->obtenerClientesLogistica($provincia);
    }
    
    public function obtenerClientePorCodigoLogistica($codigo)
    {
        return $this->clienteObtenerClientePorCodigoLogisticaRepo->obtenerClientePorCodigoLogistica($codigo);
    }

    public function datosCliente($clicod)
    {
        return $this->clienteObtenerDatosClientePrecioRepo->datosCliente($clicod);
    } 
}
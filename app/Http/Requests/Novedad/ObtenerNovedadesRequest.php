<?php

namespace App\Http\Requests\Novedad;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerNovedadesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cli_categoria' => 'nullable',
            'CliCod'        => 'nullable',
            'BanderaVen'    => 'nullable',
            'ORD'           => 'nullable',
            'PRICE'         => 'nullable',
            'PMIN'          => 'nullable',
            'PMAX'          => 'nullable',
            'TIPOCLIENTE'   => 'nullable',
            'PAGE'          => 'nullable',
            'CANT'          => 'nullable',
            'TIPPROD'       => 'nullable',
        ];
    }

    public function cliCategoria()     { return $this->query('cli_categoria'); }
    public function cliCod()           { return $this->query('CliCod', ''); }
    public function banderaVendedor()  { return $this->query('BanderaVen', ''); }
    public function orden()            { return $this->query('ORD', ''); }
    public function precio()            { return $this->query('PRICE', ''); }
    public function precioMin()        { return (float) $this->query('PMIN', 0); }
    public function precioMax()        { return (float) $this->query('PMAX', 100000000); }
    public function tipoCliente()      { return (int) $this->query('TIPOCLIENTE', 2); }
    public function pagina()           { return max((int) $this->query('PAGE', 1), 1); }
    public function cantidad()         { return max((int) $this->query('CANT', 40), 1); }
    public function tipoProducto()     { return $this->query('TIPPROD', ''); }
}
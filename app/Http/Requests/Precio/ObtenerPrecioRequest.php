<?php

namespace App\Http\Requests\Precio;

use Illuminate\Foundation\Http\FormRequest;

class ObtenerPrecioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CODTEX'  => 'nullable|string',
            'CODNUM'  => 'nullable|string',
            'ADICOD'  => 'nullable|string',
            'CANT'    => 'nullable|numeric|min:1',
            'CLICOD'  => 'nullable|string',
            'FPAGO'   => 'nullable|integer',
            'CVTA'    => 'nullable|integer',
            'Bandera' => 'nullable|boolean',
        ];
    }

    public function obtenerDatosCalculoDePrecio(): object
    {
        $validados = $this->validated();

        return (object) [
            'codtex'  => $validados['CODTEX']  ?? '',
            'codnum'  => $validados['CODNUM']  ?? '',
            'adicod'  => $validados['ADICOD']  ?? '',
            'cant'    => max($validados['CANT'] ?? 1, 1),
            'clicod'  => $validados['CLICOD']  ?? '',
            'formpag' => $validados['FPAGO']   ?? 0,
            'condvta' => $validados['CVTA']    ?? 0,
            'bandera' => $validados['Bandera'] ?? true,
        ];
    }
}

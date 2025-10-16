<?php

namespace App\Http\Requests\ResumenDeCuenta;

use Illuminate\Foundation\Http\FormRequest;

class ResumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fechaDesde' => 'required',
            'fechaHasta' => 'required',
            'clicod' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'fechaDesde.required' => 'La fecha desde es obligatoria.',
            'fechaHasta.required' => 'La fecha hasta es obligatoria.',
            'clicod.required' => 'El código de cliente es obligatorio.',
        ];
    }

    public function obtenerParametrosResumen(): \stdClass
    {
        return (object) [
            'fechaDesde' => $this->input('fechaDesde'),
            'fechaHasta' => $this->input('fechaHasta'),
            'clicod'     => $this->input('clicod'),
        ];
    }
}

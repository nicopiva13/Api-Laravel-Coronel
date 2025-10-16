<?php

namespace App\Http\Requests\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'nullable',
            'telefono' => 'nullable',
            'celular'  => 'nullable',
            'codpos1'  => 'nullable',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (
                is_null($this->email) &&
                is_null($this->telefono) &&
                is_null($this->celular) &&
                is_null($this->codpos1)
            ) {
                $validator->errors()->add(
                    'general',
                    'Debés proporcionar al menos uno de los siguientes campos: email, teléfono, celular o código postal.'
                );
            }
        });
    }

    public function datosActualizarCliente(): array
    {
        return [
            'cli_email'    => $this->email,
            'cli_telefono' => $this->telefono,
            'cli_celular'  => $this->celular,
            'cli_codpos1'  => $this->codpos1,
        ];
    }
}
<?php

namespace App\Repository\Empresa;

use Illuminate\Support\Facades\DB;

class EmpresaObtenerEmpresaRepository
{
    public function obtenerEmpresa()
    {
        return DB::table('Empresa')
            ->join('condIva as ci', 'Empresa.emp_iva', '=', 'ci.iva_codigo')
            ->select([
                'Empresa.emp_nombre',
                'Empresa.emp_fecini',
                DB::raw("Empresa.emp_cuit1 + Empresa.emp_cuit2 + Empresa.emp_cuit3 AS emp_cuit"),
                'Empresa.emp_ingbru',
                'Empresa.emp_domicilio',
                'Empresa.emp_telefono',
                'Empresa.emp_email',
                'Empresa.emp_locali',
                'ci.iva_condicion as iva_condicion'
            ])
            ->first();
    }
}

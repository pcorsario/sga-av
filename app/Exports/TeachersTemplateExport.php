<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersTemplateExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            ['Diego Armijos', 'diego.armijos@institucion.edu.ec', 'password123'],
            ['Elena Valarezo', 'elena.valarezo@institucion.edu.ec', 'profesor2024'],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nombres y Apellidos',
            'Correo Institucional',
            'Contraseña',
        ];
    }
}

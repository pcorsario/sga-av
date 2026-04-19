<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsTemplateExport implements FromArray, WithHeadings
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            ['Juan Pérez', 'juan.perez@estudiante.com', '8vo EGB "A"', 'cambiame123'],
            ['María García', 'maria.garcia@estudiante.com', '9no EGB "B"', 'estudiante2024'],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nombres y Apellidos',
            'Correo Estudiantil',
            'Nombre del Curso',
            'Contraseña',
        ];
    }
}

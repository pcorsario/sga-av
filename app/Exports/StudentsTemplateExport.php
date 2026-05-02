<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Juan Pérez', 'juan.perez@estudiante.com', '1712345678', '8vo EGB "A"', 'cambiame123'],
            ['María García', 'maria.garcia@estudiante.com', '1787654321', '9no EGB "B"', 'estudiante2024'],
        ];
    }

    public function headings(): array
    {
        return [
            'Nombres y Apellidos',
            'Correo Estudiantil',
            'Cédula',
            'Nombre del Curso',
            'Contraseña',
        ];
    }
}

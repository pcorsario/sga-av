<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TeachingLoadTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return [
            ['1ero Bachillerato "A"', 'Matemáticas', '1234567890'],
            ['1ero Bachillerato "A"', 'Lengua y Literatura', '0987654321'],
            ['8vo EGB "B"', 'Ciencias Naturales', '1122334455'],
        ];
    }

    public function headings(): array
    {
        return [
            'Curso',
            'Materia',
            'Cedula Profesor',
        ];
    }

    public function title(): string
    {
        return 'Plantilla Carga Horaria';
    }
}

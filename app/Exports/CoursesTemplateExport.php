<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CoursesTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return [
            ['Inicial 1A', 'Inicial 1', '1234567890'],
            ['Inicial 2B', 'Inicial 2', '0987654321'],
            ['8vo EGB "A"', 'Basica Superior', ''],
            ['1ero BGU "C"', 'Bachillerato', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'Nombre del Curso',
            'Nivel de Educación',
            'Cedula del Tutor',
        ];
    }

    public function title(): string
    {
        return 'Plantilla de Cursos';
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SubjectsTemplateExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        return [
            ['MATEMÁTICAS'],
            ['LENGUA Y LITERATURA'],
            ['CIENCIAS NATURALES'],
            ['ESTUDIOS SOCIALES'],
            ['INGLÉS'],
        ];
    }

    public function headings(): array
    {
        return [
            'Nombre de la Materia',
        ];
    }

    public function title(): string
    {
        return 'Plantilla de Materias';
    }
}

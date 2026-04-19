<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CoursesTemplateExport implements FromArray, WithHeadings, WithTitle
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            ['8vo EGB "A"', 'Básica Superior'],
            ['9no EGB "B"', 'Básica Superior'],
            ['1ero BGU "C"', 'Bachillerato'],
            ['2do BGU "A"', 'Bachillerato'],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nombre del Curso',
            'Nivel de Educación',
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Plantilla de Cursos';
    }
}

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
            ['Inicial 1A', 'Inicial 1', '1234567890', 'Identidad y Autonomía, Convivencia, Relaciones Lógico-Matemáticas'],
            ['Inicial 2B', 'Inicial 2', '0987654321', 'Comprensión y Expresión del Lenguaje, Expresión Artística'],
            ['8vo EGB "A"', 'Basica Superior', '', 'Matemáticas, Lengua y Literatura, Ciencias Naturales, Estudios Sociales'],
            ['1ero BGU "C"', 'Bachillerato', '', 'Física, Química, Biología, Emprendimiento y Gestión'],
        ];
    }

    public function headings(): array
    {
        return [
            'Nombre del Curso',
            'Nivel de Educación',
            'Cedula del Tutor',
            'Materias',
        ];
    }

    public function title(): string
    {
        return 'Plantilla de Cursos';
    }
}

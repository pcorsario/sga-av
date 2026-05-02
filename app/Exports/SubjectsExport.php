<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SubjectsExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        return Subject::select('name')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Nombre de la Materia',
        ];
    }

    public function title(): string
    {
        return 'Listado de Materias';
    }
}

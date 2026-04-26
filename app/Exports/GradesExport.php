<?php

namespace App\Exports;

use App\Exports\Sheets\TrimestreSheet;
use App\Models\CourseSubject;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GradesExport implements WithMultipleSheets
{
    use Exportable;

    protected $courseSubject;

    public function __construct(CourseSubject $courseSubject)
    {
        $this->courseSubject = $courseSubject;
    }

    public function sheets(): array
    {
        return [
            new TrimestreSheet($this->courseSubject, 't1', '1er Trimestre'),
            new TrimestreSheet($this->courseSubject, 't2', '2do Trimestre'),
            new TrimestreSheet($this->courseSubject, 't3', '3er Trimestre'),
        ];
    }
}

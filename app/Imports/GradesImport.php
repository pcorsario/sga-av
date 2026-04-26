<?php

namespace App\Imports;

use App\Imports\Sheets\TrimestreSheetImport;
use App\Models\CourseSubject;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class GradesImport implements WithMultipleSheets
{
    protected $courseSubject;

    public function __construct(CourseSubject $courseSubject)
    {
        $this->courseSubject = $courseSubject;
    }

    public function sheets(): array
    {
        return [
            0 => new TrimestreSheetImport($this->courseSubject, 't1'),
            1 => new TrimestreSheetImport($this->courseSubject, 't2'),
            2 => new TrimestreSheetImport($this->courseSubject, 't3'),
        ];
    }
}

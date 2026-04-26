<?php

namespace App\Exports\Sheets;

use App\Enums\RoleEnum;
use App\Models\CourseSubject;
use App\Models\Grade;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TrimestreSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $courseSubject;

    protected $trimestre;

    protected $title;

    public function __construct(CourseSubject $courseSubject, string $trimestre, string $title)
    {
        $this->courseSubject = $courseSubject;
        $this->trimestre = $trimestre;
        $this->title = $title;
    }

    public function collection()
    {
        return User::role(RoleEnum::Estudiante->value)
            ->whereHas('enrollments', function ($q) {
                $q->where('course_id', $this->courseSubject->course_id);
            })
            ->orderBy('name')
            ->get();
    }

    public function map($student): array
    {
        $grade = Grade::where('course_subject_id', $this->courseSubject->id)
            ->where('student_id', $student->id)
            ->first();

        $t = $this->trimestre;

        return [
            $student->id,
            $student->name,
            $grade ? $grade->{"{$t}_ind_1"} : '',
            $grade ? $grade->{"{$t}_ind_2"} : '',
            $grade ? $grade->{"{$t}_ind_3"} : '',
            $grade ? $grade->{"{$t}_ind_4"} : '',
            $grade ? $grade->{"{$t}_ind_5"} : '',
            $grade ? $grade->{"{$t}_ind_6"} : '',
            $grade ? $grade->{"{$t}_ref_1"} : '',
            $grade ? $grade->{"{$t}_grp_1"} : '',
            $grade ? $grade->{"{$t}_grp_2"} : '',
            $grade ? $grade->{"{$t}_grp_3"} : '',
            $grade ? $grade->{"{$t}_grp_4"} : '',
            $grade ? $grade->{"{$t}_grp_5"} : '',
            $grade ? $grade->{"{$t}_grp_6"} : '',
            $grade ? $grade->{"{$t}_ref_2"} : '',
            $grade ? $grade->{"{$t}_proj"} : '',
            $grade ? $grade->{"{$t}_eval"} : '',
            $grade ? $grade->observations : '',
        ];
    }

    public function headings(): array
    {
        return [
            ['ID Estudiante', 'Nombre', 'Insumos Individuales', '', '', '', '', '', 'Refuerzo Indiv', 'Insumos Grupales', '', '', '', '', '', 'Refuerzo Grupal', 'Resumen Trimestral', '', 'Observaciones'],
            ['(NO MODIFICAR)', '(NO MODIFICAR)', 'Ind 1', 'Ind 2', 'Ind 3', 'Ind 4', 'Ind 5', 'Ind 6', 'Ref Ind', 'Grp 1', 'Grp 2', 'Grp 3', 'Grp 4', 'Grp 5', 'Grp 6', 'Ref Grp', 'Proyecto', 'Evaluación', 'Obs'],
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '4B5563']]],
            2 => ['font' => ['bold' => true, 'color' => ['rgb' => '111827']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'F3F4F6']]],
            'A' => ['font' => ['color' => ['rgb' => '9CA3AF']]], // Gray out the ID column
        ];
    }
}

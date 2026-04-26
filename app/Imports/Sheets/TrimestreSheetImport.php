<?php

namespace App\Imports\Sheets;

use App\Enums\RoleEnum;
use App\Models\CourseSubject;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TrimestreSheetImport implements ToCollection
{
    protected $courseSubject;

    protected $trimestre;

    public function __construct(CourseSubject $courseSubject, string $trimestre)
    {
        $this->courseSubject = $courseSubject;
        $this->trimestre = $trimestre;
    }

    public function collection(Collection $rows)
    {
        $t = $this->trimestre;

        // Fetch students to validate IDs
        $validStudentIds = User::role(RoleEnum::Estudiante->value)
            ->whereHas('enrollments', function ($q) {
                $q->where('course_id', $this->courseSubject->course_id);
            })->pluck('id')->toArray();

        foreach ($rows as $index => $row) {
            // Skip the two header rows
            if ($index < 2) {
                continue;
            }

            $studentId = $row[0] ?? null;

            if (! $studentId || ! in_array($studentId, $validStudentIds)) {
                continue;
            }

            $gradeData = [
                "{$t}_ind_1" => $this->parseValue($row[2] ?? null),
                "{$t}_ind_2" => $this->parseValue($row[3] ?? null),
                "{$t}_ind_3" => $this->parseValue($row[4] ?? null),
                "{$t}_ind_4" => $this->parseValue($row[5] ?? null),
                "{$t}_ind_5" => $this->parseValue($row[6] ?? null),
                "{$t}_ind_6" => $this->parseValue($row[7] ?? null),
                "{$t}_ref_1" => $this->parseValue($row[8] ?? null),
                "{$t}_grp_1" => $this->parseValue($row[9] ?? null),
                "{$t}_grp_2" => $this->parseValue($row[10] ?? null),
                "{$t}_grp_3" => $this->parseValue($row[11] ?? null),
                "{$t}_grp_4" => $this->parseValue($row[12] ?? null),
                "{$t}_grp_5" => $this->parseValue($row[13] ?? null),
                "{$t}_grp_6" => $this->parseValue($row[14] ?? null),
                "{$t}_ref_2" => $this->parseValue($row[15] ?? null),
                "{$t}_proj" => $this->parseValue($row[16] ?? null),
                "{$t}_eval" => $this->parseValue($row[17] ?? null),
            ];

            if (isset($row[18])) {
                $gradeData['observations'] = $row[18];
            }

            Grade::updateOrCreate(
                [
                    'course_subject_id' => $this->courseSubject->id,
                    'student_id' => $studentId,
                ],
                $gradeData
            );
        }
    }

    private function parseValue($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Replace comma with dot for decimals
        $value = str_replace(',', '.', $value);

        if (is_numeric($value)) {
            $floatVal = (float) $value;

            // Clamp between 0 and 10
            return max(0, min(10, $floatVal));
        }

        return null;
    }
}

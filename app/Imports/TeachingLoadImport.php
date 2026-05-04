<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\Subject;
use App\Models\CourseSubject;
use App\Models\User;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachingLoadImport implements OnEachRow, WithHeadingRow
{
    public function __construct(private string $currentTeamSlug) {}

    public function onRow(Row $row)
    {
        $data = $row->toArray();

        $courseName = $data['curso'] ?? null;
        $subjectName = $data['materia'] ?? null;
        $teacherCedula = $data['cedula_profesor'] ?? null;

        if (!$courseName || !$subjectName || !$teacherCedula) {
            return;
        }

        $course = Course::where('name', 'like', $courseName)->first();
        $subject = Subject::where('name', 'like', $subjectName)->first();
        $teacher = User::where('cedula', $teacherCedula)->first();

        if ($course && $subject && $teacher) {
            CourseSubject::where('course_id', $course->id)
                ->where('subject_id', $subject->id)
                ->update(['teacher_id' => $teacher->id]);
        }
    }
}

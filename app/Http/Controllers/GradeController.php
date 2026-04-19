<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\CourseSubject;
use App\Models\DCD;
use App\Models\Grade;
use App\Models\InsumoName;
use App\Models\StudentDcd;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeController extends Controller
{
    public function edit(Request $request, $current_team, $courseSubject = null)
    {
        if (! $courseSubject instanceof CourseSubject) {
            $courseSubject = CourseSubject::findOrFail($current_team);
        }

        $user = $request->user();

        if (! $user->hasRole(RoleEnum::Autoridad->value) && $courseSubject->teacher_id !== $user->id) {
            abort(403, 'No tienes permiso para gestionar estas notas.');
        }

        $courseSubject->load(['course', 'subject']);

        $studentsCollection = User::role(RoleEnum::Estudiante->value)
            ->whereHas('enrollments', function ($q) use ($courseSubject) {
                $q->where('course_id', $courseSubject->course_id);
            })
            ->get();

        $students = $studentsCollection->map(function ($student) use ($courseSubject) {
            $grade = Grade::where('course_subject_id', $courseSubject->id)
                ->where('student_id', $student->id)
                ->first();

            return [
                'id' => $student->id,
                'name' => $student->name,
                'observations' => $grade?->observations ?? '',
                't1' => $this->extractTrimestreGrades($grade, 't1'),
                't2' => $this->extractTrimestreGrades($grade, 't2'),
                't3' => $this->extractTrimestreGrades($grade, 't3'),
            ];
        });

        $dcds = DCD::where('course_subject_id', $courseSubject->id)
            ->orderBy('number')
            ->get();

        if ($dcds->isEmpty()) {
            for ($i = 1; $i <= 10; $i++) {
                DCD::create([
                    'course_subject_id' => $courseSubject->id,
                    'name' => "DCD {$i}",
                    'number' => $i,
                ]);
            }
            $dcds = DCD::where('course_subject_id', $courseSubject->id)
                ->orderBy('number')
                ->get();
        }

        $studentDcds = [];
        foreach ($studentsCollection as $student) {
            $studentDcd = StudentDcd::firstOrCreate(
                [
                    'course_subject_id' => $courseSubject->id,
                    'student_id' => $student->id,
                ],
                ['selections' => array_fill(1, 10, false)]
            );
            $studentDcds[$student->id] = $studentDcd->toArray();
        }

        $insumoNames = [];
        foreach (['t1', 't2', 't3'] as $t) {
            $insumoNames[$t] = InsumoName::firstOrCreate(
                [
                    'course_subject_id' => $courseSubject->id,
                    'trimester' => $t,
                ],
                InsumoName::defaults()
            );
        }

        return Inertia::render('Academic/Grades/Edit', [
            'academic' => [
                'role' => $user->hasRole(RoleEnum::Autoridad->value) ? 'autoridad' : 'profesor',
            ],
            'courseSubject' => $courseSubject,
            'students' => $students,
            'dcds' => $dcds,
            'studentDcds' => $studentDcds,
            'insumoNames' => $insumoNames,
        ]);
    }

    protected function extractTrimestreGrades(?Grade $grade, string $trimestre): array
    {
        $data = [];

        for ($i = 1; $i <= 6; $i++) {
            $data["ind_{$i}"] = $grade ? $grade->{"{$trimestre}_ind_{$i}"} : null;
        }

        for ($i = 1; $i <= 6; $i++) {
            $data["grp_{$i}"] = $grade ? $grade->{"{$trimestre}_grp_{$i}"} : null;
        }

        for ($i = 1; $i <= 2; $i++) {
            $data["ref_{$i}"] = $grade ? $grade->{"{$trimestre}_ref_{$i}"} : null;
        }

        $data['proj'] = $grade ? $grade->{"{$trimestre}_proj"} : null;
        $data['eval'] = $grade ? $grade->{"{$trimestre}_eval"} : null;

        return $data;
    }

    public function update(Request $request, $current_team, $courseSubject = null)
    {
        if (! $courseSubject instanceof CourseSubject) {
            $courseSubject = CourseSubject::findOrFail($current_team);
        }

        $user = $request->user();

        if (! $user->hasRole(RoleEnum::Autoridad->value) && $courseSubject->teacher_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.id' => 'required|exists:users,id',
            'grades.*.observations' => 'nullable|string',
            'dcds' => 'required|array',
            'dcds.*.id' => 'required|exists:dcds,id',
            'dcds.*.name' => 'required|string|max:500',
            'student_dcds' => 'required|array',
            'student_dcds.*' => 'array',
            'student_dcds.*.*' => 'boolean',
            'insumo_names' => 'required|array',
            'insumo_names.t1' => 'required|array',
            'insumo_names.t2' => 'required|array',
            'insumo_names.t3' => 'required|array',
            'insumo_names.*.ind_1' => 'nullable|string|max:100',
            'insumo_names.*.ind_2' => 'nullable|string|max:100',
            'insumo_names.*.ind_3' => 'nullable|string|max:100',
            'insumo_names.*.ind_4' => 'nullable|string|max:100',
            'insumo_names.*.ind_5' => 'nullable|string|max:100',
            'insumo_names.*.ind_6' => 'nullable|string|max:100',
            'insumo_names.*.grp_1' => 'nullable|string|max:100',
            'insumo_names.*.grp_2' => 'nullable|string|max:100',
            'insumo_names.*.grp_3' => 'nullable|string|max:100',
            'insumo_names.*.grp_4' => 'nullable|string|max:100',
            'insumo_names.*.grp_5' => 'nullable|string|max:100',
            'insumo_names.*.grp_6' => 'nullable|string|max:100',
            'insumo_names.*.ref_1' => 'nullable|string|max:100',
            'insumo_names.*.ref_2' => 'nullable|string|max:100',
            'insumo_names.*.proj' => 'nullable|string|max:100',
            'insumo_names.*.eval' => 'nullable|string|max:100',
        ]);

        foreach ($validated['dcds'] as $dcdData) {
            DCD::where('id', $dcdData['id'])->update(['name' => $dcdData['name']]);
        }

        foreach ($validated['student_dcds'] as $studentId => $selections) {
            StudentDcd::updateOrCreate(
                [
                    'course_subject_id' => $courseSubject->id,
                    'student_id' => $studentId,
                ],
                ['selections' => $selections]
            );
        }

        foreach (['t1', 't2', 't3'] as $t) {
            InsumoName::updateOrCreate(
                [
                    'course_subject_id' => $courseSubject->id,
                    'trimester' => $t,
                ],
                $validated['insumo_names'][$t]
            );
        }

        $gradeRules = [
            'grades.*.id' => 'required|exists:users,id',
            'grades.*.observations' => 'nullable|string',
        ];

        foreach (['t1', 't2', 't3'] as $t) {
            for ($i = 1; $i <= 6; $i++) {
                $gradeRules["grades.*.{$t}_ind_{$i}"] = 'nullable|numeric|min:0|max:10';
            }
            for ($i = 1; $i <= 6; $i++) {
                $gradeRules["grades.*.{$t}_grp_{$i}"] = 'nullable|numeric|min:0|max:10';
            }
            for ($i = 1; $i <= 2; $i++) {
                $gradeRules["grades.*.{$t}_ref_{$i}"] = 'nullable|numeric|min:0|max:10';
            }
            $gradeRules["grades.*.{$t}_proj"] = 'nullable|numeric|min:0|max:10';
            $gradeRules["grades.*.{$t}_eval"] = 'nullable|numeric|min:0|max:10';
        }

        $gradeValidated = $request->validate($gradeRules);

        foreach ($gradeValidated['grades'] as $gradeData) {
            $updateData = ['observations' => $gradeData['observations'] ?? null];

            foreach (['t1', 't2', 't3'] as $t) {
                for ($i = 1; $i <= 6; $i++) {
                    $updateData["{$t}_ind_{$i}"] = $gradeData["{$t}_ind_{$i}"] ?? null;
                }
                for ($i = 1; $i <= 6; $i++) {
                    $updateData["{$t}_grp_{$i}"] = $gradeData["{$t}_grp_{$i}"] ?? null;
                }
                for ($i = 1; $i <= 2; $i++) {
                    $updateData["{$t}_ref_{$i}"] = $gradeData["{$t}_ref_{$i}"] ?? null;
                }
                $updateData["{$t}_proj"] = $gradeData["{$t}_proj"] ?? null;
                $updateData["{$t}_eval"] = $gradeData["{$t}_eval"] ?? null;
            }

            Grade::updateOrCreate(
                [
                    'course_subject_id' => $courseSubject->id,
                    'student_id' => $gradeData['id'],
                ],
                $updateData
            );
        }

        return back()->with('status', 'Calificaciones actualizadas exitosamente.');
    }
}

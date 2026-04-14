<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\CourseSubject;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradeController extends Controller
{
    public function edit(Request $request, string $current_team, CourseSubject $courseSubject)
    {
        $user = $request->user();

        // Seguridad básica: Verificar que el profesor sea el asignado o sea autoridad
        if (! $user->hasRole(RoleEnum::Autoridad->value) && $courseSubject->teacher_id !== $user->id) {
            abort(403, 'No tienes permiso para gestionar estas notas.');
        }

        $courseSubject->load(['course', 'subject']);

        // Obtener estudiantes matriculados en el curso
        $students = User::role(RoleEnum::Estudiante->value)
            ->whereHas('enrollments', function ($q) use ($courseSubject) {
                $q->where('course_id', $courseSubject->course_id);
            })
            ->get()
            ->map(function ($student) use ($courseSubject) {
                $grade = Grade::where('course_subject_id', $courseSubject->id)
                    ->where('student_id', $student->id)
                    ->first();

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'score' => null, // Placeholder in case frontend has references? No, replace fully
                    't1' => $grade?->t1,
                    't2' => $grade?->t2,
                    't3' => $grade?->t3,
                    'observations' => $grade?->observations ?? '',
                ];
            });

        return Inertia::render('Academic/Grades/Edit', [
            'courseSubject' => $courseSubject,
            'students' => $students,
        ]);
    }

    public function update(Request $request, string $current_team, CourseSubject $courseSubject)
    {
        $user = $request->user();

        if (! $user->hasRole(RoleEnum::Autoridad->value) && $courseSubject->teacher_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.id' => 'required|exists:users,id',
            'grades.*.t1' => 'nullable|numeric|min:0|max:10',
            'grades.*.t2' => 'nullable|numeric|min:0|max:10',
            'grades.*.t3' => 'nullable|numeric|min:0|max:10',
            'grades.*.observations' => 'nullable|string',
        ]);

        foreach ($validated['grades'] as $gradeData) {
            Grade::updateOrCreate(
                [
                    'course_subject_id' => $courseSubject->id,
                    'student_id' => $gradeData['id'],
                ],
                [
                    't1' => $gradeData['t1'] ?? null,
                    't2' => $gradeData['t2'] ?? null,
                    't3' => $gradeData['t3'] ?? null,
                    'observations' => $gradeData['observations'],
                ]
            );
        }

        return back()->with('status', 'Calificaciones actualizadas exitosamente.');
    }
}

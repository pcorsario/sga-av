<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseBoardSetting;
use App\Models\Grade;
use App\Models\ReportOption;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CourseBoardController extends Controller
{
    public function showSettings(Course $course, $trimestre)
    {
        $setting = CourseBoardSetting::firstOrCreate(
            ['course_id' => $course->id, 'trimestre' => $trimestre]
        );

        $options = [
            'dece' => ReportOption::where('type', 'dece')->get()->groupBy('category'),
            'comportamiento' => ReportOption::where('type', 'comportamiento')->get()->groupBy('category'),
            'resolucion' => ReportOption::where('type', 'resolucion')->get()->groupBy('category'),
        ];

        return response()->json([
            'setting' => $setting,
            'options' => $options,
        ]);
    }

    public function updateSettings(Request $request, Course $course, $trimestre)
    {
        $validated = $request->validate([
            'nee_students' => 'nullable|string',
            'dece_options' => 'nullable|array',
            'behavior_options' => 'nullable|array',
            'resolution_options' => 'nullable|array',
        ]);

        $setting = CourseBoardSetting::firstOrCreate(
            ['course_id' => $course->id, 'trimestre' => $trimestre]
        );

        $setting->update($validated);

        return response()->json(['message' => 'Ajustes guardados correctamente']);
    }

    public function exportPdf(Course $course, $trimestre)
    {
        $course->load(['tutor', 'courseSubjects.subject', 'courseSubjects.teacher', 'enrollments.student']);
        $setting = CourseBoardSetting::where('course_id', $course->id)->where('trimestre', $trimestre)->first();

        $students = $course->enrollments->pluck('student')->sortBy('last_name');
        $subjects = $course->courseSubjects;

        $grades = Grade::whereIn('course_subject_id', $subjects->pluck('id'))->get();

        $reportData = [];
        $studentsBelowSeven = [];
        $subjectAverages = [];

        foreach ($subjects as $subject) {
            $subjectAverages[$subject->id] = ['sum' => 0, 'count' => 0];
        }

        foreach ($students as $student) {
            $studentAverages = [];
            $hasBelowSeven = false;
            $studentTotal = 0;
            $studentCount = 0;

            foreach ($subjects as $subject) {
                $grade = $grades->where('student_id', $student->id)->where('course_subject_id', $subject->id)->first();

                $promedioParcial = null;
                $sin_calificacion = true;

                if ($grade) {
                    $indSum = 0;
                    $indCount = 0;
                    for ($i = 1; $i <= 6; $i++) {
                        $val = $grade->{"{$trimestre}_ind_{$i}"};
                        if ($val !== null) {
                            $indSum += (float) $val;
                            $indCount++;
                        }
                    }
                    $promInd = $indCount > 0 ? $indSum / $indCount : 0;
                    if ($grade->{"{$trimestre}_ref_1"} !== null) {
                        $promInd = max($promInd, (float) $grade->{"{$trimestre}_ref_1"});
                    }

                    $grpSum = 0;
                    $grpCount = 0;
                    for ($i = 1; $i <= 6; $i++) {
                        $val = $grade->{"{$trimestre}_grp_{$i}"};
                        if ($val !== null) {
                            $grpSum += (float) $val;
                            $grpCount++;
                        }
                    }
                    $promGrp = $grpCount > 0 ? $grpSum / $grpCount : 0;
                    if ($grade->{"{$trimestre}_ref_2"} !== null) {
                        $promGrp = max($promGrp, (float) $grade->{"{$trimestre}_ref_2"});
                    }

                    $promedioActividades = ($promInd + $promGrp) / 2;
                    $actividades70 = $promedioActividades * 0.70;

                    $notaProyecto = $grade->{"{$trimestre}_proj"};
                    $proyecto10 = $notaProyecto !== null ? (float) $notaProyecto * 0.10 : 0;

                    $notaEvaluacion = $grade->{"{$trimestre}_eval"};
                    $evaluacion20 = $notaEvaluacion !== null ? (float) $notaEvaluacion * 0.20 : 0;

                    $sin_calificacion = ($promInd == 0 && $promGrp == 0 && $notaProyecto === null && $notaEvaluacion === null);

                    if (! $sin_calificacion) {
                        $promedioParcial = $actividades70 + $proyecto10 + $evaluacion20;
                        $subjectAverages[$subject->id]['sum'] += $promedioParcial;
                        $subjectAverages[$subject->id]['count']++;

                        $studentTotal += $promedioParcial;
                        $studentCount++;
                    }
                }

                $studentAverages[$subject->id] = [
                    'promedio' => $promedioParcial,
                    'sin_calificacion' => $sin_calificacion,
                ];

                if ($sin_calificacion || ($promedioParcial !== null && $promedioParcial < 7)) {
                    $hasBelowSeven = true;
                }
            }

            if ($hasBelowSeven) {
                $studentsBelowSeven[] = [
                    'student' => $student,
                    'averages' => $studentAverages,
                ];
            }
        }

        $finalSubjectAverages = [];
        foreach ($subjects as $subject) {
            $count = $subjectAverages[$subject->id]['count'];
            $finalSubjectAverages[$subject->id] = $count > 0 ? $subjectAverages[$subject->id]['sum'] / $count : 0;
        }

        $deceOptions = ReportOption::whereIn('id', $setting->dece_options ?? [])->get();
        $behaviorOptions = ReportOption::whereIn('id', $setting->behavior_options ?? [])->get();
        $resolutionOptions = ReportOption::whereIn('id', $setting->resolution_options ?? [])->get();

        $pdf = Pdf::loadView('reports.acta_junta', [
            'course' => $course,
            'trimestre' => $trimestre,
            'subjects' => $subjects,
            'studentsBelowSeven' => $studentsBelowSeven,
            'subjectAverages' => $finalSubjectAverages,
            'setting' => $setting,
            'deceOptions' => $deceOptions,
            'behaviorOptions' => $behaviorOptions,
            'resolutionOptions' => $resolutionOptions,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('Acta_Junta_Curso_'.$course->name.'_'.$trimestre.'.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\CourseSubject;
use App\Models\Domain;
use App\Models\EvaluationItem;
use App\Models\QualitativeGrade;
use App\Models\SelectedEvaluationItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QualitativeGradeController extends Controller
{
    /**
     * Muestra la interfaz de calificación cualitativa por materia.
     */
    public function edit(Request $request, CourseSubject $courseSubject)
    {
        $courseSubject->load(['course', 'subject']);
        $course = $courseSubject->course;

        // Obtener los ámbitos correspondientes al nivel del curso
        $level = $course->level ?? 'inicial_2';

        // En SGA, la Materia (Subject) corresponde al Ámbito.
        // Buscamos el Domain cuyo nombre coincida con el de la Materia y el nivel
        $selectedDomain = Domain::where('name', $courseSubject->subject->name)
            ->where('level', $level)
            ->first();

        if (! $selectedDomain) {
            $selectedDomain = Domain::create([
                'name' => $courseSubject->subject->name,
                'level' => $level,
            ]);
        }
        $selectedDomain->load('evaluationItems');

        if ($selectedDomain->evaluationItems->isEmpty()) {
            for ($i = 1; $i <= 5; $i++) {
                $selectedDomain->evaluationItems()->create([
                    'description' => "Destreza genérica $i. Por favor asigne destrezas reales en la configuración.",
                    'type' => 'destreza',
                ]);
            }
            $selectedDomain->load('evaluationItems');
        }

        $domains = collect([$selectedDomain]);

        // Obtener los estudiantes del curso
        $students = User::role(RoleEnum::Estudiante->value)
            ->whereHas('enrollments', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->orderBy('name')
            ->get();

        // Obtener las calificaciones existentes para este curso y ámbito
        $grades = [];
        if ($selectedDomain) {
            $itemIds = $selectedDomain->evaluationItems->pluck('id');
            $grades = QualitativeGrade::where('course_id', $course->id)
                ->whereIn('evaluation_item_id', $itemIds)
                ->get()
                ->keyBy(function ($item) {
                    // Clave compuesta: student_id - evaluation_item_id
                    return $item->student_id.'-'.$item->evaluation_item_id;
                });
        }

        // Obtener las destrezas seleccionadas para este curso-materia y trimestre
        $quarter = $request->input('quarter', 'q1');
        $selectedItemIds = SelectedEvaluationItem::where('course_subject_id', $courseSubject->id)
            ->where('quarter', $quarter)
            ->pluck('evaluation_item_id')
            ->toArray();

        return Inertia::render('Academic/QualitativeGrades/Index', [
            'course' => $course,
            'courseSubject' => $courseSubject,
            'domains' => $domains,
            'selectedDomain' => $selectedDomain,
            'students' => $students,
            'existingGrades' => $grades,
            'quarter' => $quarter,
            'selectedItemIds' => $selectedItemIds,
        ]);
    }

    /**
     * Almacena masivamente las calificaciones cualitativas ingresadas en la vista.
     */
    public function store(Request $request, CourseSubject $courseSubject)
    {
        $courseSubject->load(['course']);
        $course = $courseSubject->course;

        $validated = $request->validate([
            'quarter' => 'required|in:q1,q2,q3,diagnostic',
            'grades' => 'required|array',
            'grades.*.*' => 'nullable',
        ]);

        $quarterField = $validated['quarter'].'_grade';

        foreach ($validated['grades'] as $studentId => $items) {
            foreach ($items as $itemId => $gradeValue) {
                if ($gradeValue === null || $gradeValue === '') {
                    continue;
                }

                QualitativeGrade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'course_id' => $course->id,
                        'evaluation_item_id' => $itemId,
                    ],
                    [
                        $quarterField => $gradeValue,
                    ]
                );
            }
        }

        if ($request->boolean('auto_save')) {
            return back();
        }

        return redirect()->back()->with('success', 'Calificaciones cualitativas guardadas exitosamente.');
    }

    /**
     * Actualiza las destrezas seleccionadas para ser evaluadas en un trimestre.
     */
    public function updateSelectedItems(Request $request, CourseSubject $courseSubject)
    {
        $validated = $request->validate([
            'quarter' => 'required|string|in:q1,q2,q3,diagnostic',
            'itemIds' => 'required|array',
        ]);

        // Eliminar selecciones previas para este trimestre
        SelectedEvaluationItem::where('course_subject_id', $courseSubject->id)
            ->where('quarter', $validated['quarter'])
            ->delete();

        // Crear nuevas selecciones
        foreach ($validated['itemIds'] as $itemId) {
            SelectedEvaluationItem::create([
                'course_subject_id' => $courseSubject->id,
                'evaluation_item_id' => $itemId,
                'quarter' => $validated['quarter'],
            ]);
        }

        return redirect()->back()->with('success', 'Destrezas configuradas exitosamente.');
    }

    /**
     * Genera el reporte PDF de la evaluación diagnóstica cualitativa.
     */
    public function exportPdf(Request $request, CourseSubject $courseSubject)
    {
        $user = $request->user();
        if (! $user->hasRole(RoleEnum::Autoridad->value) && $courseSubject->teacher_id !== $user->id) {
            abort(403);
        }

        $courseSubject->load(['course', 'subject', 'teacher']);
        $course = $courseSubject->course;

        // Obtener destrezas seleccionadas para el diagnóstico
        $selectedItems = EvaluationItem::whereIn('id', function ($query) use ($courseSubject) {
            $query->select('evaluation_item_id')
                ->from('selected_evaluation_items')
                ->where('course_subject_id', $courseSubject->id)
                ->where('quarter', 'diagnostic');
        })->get();

        if ($selectedItems->isEmpty()) {
            return back()->with('error', 'No se han configurado destrezas para el diagnóstico.');
        }

        $studentsCollection = User::role(RoleEnum::Estudiante->value)
            ->whereHas('enrollments', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->orderBy('name')
            ->get();

        $grades = QualitativeGrade::where('course_id', $course->id)
            ->whereIn('evaluation_item_id', $selectedItems->pluck('id'))
            ->get()
            ->groupBy('student_id');

        $columnTotals = [];
        foreach ($selectedItems as $item) {
            $columnTotals[$item->id] = 0;
        }

        $totalSelections = 0;
        $statusCounts = ['LOGRADO' => 0, 'EN PROCESO' => 0, 'INICIADO' => 0];
        $itemsCount = $selectedItems->count();

        $studentsData = $studentsCollection->map(function ($student) use ($grades, $selectedItems, &$columnTotals, &$totalSelections, &$statusCounts, $itemsCount) {
            $studentGrades = $grades->get($student->id, collect())->keyBy('evaluation_item_id');
            $selections = [];
            $count = 0;

            foreach ($selectedItems as $item) {
                $val = $studentGrades->get($item->id)->diagnostic_grade ?? 0;
                $selections[$item->id] = $val == 1;
                if ($val == 1) {
                    $count++;
                    $columnTotals[$item->id]++;
                }
            }

            $totalSelections += $count;
            $percentage = $itemsCount > 0 ? ($count / $itemsCount) * 100 : 0;

            $statusText = 'INICIADO';
            if ($percentage >= 70) {
                $statusText = 'LOGRADO';
            } elseif ($percentage >= 39) {
                $statusText = 'EN PROCESO';
            }

            $statusCounts[$statusText]++;

            return (object) [
                'name' => $student->name,
                'selections' => $selections,
                'total' => $count,
                'percentage' => round($percentage),
                'status' => ['text' => $statusText],
            ];
        });

        // Gráfico de Pastel (SVG)
        $pieData = [];
        $totalStudents = count($studentsData);
        if ($totalStudents > 0) {
            $startAngle = 0;
            $colors = ['LOGRADO' => '#9bbb59', 'EN PROCESO' => '#c0504d', 'INICIADO' => '#4f81bd'];
            foreach ($statusCounts as $label => $count) {
                if ($count > 0) {
                    $angle = ($count / $totalStudents) * 360;
                    $endAngle = $startAngle + $angle;
                    $x1 = round(50 + 50 * cos(deg2rad($startAngle - 90)), 2);
                    $y1 = round(50 + 50 * sin(deg2rad($startAngle - 90)), 2);
                    $x2 = round(50 + 50 * cos(deg2rad($endAngle - 90)), 2);
                    $y2 = round(50 + 50 * sin(deg2rad($endAngle - 90)), 2);
                    $largeArc = $angle > 180 ? 1 : 0;
                    $pieData[] = [
                        'label' => $label === 'EN PROCESO' ? 'PROCESO' : $label,
                        'percentage' => round(($count / $totalStudents) * 100),
                        'path' => "M 50 50 L $x1 $y1 A 50 50 0 $largeArc 1 $x2 $y2 Z",
                        'color' => $colors[$label] ?? '#ccc',
                    ];
                    $startAngle = $endAngle;
                }
            }
        }

        $columnPercentages = [];
        $columnEscalas = [];
        foreach ($selectedItems as $item) {
            $perc = $totalStudents > 0 ? round(($columnTotals[$item->id] / $totalStudents) * 100, 2) : 0;
            $columnPercentages[$item->id] = $perc;
            if ($perc >= 70) {
                $columnEscalas[$item->id] = 'LOGRADO';
            } elseif ($perc >= 39) {
                $columnEscalas[$item->id] = 'EN PROCESO';
            } else {
                $columnEscalas[$item->id] = 'INICIADO';
            }
        }

        $overallPercentage = ($totalStudents * $itemsCount) > 0 ? round(($totalSelections / ($totalStudents * $itemsCount)) * 100) : 0;

        // Análisis Dinámico
        $totalEvaluados = array_sum($statusCounts);
        arsort($statusCounts);
        $keys = array_keys($statusCounts);
        $faseMayoritaria = $keys[0];
        $porcentajeMayor = $totalEvaluados > 0 ? round(($statusCounts[$keys[0]] / $totalEvaluados) * 100, 1) : 0;
        $materiaNombre = strtolower($courseSubject->subject->name);

        if ($faseMayoritaria === 'LOGRADO') {
            $analisisTexto = "Tenemos como resultado de la evaluación diagnóstica un {$porcentajeMayor}% lo que posiciona a este curso en la fase \"LOGRADO\". Aunque se obtuvo este porcentaje, creo que es necesario reforzar las destrezas de {$materiaNombre} para consolidar una base sólida.";
        } elseif ($faseMayoritaria === 'EN PROCESO') {
            $analisisTexto = "Tenemos como resultado de la evaluación diagnóstica un {$porcentajeMayor}% lo que posiciona a este curso en la fase \"PROCESO\". Es fundamental intensificar el refuerzo académico en {$materiaNombre} para que los estudiantes adquieran las destrezas necesarias.";
        } else {
            $analisisTexto = "Tenemos como resultado de la evaluación diagnóstica un {$porcentajeMayor}% lo que posiciona a este curso en la fase \"INICIADO\". Es imperativo implementar estrategias de nivelación desde cero en {$materiaNombre}.";
        }

        $pdf = Pdf::loadView('reports.qualitative-diagnostic', [
            'course' => $course,
            'subject' => $courseSubject->subject,
            'teacher' => $courseSubject->teacher,
            'studentsData' => $studentsData,
            'selectedItems' => $selectedItems,
            'columnTotals' => $columnTotals,
            'columnPercentages' => $columnPercentages,
            'columnEscalas' => $columnEscalas,
            'totalSelections' => $totalSelections,
            'overallPercentage' => $overallPercentage,
            'statusCounts' => $statusCounts,
            'pieData' => $pieData,
            'analisisTexto' => $analisisTexto,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("Reporte_Diagnostico_Cualitativo_{$courseSubject->subject->name}.pdf");
    }

    public function exportTrimestrePdf(Request $request, CourseSubject $courseSubject, $quarter)
    {
        // Placeholder para futuros reportes trimestrales cualitativos
        return "Reporte para $quarter en desarrollo.";
    }
}

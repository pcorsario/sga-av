<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeachingLoadTemplateExport;
use App\Imports\TeachingLoadImport;

class TeachingLoadController extends Controller
{
    public function index(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        $courses = Course::with(['courseSubjects.subject', 'courseSubjects.teacher'])
            ->orderBy('level')
            ->orderBy('name')
            ->get();

        $teachers = User::role(RoleEnum::Profesor->value)
            ->whereHas('teams', function ($query) use ($current_team) {
                $query->where('slug', $current_team);
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Academic/TeachingLoad/Index', [
            'courses' => $courses,
            'teachers' => $teachers,
        ]);
    }

    public function update(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.course_subject_id' => 'required|exists:course_subjects,id',
            'assignments.*.teacher_id' => 'nullable|exists:users,id',
        ]);

        foreach ($request->assignments as $assignment) {
            CourseSubject::where('id', $assignment['course_subject_id'])
                ->update(['teacher_id' => $assignment['teacher_id']]);
        }

        return redirect()->back()->with('status', 'Carga horaria actualizada exitosamente.');
    }

    public function exportTemplate()
    {
        return Excel::download(new TeachingLoadTemplateExport, 'plantilla_carga_horaria.xlsx');
    }

    public function importExcel(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new TeachingLoadImport($current_team), $request->file('file'));

            return redirect()->back()->with('status', 'Carga horaria importada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Error al importar archivo: '.$e->getMessage()]);
        }
    }

    protected function authorizeAccess(Request $request)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Exports\CoursesTemplateExport;
use App\Imports\CoursesImport;
use App\Models\Course;
use App\Models\CourseSubject;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    /**
     * Download the Excel template for courses.
     */
    public function exportTemplate()
    {
        return Excel::download(new CoursesTemplateExport, 'plantilla_cursos.xlsx');
    }

    /**
     * Import courses from an Excel file.
     */
    public function importExcel(Request $request, string $current_team)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new CoursesImport, $request->file('file'));

            return redirect()->route('courses.index', ['current_team' => $current_team])
                ->with('status', 'Cursos importados exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Error al importar archivo: '.$e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $current_team)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $courses = Course::with(['subjects', 'tutor'])->orderBy('level')->orderBy('name')->get();

        return Inertia::render('Academic/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, string $current_team)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $teachers = User::role(RoleEnum::Profesor->value)->orderBy('name')->get(['id', 'name']);

        return Inertia::render('Academic/Courses/Create', [
            'teachers' => $teachers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $current_team)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'tutor_id' => 'nullable|exists:users,id',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index', ['current_team' => $current_team])
            ->with('status', 'Curso creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function subjects(Request $request, string $current_team, Course $course)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $allSubjects = Subject::orderBy('name')->get();
        // we pluck subject_ids the course already has via its courseSubjects pivot model
        $courseSubjectIds = $course->courseSubjects()->pluck('subject_id')->toArray();

        // Let's pass the subjects list to the frontend, along with what is checked
        return Inertia::render('Academic/Courses/Subjects', [
            'course' => $course,
            'allSubjects' => $allSubjects,
            'assignedIds' => $courseSubjectIds,
        ]);
    }

    public function updateSubjects(Request $request, string $current_team, Course $course)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'subjects' => 'array',
        ]);

        $selectedSubjectIds = $request->input('subjects', []);

        // Find existing course_subjects records for this course to see what to delete
        $existingCourseSubjects = $course->courseSubjects()->get();
        $existingSubjectIds = $existingCourseSubjects->pluck('subject_id')->toArray();

        // Subjects to remove
        $toRemove = array_diff($existingSubjectIds, $selectedSubjectIds);
        if (! empty($toRemove)) {
            $course->courseSubjects()->whereIn('subject_id', $toRemove)->delete();
        }

        // Subjects to add
        $toAdd = array_diff($selectedSubjectIds, $existingSubjectIds);

        $newCourseSubjects = [];
        $now = now();
        foreach ($toAdd as $subjectId) {
            $newCourseSubjects[] = [
                'course_id' => $course->id,
                'subject_id' => $subjectId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($newCourseSubjects)) {
            CourseSubject::insert($newCourseSubjects);
        }

        return redirect()->route('courses.index', ['current_team' => $current_team])
            ->with('status', 'Malla de materias actualizada exitosamente para este curso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

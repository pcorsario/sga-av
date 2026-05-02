<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Exports\TeachersTemplateExport;
use App\Imports\TeachersImport;
use App\Models\CourseSubject;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class TeacherController extends Controller
{
    /**
     * Download the Excel template for teachers.
     */
    public function exportTemplate()
    {
        return Excel::download(new TeachersTemplateExport, 'plantilla_profesores.xlsx');
    }

    /**
     * Import teachers from an Excel file.
     */
    public function importExcel(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new TeachersImport($current_team), $request->file('file'));

            return redirect()->route('teachers.index', ['current_team' => $current_team])
                ->with('status', 'Nómina de profesores importada exitosamente.');
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = "Fila {$failure->row()}: ".implode(', ', $failure->errors());
            }

            return back()->withErrors(['file' => implode(' | ', $messages)]);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Error al importar el archivo: '.$e->getMessage()]);
        }
    }

    public function index(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        $search = $request->input('search');

        $teachers = User::role(RoleEnum::Profesor->value)
            ->whereHas('teams', function ($query) use ($current_team) {
                $query->where('slug', $current_team);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->withCount('assignedSubjects')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Academic/Teachers/Index', [
            'teachers' => $teachers,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        return Inertia::render('Academic/Teachers/Create');
    }

    public function store(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'cedula' => 'required|string|size:10|unique:'.User::class,
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $teacher = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cedula' => $validated['cedula'],
            'password' => ! empty($validated['password']) ? Hash::make($validated['password']) : Hash::make(Str::random(12)),
        ]);

        $teacher->assignRole(RoleEnum::Profesor->value);

        // Registrar la pertenencia al equipo actual.
        $team = Team::where('slug', $current_team)->first();
        if ($team) {
            if (! $team->members()->where('user_id', $teacher->id)->exists()) {
                $team->members()->attach($teacher->id, ['role' => 'member']);
            }
            $teacher->forceFill([
                'current_team_id' => $team->id,
            ])->save();
        }

        return redirect()->route('teachers.index', ['current_team' => $current_team])
            ->with('status', 'Profesor registrado exitosamente en la nómina.');
    }

    public function edit(Request $request, string $current_team, User $teacher)
    {
        $this->authorizeAccess($request);

        return Inertia::render('Academic/Teachers/Edit', [
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'email' => $teacher->email,
                'cedula' => $teacher->cedula,
            ],
        ]);
    }

    public function update(Request $request, string $current_team, User $teacher)
    {
        $this->authorizeAccess($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class.',email,'.$teacher->id,
            'cedula' => 'required|string|size:10|unique:'.User::class.',cedula,'.$teacher->id,
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];
        $teacher->cedula = $validated['cedula'];

        if (! empty($validated['password'])) {
            $teacher->password = Hash::make($validated['password']);
        }

        $teacher->save();

        return redirect()->route('teachers.index', ['current_team' => $current_team])
            ->with('status', 'Información del profesor actualizada exitosamente.');
    }

    public function subjects(Request $request, string $current_team, User $teacher)
    {
        $this->authorizeAccess($request);

        $courseSubjects = CourseSubject::with(['course', 'subject', 'teacher'])->get();
        $assignedIds = CourseSubject::where('teacher_id', $teacher->id)->pluck('id');

        return Inertia::render('Academic/Teachers/Subjects', [
            'teacher' => [
                'id' => $teacher->id,
                'name' => $teacher->name,
                'email' => $teacher->email,
            ],
            'courseSubjects' => $courseSubjects,
            'assignedIds' => $assignedIds,
        ]);
    }

    public function updateSubjects(Request $request, string $current_team, User $teacher)
    {
        $this->authorizeAccess($request);

        $request->validate([
            'course_subjects' => 'array',
        ]);

        $selectedIds = $request->input('course_subjects', []);

        // Remover las asignturas que enseñaba este maestro pero que fueron desmarcadas
        CourseSubject::where('teacher_id', $teacher->id)
            ->whereNotIn('id', $selectedIds)
            ->update(['teacher_id' => null]);

        // Asignar las marcadas a este maestro
        if (! empty($selectedIds)) {
            CourseSubject::whereIn('id', $selectedIds)
                ->update(['teacher_id' => $teacher->id]);
        }

        return redirect()->route('teachers.index', ['current_team' => $current_team])
            ->with('status', 'Carga horaria asignada exitosamente al profesor.');
    }

    protected function authorizeAccess(Request $request)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }
    }
}

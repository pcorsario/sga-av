<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\CourseSubject;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class TeacherController extends Controller
{
    public function index(Request $request, string $current_team)
    {
        $this->authorizeAccess($request);

        $teachers = User::role(RoleEnum::Profesor->value)
            ->withCount('assignedSubjects')
            ->latest()
            ->paginate(15);

        return Inertia::render('Academic/Teachers/Index', [
            'teachers' => $teachers,
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
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $teacher = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => ! empty($validated['password']) ? Hash::make($validated['password']) : Hash::make(Str::random(12)),
        ]);

        $teacher->assignRole(RoleEnum::Profesor->value);

        // Registrar la pertenencia al equipo actual.
        $team = Team::where('slug', $current_team)->first();
        if ($team && ! $team->members->contains($teacher)) {
            $team->members()->attach($teacher, ['role' => 'editor']);
            $teacher->switchTeam($team);
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
            ],
        ]);
    }

    public function update(Request $request, string $current_team, User $teacher)
    {
        $this->authorizeAccess($request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class.',email,'.$teacher->id,
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $teacher->name = $validated['name'];
        $teacher->email = $validated['email'];

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

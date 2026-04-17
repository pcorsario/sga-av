<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $current_team)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        // $students = User::with(['enrollments.course'])
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(15);

        $students = User::role(RoleEnum::Estudiante->value)
            ->with(['enrollments.course'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        // dd($students->toArray());
        return Inertia::render('Academic/Students/Index', [
            'students' => $students,
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

        $courses = Course::orderBy('level')->orderBy('name')->get();

        return Inertia::render('Academic/Students/Create', [
            'courses' => $courses,
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'course_id' => 'required|exists:courses,id',
        ]);

        $team = Team::where('slug', $current_team)->firstOrFail();

        DB::transaction(function () use ($validated, $team) {
            $student = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'current_team_id' => $team->id,
            ]);

            $student->assignRole(RoleEnum::Estudiante->value);
            $team->members()->attach($student->id, ['role' => 'member']);

            Enrollment::create([
                'student_id' => $student->id,
                'course_id' => $validated['course_id'],
            ]);

            // Note: In an actual environment, parents association would also need to be handled,
            // but for now, we'll just handle the student.
        });

        return redirect()->route('students.index', ['current_team' => $current_team])
            ->with('status', 'Estudiante matriculado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $current_team, User $student)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $courses = Course::orderBy('level')->orderBy('name')->get();
        $student->load('enrollments.course');

        return Inertia::render('Academic/Students/Edit', [
            'student' => $student,
            'courses' => $courses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, User $student)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$student->id,
            'password' => 'nullable|string|min:8|confirmed',
            'course_id' => 'required|exists:courses,id',
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->name = $validated['name'];
            $student->email = $validated['email'];

            if (! empty($validated['password'])) {
                $student->password = Hash::make($validated['password']);
            }

            $student->save();

            // Actualizar la matrícula (asumiendo 1 curso activo por estudiante en este MVP)
            Enrollment::updateOrCreate(
                ['student_id' => $student->id],
                ['course_id' => $validated['course_id']]
            );
        });

        return redirect()->route('students.index', ['current_team' => $current_team])
            ->with('status', 'Información del estudiante actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $current_team, User $student)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $student->delete();

        return redirect()->route('students.index', ['current_team' => $current_team])
            ->with('status', 'Estudiante eliminado exitosamente.');
    }
}

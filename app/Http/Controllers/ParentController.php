<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $current_team)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $parents = User::role(RoleEnum::Padre->value)
            ->with(['children.enrollments.course'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Academic/Parents/Index', [
            'parents' => $parents,
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

        $students = User::role(RoleEnum::Estudiante->value)
            ->with('enrollments.course')
            ->orderBy('name')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'course' => $student->enrollments->first()?->course?->name ?? 'Sin Asignar',
                    'level' => $student->enrollments->first()?->course?->level ?? '',
                ];
            });

        return Inertia::render('Academic/Parents/Create', [
            'students' => $students,
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
            'children_ids' => 'nullable|array',
            'children_ids.*' => 'exists:users,id',
        ]);

        $team = Team::where('slug', $current_team)->firstOrFail();

        DB::transaction(function () use ($validated, $team) {
            $parent = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'current_team_id' => $team->id,
            ]);

            $parent->assignRole(RoleEnum::Padre->value);
            $team->members()->attach($parent->id, ['role' => 'member']);

            if (! empty($validated['children_ids'])) {
                $parent->children()->sync($validated['children_ids']);
            }
        });

        return redirect()->route('parents.index', ['current_team' => $current_team])
            ->with('status', 'Representante registrado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $current_team, User $parent)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $parent->load('children');

        $students = User::role(RoleEnum::Estudiante->value)
            ->with('enrollments.course')
            ->orderBy('name')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'course' => $student->enrollments->first()?->course?->name ?? 'Sin Asignar',
                    'level' => $student->enrollments->first()?->course?->level ?? '',
                ];
            });

        return Inertia::render('Academic/Parents/Edit', [
            'parent' => $parent,
            'students' => $students,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, User $parent)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$parent->id,
            'password' => 'nullable|string|min:8|confirmed',
            'children_ids' => 'nullable|array',
            'children_ids.*' => 'exists:users,id',
        ]);

        DB::transaction(function () use ($validated, $parent) {
            $parent->name = $validated['name'];
            $parent->email = $validated['email'];

            if (! empty($validated['password'])) {
                $parent->password = Hash::make($validated['password']);
            }

            $parent->save();

            if (isset($validated['children_ids'])) {
                $parent->children()->sync($validated['children_ids']);
            } else {
                $parent->children()->sync([]);
            }
        });

        return redirect()->route('parents.index', ['current_team' => $current_team])
            ->with('status', 'Información del representante actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $current_team, User $parent)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $parent->delete();

        return redirect()->route('parents.index', ['current_team' => $current_team])
            ->with('status', 'Representante eliminado exitosamente.');
    }
}

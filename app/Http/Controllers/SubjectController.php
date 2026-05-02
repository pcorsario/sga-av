<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Exports\SubjectsExport;
use App\Exports\SubjectsTemplateExport;
use App\Imports\SubjectsImport;
use App\Models\Subject;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, string $current_team)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $search = $request->input('search');

        $subjects = Subject::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Academic/Subjects/Index', [
            'subjects' => $subjects,
            'filters' => $request->only(['search']),
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

        return Inertia::render('Academic/Subjects/Create');
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
            'name' => 'required|string|max:255|unique:subjects,name',
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index', ['current_team' => $current_team])
            ->with('status', 'Materia creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $current_team, Subject $subject)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        return Inertia::render('Academic/Subjects/Edit', [
            'subject' => $subject,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $current_team, Subject $subject)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,'.$subject->id,
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index', ['current_team' => $current_team])
            ->with('status', 'Materia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $current_team, Subject $subject)
    {
        if (! $request->user()->hasRole(RoleEnum::Autoridad->value)) {
            abort(403, 'No autorizado.');
        }

        // Verificar si la materia está siendo usada
        if ($subject->courseSubjects()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar la materia porque está asignada a uno o más cursos.']);
        }

        $subject->delete();

        return redirect()->route('subjects.index', ['current_team' => $current_team])
            ->with('status', 'Materia eliminada exitosamente.');
    }

    /**
     * Export template.
     */
    public function exportTemplate()
    {
        return Excel::download(new SubjectsTemplateExport, 'plantilla_materias.xlsx');
    }

    /**
     * Export current subjects.
     */
    public function exportExcel()
    {
        return Excel::download(new SubjectsExport, 'listado_materias.xlsx');
    }

    /**
     * Import from Excel.
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
            Excel::import(new SubjectsImport, $request->file('file'));

            return redirect()->route('subjects.index', ['current_team' => $current_team])
                ->with('status', 'Materias importadas exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Error al importar archivo: '.$e->getMessage()]);
        }
    }
}

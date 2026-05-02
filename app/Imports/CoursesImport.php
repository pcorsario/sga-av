<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\User;
use App\Models\Subject;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoursesImport implements OnEachRow, WithHeadingRow, WithValidation
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();
        $tutorId = null;
        
        // Buscar el tutor por cédula si está presente en el Excel
        if (!empty($data['cedula_del_tutor'])) {
            $tutor = User::where('cedula', $data['cedula_del_tutor'])->first();
            $tutorId = $tutor?->id;
        }

        // Crear o actualizar el curso
        $course = Course::updateOrCreate(
            ['name' => $data['nombre_del_curso']],
            [
                'level' => $data['nivel_de_educacion'],
                'tutor_id' => $tutorId,
            ]
        );

        // Manejar la carga masiva de materias si la columna existe
        if (!empty($data['materias'])) {
            $subjectNames = array_map('trim', explode(',', $data['materias']));
            $subjectIds = [];

            foreach ($subjectNames as $name) {
                // Buscar materia por nombre (insensible a mayúsculas/minúsculas)
                $subject = Subject::where('name', 'like', $name)->first();
                
                if ($subject) {
                    $subjectIds[] = $subject->id;
                }
            }

            if (!empty($subjectIds)) {
                // Sincronizar materias (esto reemplaza las actuales)
                // Usamos sync para que sea una "carga" limpia de la malla
                $course->subjects()->sync($subjectIds);
            }
        }
    }

    public function rules(): array
    {
        return [
            'nombre_del_curso' => 'required|string|max:255',
            'nivel_de_educacion' => 'required|string|in:Inicial 1,Inicial 2,Preparatoria,Elemental,Basica Media,Basica Superior,Bachillerato',
            'cedula_del_tutor' => 'nullable|exists:users,cedula',
            'materias' => 'nullable|string',
        ];
    }
}

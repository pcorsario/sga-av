<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoursesImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @return Model|null
     */
    public function model(array $row)
    {
        $tutorId = null;
        
        // Buscar el tutor por cédula si está presente en el Excel
        if (!empty($row['cedula_del_tutor'])) {
            $tutor = User::where('cedula', $row['cedula_del_tutor'])->first();
            $tutorId = $tutor?->id;
        }

        return new Course([
            'name' => $row['nombre_del_curso'],
            'level' => $row['nivel_de_educacion'],
            'tutor_id' => $tutorId,
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre_del_curso' => 'required|string|max:255',
            'nivel_de_educacion' => 'required|string|in:Inicial 1,Inicial 2,Preparatoria,Elemental,Basica Media,Basica Superior,Bachillerato',
            'cedula_del_tutor' => 'nullable|exists:users,cedula',
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\Course;
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
        return new Course([
            'name' => $row['nombre_del_curso'],
            'level' => $row['nivel_de_educacion'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre_del_curso' => 'required|string|max:255',
            'nivel_de_educacion' => 'required|string|in:Básica Elemental,Básica Media,Básica Superior,Bachillerato',
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubjectsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Subject([
            'name' => trim($row['nombre_de_la_materia']),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre_de_la_materia' => 'required|string|max:255|unique:subjects,name',
        ];
    }
}

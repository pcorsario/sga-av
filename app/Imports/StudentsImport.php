<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Team;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function __construct(private string $currentTeamSlug)
    {
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            $team = Team::where('slug', $this->currentTeamSlug)->firstOrFail();
            
            // Búsqueda robusta del curso
            $inputCourse = trim($row['nombre_del_curso']);
            
            // Intentar coincidencia exacta primero
            $course = Course::where('name', $inputCourse)->first();

            // Si no hay coincidencia exacta, intentar extraer el nombre si viene con nivel (ej: "2do Electronica (Bachillerato)")
            if (!$course && preg_match('/^(.*)\s*\((.*)\)$/', $inputCourse, $matches)) {
                $nameOnly = trim($matches[1]);
                $levelOnly = trim($matches[2]);
                $course = Course::where('name', $nameOnly)->where('level', $levelOnly)->first();
            }

            // Si aún no hay curso, lanzamos un error descriptivo
            if (!$course) {
                $available = Course::pluck('name')->unique()->take(5)->implode(', ');
                throw new \Exception(
                    "Error en fila con '{$row['nombres_y_apellidos']}': El curso '{$inputCourse}' no existe. " .
                    "Asegúrese de escribir el nombre exacto como aparece en el sistema (ej: {$available})."
                );
            }

            // 1. Crear el usuario (Identidad)
            $user = User::create([
                'name'     => trim($row['nombres_y_apellidos']),
                'email'    => trim($row['correo_estudiantil']),
                'password' => Hash::make($row['contrasena'] ?? 'estudiante123'),
                'current_team_id' => $team->id,
            ]);

            // 2. Asignar Rol de Estudiante (Visibilidad en Directorio)
            $user->assignRole(RoleEnum::Estudiante->value);

            // 3. Vincular al Equipo (Contexto Institucional)
            $team->members()->attach($user->id, ['role' => 'member']);

            // 4. Generar Matrícula (Relación Académica)
            Enrollment::create([
                'student_id' => $user->id,
                'course_id'  => $course->id,
            ]);

            return $user;
        });
    }

    public function rules(): array
    {
        return [
            'nombres_y_apellidos' => 'required|string|max:255',
            'correo_estudiantil'  => 'required|email|unique:users,email',
            'nombre_del_curso'    => 'required|string', // Quitamos exists para manejar el error nosotros con más detalle
            'contrasena'          => 'required|min:8',
        ];
    }
}

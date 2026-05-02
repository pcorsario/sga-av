<?php

namespace App\Imports;

use App\Enums\RoleEnum;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeachersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function __construct(private string $currentTeamSlug) {}

    /**
     * @return Model|null
     */
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            $team = Team::where('slug', $this->currentTeamSlug)->firstOrFail();

            // 1. Crear el usuario (Identidad)
            $user = User::create([
                'name' => trim($row['nombres_y_apellidos']),
                'email' => trim($row['correo_institucional']),
                'cedula' => str_pad((string) trim($row['cedula']), 10, '0', STR_PAD_LEFT),
                'password' => Hash::make($row['contrasena'] ?? Str::random(12)),
                'current_team_id' => $team->id,
            ]);

            // 2. Asignar Rol de Profesor
            $user->assignRole(RoleEnum::Profesor->value);

            // 3. Vincular al Equipo Institucional (Jetstream)
            if (! $team->members()->where('user_id', $user->id)->exists()) {
                $team->members()->attach($user->id, ['role' => 'member']);
            }

            return $user;
        });
    }

    public function prepareForValidation($data, $index)
    {
        if (isset($data['cedula'])) {
            $data['cedula'] = str_pad((string) trim($data['cedula']), 10, '0', STR_PAD_LEFT);
        }

        return $data;
    }

    public function rules(): array
    {
        return [
            'nombres_y_apellidos' => 'required|string|max:255',
            'correo_institucional' => 'required|email|unique:users,email',
            'cedula' => 'required|string|size:10|unique:users,cedula',
            'contrasena' => 'nullable|min:8',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'nombres_y_apellidos' => 'Nombres y Apellidos',
            'correo_institucional' => 'Correo Institucional',
            'cedula' => 'Cédula',
            'contrasena' => 'Contraseña',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'cedula.required' => 'La cédula es obligatoria. (Asegúrese de usar la nueva plantilla de Excel que incluye la columna Cédula).',
            'cedula.size' => 'La cédula debe tener exactamente 10 dígitos.',
            'cedula.unique' => 'Esta cédula ya está registrada en el sistema.',
            'correo_institucional.unique' => 'Este correo ya está registrado.',
        ];
    }
}

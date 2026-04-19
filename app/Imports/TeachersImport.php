<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Team;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeachersImport implements ToModel, WithHeadingRow, WithValidation
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
            
            // 1. Crear el usuario (Identidad)
            $user = User::create([
                'name'     => trim($row['nombres_y_apellidos']),
                'email'    => trim($row['correo_institucional']),
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

    public function rules(): array
    {
        return [
            'nombres_y_apellidos' => 'required|string|max:255',
            'correo_institucional' => 'required|email|unique:users,email',
            'contrasena'          => 'nullable|min:8',
        ];
    }
}

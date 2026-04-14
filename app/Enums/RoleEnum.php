<?php

namespace App\Enums;

enum RoleEnum: string
{
    case Autoridad = 'autoridad';
    case Profesor = 'profesor';
    case Padre = 'padre';
    case Estudiante = 'estudiante';

    public function label(): string
    {
        return match($this) {
            self::Autoridad => 'Autoridad',
            self::Profesor => 'Profesor',
            self::Padre => 'Padre / Representante',
            self::Estudiante => 'Estudiante',
        };
    }
}

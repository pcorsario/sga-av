<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsumoName extends Model
{
    protected $fillable = [
        'course_subject_id',
        'trimester',
        'ind_1', 'ind_2', 'ind_3', 'ind_4', 'ind_5', 'ind_6',
        'grp_1', 'grp_2', 'grp_3', 'grp_4', 'grp_5', 'grp_6',
        'ref_1', 'ref_2',
        'proj',
        'eval',
    ];

    public function courseSubject(): BelongsTo
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public static function defaults(): array
    {
        return [
            'ind_1' => 'Insumo 1',
            'ind_2' => 'Insumo 2',
            'ind_3' => 'Insumo 3',
            'ind_4' => 'Insumo 4',
            'ind_5' => 'Insumo 5',
            'ind_6' => 'Insumo 6',
            'grp_1' => 'Grupo 1',
            'grp_2' => 'Grupo 2',
            'grp_3' => 'Grupo 3',
            'grp_4' => 'Grupo 4',
            'grp_5' => 'Grupo 5',
            'grp_6' => 'Grupo 6',
            'ref_1' => 'Refuerzo 1',
            'ref_2' => 'Refuerzo 2',
            'proj' => 'Proyecto',
            'eval' => 'Evaluación',
        ];
    }

    public static function diagnosticDefaults(): array
    {
        return [
            'ind_1' => 'Diagnóstico 1',
            'ind_2' => 'Diagnóstico 2',
            'ind_3' => 'Diagnóstico 3',
            'ind_4' => 'Diagnóstico 4',
            'ind_5' => 'Diagnóstico 5',
            'ind_6' => 'Diagnóstico 6',
            'grp_1' => 'Grupo 1',
            'grp_2' => 'Grupo 2',
            'grp_3' => 'Grupo 3',
            'grp_4' => 'Grupo 4',
            'grp_5' => 'Grupo 5',
            'grp_6' => 'Grupo 6',
            'ref_1' => 'Refuerzo 1',
            'ref_2' => 'Refuerzo 2',
            'proj' => 'Proyecto',
            'eval' => 'Evaluación',
        ];
    }
}

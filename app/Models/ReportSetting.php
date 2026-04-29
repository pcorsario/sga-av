<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
    protected $fillable = [
        'course_subject_id',
        'trimestre',
        'destrezas_planificadas',
        'destrezas_logradas',
        'factores',
        'causas',
        'medidas',
        'recomendaciones',
    ];

    protected $casts = [
        'destrezas_planificadas' => 'integer',
        'destrezas_logradas' => 'integer',
        'factores' => 'array',
        'causas' => 'array',
        'medidas' => 'array',
        'recomendaciones' => 'array',
    ];

    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class);
    }
}

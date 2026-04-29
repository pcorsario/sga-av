<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseBoardSetting extends Model
{
    protected $fillable = [
        'course_id',
        'trimestre',
        'nee_students',
        'dece_options',
        'behavior_options',
        'resolution_options',
    ];

    protected $casts = [
        'dece_options' => 'array',
        'behavior_options' => 'array',
        'resolution_options' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

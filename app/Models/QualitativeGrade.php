<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualitativeGrade extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'evaluation_item_id',
        'q1_grade',
        'q2_grade',
        'q3_grade',
        'diagnostic_grade',
        'q1_observation',
        'q2_observation',
        'q3_observation',
        'diagnostic_observation',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function evaluationItem()
    {
        return $this->belongsTo(EvaluationItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectedEvaluationItem extends Model
{
    protected $fillable = [
        'course_subject_id',
        'evaluation_item_id',
        'quarter',
    ];

    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public function evaluationItem()
    {
        return $this->belongsTo(EvaluationItem::class);
    }
}

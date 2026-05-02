<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationItem extends Model
{
    protected $fillable = ['domain_id', 'description', 'type'];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function qualitativeGrades()
    {
        return $this->hasMany(QualitativeGrade::class);
    }
}

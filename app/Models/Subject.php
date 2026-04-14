<?php

namespace App\Models;

use Database\Factories\SubjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /** @use HasFactory<SubjectFactory> */
    protected $fillable = ['name'];

    public function courseSubjects()
    {
        return $this->hasMany(CourseSubject::class);
    }
}

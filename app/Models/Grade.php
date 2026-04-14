<?php

namespace App\Models;

use Database\Factories\GradeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /** @use HasFactory<GradeFactory> */
    protected $fillable = ['course_subject_id', 'student_id', 't1', 't2', 't3', 'observations'];

    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}

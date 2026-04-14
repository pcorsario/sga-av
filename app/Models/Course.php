<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    protected $fillable = ['name', 'level'];

    public function courseSubjects()
    {
        return $this->hasMany(CourseSubject::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'course_subjects');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}

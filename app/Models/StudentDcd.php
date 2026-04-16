<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDcd extends Model
{
    protected $table = 'student_dcds';

    protected $fillable = ['course_subject_id', 'student_id', 'selections'];

    protected $casts = [
        'selections' => 'array',
    ];

    public function courseSubject(): BelongsTo
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getSelectedCountAttribute(): int
    {
        return collect($this->selections)->filter()->count();
    }

    public function getPercentageAttribute(): float
    {
        $selected = $this->selected_count;
        if ($selected === 0) {
            return 0;
        }

        return $selected / 10;
    }

    public function getStatusAttribute(): string
    {
        $percentage = $this->percentage;
        if ($percentage === 0) {
            return '';
        }
        if ($percentage > 0.69) {
            return 'LOGRADO';
        }
        if ($percentage >= 0.39) {
            return 'EN PROCESO';
        }

        return 'INICIADO';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DCD extends Model
{
    protected $table = 'dcds';

    protected $fillable = ['course_subject_id', 'name', 'number'];

    public function courseSubject(): BelongsTo
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public static function defaultNames(): array
    {
        $names = [];
        for ($i = 1; $i <= 10; $i++) {
            $names[$i] = "DCD {$i}";
        }

        return $names;
    }
}

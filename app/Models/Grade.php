<?php

namespace App\Models;

use Database\Factories\GradeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /** @use HasFactory<GradeFactory> */
    protected $fillable = [
        'course_subject_id',
        'student_id',
        'observations',
        't1_ind_1', 't1_ind_2', 't1_ind_3', 't1_ind_4', 't1_ind_5', 't1_ind_6',
        't1_grp_1', 't1_grp_2', 't1_grp_3', 't1_grp_4', 't1_grp_5', 't1_grp_6',
        't1_ref_1', 't1_ref_2',
        't1_proj', 't1_eval',
        't2_ind_1', 't2_ind_2', 't2_ind_3', 't2_ind_4', 't2_ind_5', 't2_ind_6',
        't2_grp_1', 't2_grp_2', 't2_grp_3', 't2_grp_4', 't2_grp_5', 't2_grp_6',
        't2_ref_1', 't2_ref_2',
        't2_proj', 't2_eval',
        't3_ind_1', 't3_ind_2', 't3_ind_3', 't3_ind_4', 't3_ind_5', 't3_ind_6',
        't3_grp_1', 't3_grp_2', 't3_grp_3', 't3_grp_4', 't3_grp_5', 't3_grp_6',
        't3_ref_1', 't3_ref_2',
        't3_proj', 't3_eval',
    ];

    public function courseSubject()
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public static function insumosStructure(): array
    {
        return [
            'ind' => range(1, 6),
            'grp' => range(1, 6),
            'ref' => range(1, 2),
            'proj' => [1],
            'eval' => [1],
        ];
    }
}

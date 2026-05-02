<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportOption extends Model
{
    protected $fillable = [
        'type',
        'category',
        'description',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];
}

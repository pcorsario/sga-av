<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['name', 'level'];

    public function evaluationItems()
    {
        return $this->hasMany(EvaluationItem::class);
    }
}

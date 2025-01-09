<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $casts = [
        'date'      => 'datetime',
        'due_date'  => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

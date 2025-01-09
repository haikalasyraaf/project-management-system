<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function projectCost()
    {
        return $this->expenses()->where('review_status', 1)->sum('amount');
    }
}

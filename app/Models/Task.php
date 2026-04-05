<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Task extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];
    protected $appends = ['is_overdue'];

    public function getIsOverdueAttribute()
    {
        if (!$this->due_date || $this->status === 'done') {
            return false;
        }
        return $this->due_date->isPast();
    }
}




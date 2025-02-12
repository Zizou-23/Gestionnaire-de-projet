<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'status', 'created_by'];

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}

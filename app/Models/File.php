<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'file_path', 'uploaded_by'];

    public function task() {
        return $this->belongsTo(Task::class);
    }
    public function uploadedBy()
{
    return $this->belongsTo(User::class, 'uploaded_by');
}

}


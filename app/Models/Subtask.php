<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
    protected $table = "subtasks";
    protected $fillable = [
        "todo_id",
        "name",
        "is_done",
    ];
    protected $casts = [
        'is_done' => 'boolean',
    ];

    public function todo() {
        return $this->belongsTo(Todo::class);
    }
}

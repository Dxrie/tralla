<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $table = "subtasks";
    protected $fillable = [
        "todo_id",
        "name",
        "is_done",
    ];

    public function todo() {
        return $this->belongsTo(Todo::class);
    }
}

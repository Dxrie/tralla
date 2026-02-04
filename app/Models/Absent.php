<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'detail',
        'status',
    ];

    protected $hidden = [
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

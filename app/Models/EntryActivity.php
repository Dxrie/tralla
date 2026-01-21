<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntryActivity extends Model
{
    protected $fillable = [
        'user_id',
        'image_path',
        'status',
        'detail',
    ];
}

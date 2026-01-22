<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'nama_barang',
        'divisi',
        'foto_barang',
    ];
}

<?php

namespace App\Models;

use App\Models\PeminjamanItem;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = [
        'nama_barang',
        'divisi',
        'foto_barang',
    ];

    public function items()
    {
        return $this->hasMany(PeminjamanItem::class);
    }
}

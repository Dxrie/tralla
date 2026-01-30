<?php

namespace App\Models;

use App\Models\Borrow;
use Illuminate\Database\Eloquent\Model;

class PeminjamanItem extends Model
{
    public function peminjaman()
    {
        return $this->belongsTo(Borrow::class);
    }

}

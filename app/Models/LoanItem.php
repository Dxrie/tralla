<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'loan_id',
        'nama_barang',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}

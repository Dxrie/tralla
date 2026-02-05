<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_peminjam',
        'keterangan',
        'tanggal_pinjam',
        'divisi',
    ];

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class, 'loan_id');
    }
}

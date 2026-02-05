<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'division_id',
    ];

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class, 'loan_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}

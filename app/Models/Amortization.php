<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amortization extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'payment',
        'interest_paid',
        'interest_amount',
        'principal',
        'balance',
    ];
}

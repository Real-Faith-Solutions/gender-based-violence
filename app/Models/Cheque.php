<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    use HasFactory;
    protected $fillable = [
    'document_no',
    'borrower',
    'agent',
    'loan_worth',
    'loan_interest',
    'receivable',
    'total_deduction',
    'bank',
    'cheque_no',
    'cheque_amount',
    ];
}

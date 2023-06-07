<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_no',
        'borrower',
        'amount',
        'total_balance',
        'outstanding_balance',
        'receivable',
        'total_payment',
        'short_over',
        'payment_start_date',
        'maturity_date',
        'payment_type',
        'penalty',
        'penalty_balance',
        'contact_numbers',
        'agent',
        'interest_rate',
        'loan_description',
        'loan_status',
        'payment_date',
    ];
}

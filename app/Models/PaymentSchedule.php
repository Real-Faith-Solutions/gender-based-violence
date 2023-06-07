<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'due_date',
        'day_of_week',
        'cheque_details',
        'due_amount',
    ];
}

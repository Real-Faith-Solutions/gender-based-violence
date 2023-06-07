<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrower extends Model
{
    use HasFactory;
    protected $fillable = [
    'last_name',
    'first_name',
    'middle_name',
    'tin_id',
    'natureofbusiness',
    'house_no_street_subdivision',
    'barangay',
    'municipality',
    'province',
    'years_operating',
    'branch',
    'agent',
    'credit_limit',
    ];
}

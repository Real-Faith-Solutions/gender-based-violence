<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'case_no',
        'name',
        'date_updated',
        'created_by',
        'submitted_by',
        'remarks',
        ];
}

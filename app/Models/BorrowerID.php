<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class borrowerId extends Model
{
    use HasFactory;
    protected $fillable = [
    'id_type',
    'id_no',
    'remarks',
    ];
}

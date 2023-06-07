<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForbesTop extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'year',
        'rank',
        'recipient',
        'country',
        'career',
        'tied',
        'title'
    ];
}

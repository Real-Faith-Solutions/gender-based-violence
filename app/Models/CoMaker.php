<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoMaker extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'contact_numbers',
        'id_no',
        ];
}

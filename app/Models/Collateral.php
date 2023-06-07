<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collateral extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_brand_vehicle',
        'chassis_no',
        'engine_no',
        'plate_no',
        'cr_no',
        'or_no',
    ];
}

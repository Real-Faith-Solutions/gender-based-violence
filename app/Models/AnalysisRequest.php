<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'acount_name',
        'unit_no_floor_bldg_name',
        'street_name_or_subdivision',
        'barangay_name',
        'municipality_or_city',
        'zip_code',
        'province',
        'contact_person',
        'phone',
        'mobile',
        'email',
        'collected_by',
        'date_collected',
        'time_collected',
        'last_microbial_testing',
        'last_change_of_filter',
        'last_change_of_uv',
        'collection_point',
        'address_of_collection_point',
        'uv_light',
        'chlorinator',
        'faucet_condition_after_disinfection',
        'source_of_water_sample',
        'water_purpose',
        'test_request',
        'customer_representative_name',
    ];
}

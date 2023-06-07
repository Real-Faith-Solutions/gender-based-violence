<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_name',
        'business_tin',
        'name_of_owner',
        'type_of_ownership',
        'name_of_authorized_person',
        'unit_no_floor_bldg_name',
        'street_name_or_subdivision',
        'barangay_name',
        'municipality_or_city',
        'zip_code',
        'province',
        'phone',
        'mobile',
        'email',
        'preferred_model_of_contract',
        'fsr_assigned',
        'market_segment',
        'no_of_microbiology_samples',
        'sample_collection_frequency_micro',
        'no_of_physico_chemical_samples',
        'sample_collection_frequency_pchem',
        'assigned_week',
    ];
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnalysisRequest;

class AnalysisRequestController extends Controller
{
    public function addNewAnalysisRequest(Request $request){
        AnalysisRequest::create([
            'acount_name' => $request->acount_name,
            'unit_no_floor_bldg_name' => $request->unit_no_floor_bldg_name,
            'street_name_or_subdivision' => $request->street_name_or_subdivision,
            'barangay_name' => $request->barangay_name,
            'municipality_or_city' => $request->municipality_or_city,
            'zip_code' => $request->zip_code,
            'province' => $request->province,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'collected_by' => $request->collected_by,
            'date_collected' => $request->date_collected,
            'time_collected' => $request->time_collected,
            'last_microbial_testing' => $request->last_microbial_testing,
            'last_change_of_filter' => $request->last_change_of_filter,
            'last_change_of_uv' => $request->last_change_of_uv,
            'collection_point' => $request->collection_point,
            'address_of_collection_point' => $request->address_of_collection_point,
            'uv_light' => $request->uv_light,
            'chlorinator' => $request->chlorinator,
            'faucet_condition_after_disinfection' => $request->faucet_condition_after_disinfection,
            'source_of_water_sample' => $request->source_of_water_sample,
            'water_purpose' => $request->water_purpose,
            'test_request' => $request->test_request,
            'customer_representative_name' => $request->customer_representative_name,
        ]);

        return "Success!";
}

    public function getAnalysisRequests(Request $request){
    $analysisrequest = AnalysisRequest::all();

    return $analysisrequest;
}

    public function getAnalysisRequestsPage(Request $request){
    $analysisrequest = AnalysisRequest::all();

    return $analysisrequest;

}

}
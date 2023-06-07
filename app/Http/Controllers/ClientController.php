<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function addNewClient(Request $request){
        Client::create([
            'account_name' => $request->account_name,
            'business_tin' => $request->business_tin,
            'name_of_owner' => $request->name_of_owner,
            'type_of_ownership' => $request->type_of_ownership,
            'name_of_authorized_person' => $request->name_of_authorized_person,
            'unit_no_floor_bldg_name' => $request->unit_no_floor_bldg_name,
            'street_name_or_subdivision' => $request->street_name_or_subdivision,
            'barangay_name' => $request->barangay_name,
            'municipality_or_city' => $request->municipality_or_city,
            'zip_code' => $request->zip_code,
            'province' => $request->province,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'preferred_model_of_contract' => $request->preferred_model_of_contract,
            'fsr_assigned' => $request->fsr_assigned,
            'market_segment' => $request->market_segment,
            'no_of_microbiology_samples' => $request->no_of_microbiology_samples,
            'sample_collection_frequency_micro' => $request->sample_collection_frequency_micro,
            'no_of_physico_chemical_samples' => $request->no_of_physico_chemical_samples,
            'sample_collection_frequency_pchem' => $request->sample_collection_frequency_pchem,
            'assigned_week' => $request->assigned_week,
        ]);

        return "Success!";
    }

    public function getClients(Request $request){
        $client = Client::all();
 
         return $client;
    }

    public function getClientPage(Request $request){
        $client = Client::all();

        return view('admin.user-management.user_client', compact('client'))->render();
    }
}

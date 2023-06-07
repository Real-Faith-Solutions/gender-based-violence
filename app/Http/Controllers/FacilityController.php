<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function addFacility(Request $request){
        Facility::create([
            'description' => $request->description,
            'purpose' => $request->purpose,
            'status' => $request->status,
        ]);

        return "Success!";
    }

    public function getFacility(Request $request){
        $facility = Facility::all();
 
         return $facility;
    }

    public function getFacilityPage(Request $request){
        $facility = Facility::all();

        return view('admin.record.facility', compact('facility'))->render();
    }
}

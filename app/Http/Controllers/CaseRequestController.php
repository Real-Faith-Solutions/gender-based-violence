<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseRequest;
use App\Models\Cases;

class CaseRequestController extends Controller
{
    public function addCaseRequest(Request $request){
        CaseRequest::create([
            'case_no' => $request->case_no,
            'name' => $request->name,
            'date_updated' => $request->date_updated,
            'created_by' => $request->created_by,
            'submitted_by' => $request->submitted_by,
            'remarks' => $request->remarks,
        ]);

        return "Success!";
    }

    public function getCaseRequest(Request $request){
        $caserequest = CaseRequest::all();

        return $caserequest;
    }

    public function getCaseRequestsPage(Request $request){
        $caserequest = CaseRequest::all();

        return view('admin.case_folder.request', compact('caserequest'))->render();
    }

    public function getFileCaseRequestsPage(){
       $caserequest = Cases::all();

       return view('admin.case_folder.request', compact('caserequest'))->render();
   }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PlaceOfIncidences;
use App\Models\UserRole;
use App\Models\MaintenanceDropDownListUsersActivityLogs;
use Illuminate\Support\Facades\Validator;

class PlaceOfIncidencesController extends Controller
{
    public function addPlaceOfIncidences(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{

            // Validate form

            $validator = Validator::make(
                array(
                    'item_name' => $request->item_name,
                ),
                array(
                    'item_name' => 'required|unique:place_of_incidences',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                PlaceOfIncidences::create([
                    'item_name' => $request->item_name,
                ]);

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Place of Incidence',
                    'subject_item_name' => $request->item_name,
                    'accountable_user_activity' => 'Create',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return "The Place of Incidence name was successfully added";
            }
        }
    }

    public function getPlaceOfIncidences(Request $request){
        $place_of_incidences = PlaceOfIncidences::all();

        return $place_of_incidences;
    }

    public function getPlaceOfIncidencesPage(Request $request){
        
        // Get Database data

        $place_of_incidences = PlaceOfIncidences::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            return view('restricted');
        }
        else{
            
        return view('admin.maintenance.place_of_incidence', compact('place_of_incidences'))->render();
        }
    }

    public function updatePlaceOfIncidences(Request $request, $id){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{

            // Validate form

            $validator = Validator::make(
                array(
                    'item_name' => $request->item_name,
                ),
                array(
                    'item_name' => 'required|unique:place_of_incidences',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                // Update Place of Incidence

                $update_place_of_incidences = PlaceOfIncidences::find($id);
                $update_place_of_incidences->item_name = $request->input('item_name');

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Place of Incidence',
                    'subject_item_name' => $request->item_name,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                $update_place_of_incidences->update();

                return "The Place of Incidence name was successfully modified";
            }
        }
    }

    public function deletePlaceOfIncidences($id){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{

            $place_of_incidences_id = PlaceOfIncidences::findOrFail($id);

            MaintenanceDropDownListUsersActivityLogs::create([
                'subject_category_name' => 'Place of Incidence',
                'subject_item_name' => $place_of_incidences_id->item_name,
                'accountable_user_activity' => 'Delete',
                'accountable_user_email' => Auth::user()->email,
                'accountable_user_username' => Auth::user()->username,
                'accountable_user_last_name' => Auth::user()->user_last_name,
                'accountable_user_first_name' => Auth::user()->user_first_name,
                'accountable_user_middle_name' => Auth::user()->user_middle_name,
            ]);

            $place_of_incidences_id->delete();

            return 'The Place of Incidence name was successfully deleted';
        }
    }
}

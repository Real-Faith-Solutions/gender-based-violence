<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Religions;
use App\Models\UserRole;
use App\Models\MaintenanceDropDownListUsersActivityLogs;
use Illuminate\Support\Facades\Validator;


class ReligionsController extends Controller
{
    public function addReligions(Request $request){

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
                    'item_name' => 'required|unique:religions',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                Religions::create([
                    'item_name' => $request->item_name,
                ]);

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Religion',
                    'subject_item_name' => $request->item_name,
                    'accountable_user_activity' => 'Create',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return "The Religion name was successfully added";
            }
        }
    }

    public function getReligions(Request $request){
        $religions = Religions::all();

        return $religions;
    }

    public function getReligionsPage(Request $request){
        $religions = Religions::all();
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            return view('restricted');
        }
        else{
            
        return view('admin.maintenance.religions', compact('religions'))->render();
        }
    }

    public function updateReligions(Request $request, $id){

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
                    'item_name' => 'required|unique:religions',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                // Update Religions
                
                $update_religions = Religions::find($id);
                $update_religions->item_name = $request->input('item_name');

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Religion',
                    'subject_item_name' => $request->item_name,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                $update_religions->update();

                return "The Religion name was successfully modified";
            }
        }
    }

    public function deleteReligions($id){
        
        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{

            $religions_id = Religions::findOrFail($id);

            MaintenanceDropDownListUsersActivityLogs::create([
                'subject_category_name' => 'Religion',
                'subject_item_name' => $religions_id->item_name,
                'accountable_user_activity' => 'Delete',
                'accountable_user_email' => Auth::user()->email,
                'accountable_user_username' => Auth::user()->username,
                'accountable_user_last_name' => Auth::user()->user_last_name,
                'accountable_user_first_name' => Auth::user()->user_first_name,
                'accountable_user_middle_name' => Auth::user()->user_middle_name,
            ]);

            $religions_id->delete();

            return 'The Religion name was successfully deleted';
        }
    }
}

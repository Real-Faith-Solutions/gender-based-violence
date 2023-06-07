<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RelationshipToVictimSurvivors;
use App\Models\UserRole;
use App\Models\MaintenanceDropDownListUsersActivityLogs;
use Illuminate\Support\Facades\Validator;

class RelationshipToVictimSurvivorsController extends Controller
{
    public function addRelationshipToVictimSurvivors(Request $request){

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
                    'item_name' => 'required|unique:relationship_to_victim_survivors',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                RelationshipToVictimSurvivors::create([
                    'item_name' => $request->item_name,
                ]);

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Relationship to Victim-Survivor',
                    'subject_item_name' => $request->item_name,
                    'accountable_user_activity' => 'Create',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return "The Relationship to Victim-Survivor name was successfully added";
            }
        }
    }

    public function getRelationshipToVictimSurvivors(Request $request){
        $relationship_to_victim_survivors = RelationshipToVictimSurvivors::all();

        return $relationship_to_victim_survivors;
    }

    public function getRelationshipToVictimSurvivorsPage(Request $request){
        $relationship_to_victim_survivors = RelationshipToVictimSurvivors::all();
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            return view('restricted');
        }
        else{
            
        return view('admin.maintenance.relationship_to_victim_survivor', compact('relationship_to_victim_survivors'))->render();
        }
    }

    public function updateRelationshipToVictimSurvivors(Request $request, $id){

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
                    'item_name' => 'required|unique:relationship_to_victim_survivors',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                // Update Relationship to Victim

                $update_relationship_to_victim_survivors = RelationshipToVictimSurvivors::find($id);
                $update_relationship_to_victim_survivors->item_name = $request->input('item_name');

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Relationship to Victim-Survivor',
                    'subject_item_name' => $request->item_name,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                $update_relationship_to_victim_survivors->update();

                return "The Relationship to Victim-Survivor name was successfully modified";
            }
        }
    }

    public function deleteRelationshipToVictimSurvivors($id){
        
        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{
            
            $relationship_to_victim_survivors_id = RelationshipToVictimSurvivors::findOrFail($id);

            MaintenanceDropDownListUsersActivityLogs::create([
                'subject_category_name' => 'Relationship to Victim-Survivor',
                'subject_item_name' => $relationship_to_victim_survivors_id->item_name,
                'accountable_user_activity' => 'Delete',
                'accountable_user_email' => Auth::user()->email,
                'accountable_user_username' => Auth::user()->username,
                'accountable_user_last_name' => Auth::user()->user_last_name,
                'accountable_user_first_name' => Auth::user()->user_first_name,
                'accountable_user_middle_name' => Auth::user()->user_middle_name,
            ]);

            $relationship_to_victim_survivors_id->delete();

            return 'The Relationship to Victim-Survivor name was successfully deleted';
        }
    }
}

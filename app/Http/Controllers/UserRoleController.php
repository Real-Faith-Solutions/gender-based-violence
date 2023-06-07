<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRole;
use App\Models\UserRoleUsersActivityLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Redirect;

class UserRoleController extends Controller
{

    public function putSeparator($value){

        // Put Separator on value
        
        if(!empty($value)){
            return $value.',';
        }
        else{
            return '';
        }

    }

    public function addUserRole(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            // Validate form

            $validator = Validator::make(
                array(
                    'role_name' => $request->role_name,
                    'page_access' => $request->dashboard.$request->rights_management.$request->master_list.$request->reports.$request->maintenance,
                    'master_list' => $request->master_list,
                    'master_list_rights' => $request->master_list_rights_add.$request->master_list_rights_revise.$request->master_list_rights_delete.$request->master_list_rights_upload.$request->master_list_rights_appr_disappr,
                ),
                array(
                    'role_name' => 'required',
                    'page_access' => 'required',
                    'master_list' => 'required_with:master_list_rights',
                    'master_list_rights' => 'required_with:master_list',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                UserRole::create([
                    'role_name' => $request->role_name,
                    'page_access' => UserRoleController::putSeparator($request->dashboard).UserRoleController::putSeparator($request->rights_management).UserRoleController::putSeparator($request->master_list).UserRoleController::putSeparator($request->reports).UserRoleController::putSeparator($request->maintenance),
                    'master_list_rights' => UserRoleController::putSeparator($request->master_list_rights_add).UserRoleController::putSeparator($request->master_list_rights_revise).UserRoleController::putSeparator($request->master_list_rights_delete).UserRoleController::putSeparator($request->master_list_rights_upload).UserRoleController::putSeparator($request->master_list_rights_appr_disappr),
                ]);

                UserRoleUsersActivityLogs::create([
                    'subject_role_name' => $request->role_name,
                    'accountable_user_activity' => 'Create',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return "Role name successfully added";
            }
        }
    }

    public function getUserRole(Request $request){

        // Get Database data

        $userrole = UserRole::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            return view('restricted');
        }
        else{

            return $userrole;
        }
    }

     public function getUserRolesPage(Request $request){

        // Get Database data

        $userrole = UserRole::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            return view('restricted');
        }
        else{

            return view('admin.rights_management.user_role', compact('userrole'))->render();
        }
    }

    public function editUserRole($id){

        // Get Database data

        $user_role_id = UserRole::find($id);

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            return view('restricted');
        }
        else{

            return view('admin.rights_management.edit_user_role', compact('user_role_id'))->render();
        }
    }

    public function updateUserRole(Request $request, $id){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            // Validate form

            $validator = Validator::make(
                array(
                    'role_name' => $request->role_name,
                    'page_access' => $request->dashboard.$request->rights_management.$request->master_list.$request->reports.$request->maintenance,
                    'master_list' => $request->master_list,
                    'master_list_rights' => $request->master_list_rights_add.$request->master_list_rights_revise.$request->master_list_rights_delete.$request->master_list_rights_upload.$request->master_list_rights_appr_disappr,
                ),
                array(
                    'role_name' => 'required',
                    'page_access' => 'required',
                    'master_list' => 'required_with:master_list_rights',
                    'master_list_rights' => 'required_with:master_list',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                $update_user_role = UserRole::find($id);
                $update_user_role->role_name = $request->input('role_name');
                $update_user_role->page_access = UserRoleController::putSeparator($request->dashboard).UserRoleController::putSeparator($request->rights_management).UserRoleController::putSeparator($request->master_list).UserRoleController::putSeparator($request->reports).UserRoleController::putSeparator($request->maintenance);
                $update_user_role->master_list_rights = UserRoleController::putSeparator($request->master_list_rights_add).UserRoleController::putSeparator($request->master_list_rights_revise).UserRoleController::putSeparator($request->master_list_rights_delete).UserRoleController::putSeparator($request->master_list_rights_upload).UserRoleController::putSeparator($request->master_list_rights_appr_disappr);

                UserRoleUsersActivityLogs::create([
                    'subject_role_name' => $request->role_name,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                $update_user_role->update();

                return "The user role name was successfully modified";
            }
        }
    }

    public function deleteUserRole($id){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            // Get Database data
            
            $user_role_id = UserRole::findOrFail($id);

            UserRoleUsersActivityLogs::create([
                'subject_role_name' => $user_role_id->role_name,
                'accountable_user_activity' => 'Delete',
                'accountable_user_email' => Auth::user()->email,
                'accountable_user_username' => Auth::user()->username,
                'accountable_user_last_name' => Auth::user()->user_last_name,
                'accountable_user_first_name' => Auth::user()->user_first_name,
                'accountable_user_middle_name' => Auth::user()->user_middle_name,
            ]);

            $user_role_id->delete();

            return 'The user role name was successfully deleted';
        }
    }
}

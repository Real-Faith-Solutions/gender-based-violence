<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserRole;
use App\Models\DirectoryType;
use App\Models\UsersAccountUsersActivityLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserWelcomeMail;


class UserController extends Controller
{

    public function addUser(Request $request){

        $first_name = $request->user_first_name;

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            $validator = Validator::make($request->all(), [
                    'user_last_name' => 'required',
                    'user_first_name' => 'required',
                    'user_middle_name' => 'required',
                    'user_contact_no' => 'required',
                    'email' => 'required|email|unique:users',
                    'user_employee_id' => 'required',
                    'username' => 'required|unique:users|alpha_num',
                    'role' => 'required',
                    'user_service_provider' => 'required_if:role,==,Service Provider',
                    'password' => 'required|confirmed|min:5',
                    'password_confirmation' => 'required|min:5',
                    'user_region' => '',
                    'user_province' => '',
                    'user_municipality' => '',
                    'user_barangay' => '',
            ]);

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                // Try and catch error on sending emails

                try{ 

                    Mail::to($request->email)->send(new NewUserWelcomeMail());
                }
                catch (\Swift_TransportException $e){
                    
                    // Report an exception via the exception handler without rendering an error page to the user
                    
                    report($e);
                }

                User::create([
                    'user_last_name' => $request->user_last_name,
                    'user_first_name' => $request->user_first_name,
                    'user_middle_name' => $request->user_middle_name,
                    'user_contact_no' => $request->user_contact_no,
                    'email' => $request->email,
                    'user_employee_id' => $request->user_employee_id,
                    'username' => $request->username,
                    'role' => $request->role,
                    'user_service_provider' => $request->user_service_provider,
                    'password' => Hash::make($request->password),
                    'is_active' => $request->is_active,
                    'user_region' => $request->user_region,
                    'user_province' => $request->user_province,
                    'user_municipality' => $request->user_municipality,
                    'user_barangay' => $request->user_barangay,
                    'email_verified_at' => $request->email_verified_at,
                ]);

                UsersAccountUsersActivityLogs::create([
                    'subject_user_account_email' => $request->email,
                    'subject_user_account_username' => $request->username,
                    'subject_user_account_last_name' => $request->user_last_name,
                    'subject_user_account_first_name' => $request->user_first_name,
                    'subject_user_account_middle_name' => $request->user_middle_name,
                    'accountable_user_activity' => 'Create',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return 'The user was successfully added';
            }
        }
    }

    public function getUser(Request $request){

        // Get Database data

        $user = User::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            return $user;
        }
    }

    public function getUserByLastName(Request $request){
        
        // Get Database data    

        $search_user_by_last_name = User::where('user_last_name','=', $request->user_last_name_search)->get();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            return $search_user_by_last_name;
        }
    }

     public function getUsersTable(Request $request){
        $user_paginator = User::paginate(25);
        $user = User::all();
        $userrole = UserRole::all();
        $service_providers = DirectoryType::all();

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            return view('restricted');
        }
        else{

            return view('admin.rights_management.user', compact('user','userrole','user_paginator','service_providers'))->render();
        }
    }

    public function getSearchUserByLastName($user_last_name_search){
        $user_paginator = User::where('user_last_name','=', $user_last_name_search)->paginate(25);
        $user = User::where('user_last_name','=', $user_last_name_search)->get();
        $userrole = UserRole::all(); 
        $service_providers = DirectoryType::all();
        $query_input = $user_last_name_search;

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            return view('restricted');
        }
        else{

            return view('admin.rights_management.search_user', compact('user','userrole','user_paginator','service_providers','query_input'))->render();
        }
    }

    public function editUser($id){
        $user_id = User::find($id);
        $userrole = UserRole::all();
        $service_providers = DirectoryType::all();

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            return view('restricted');
        }
        else{

            return view('admin.rights_management.edit_user', compact('user_id','userrole','service_providers'))->render();
        }
    }

    public function updateUser(Request $request, $id){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            $validator = Validator::make($request->all(), [
                'user_last_name' => 'required',
                'user_first_name' => 'required',
                'user_middle_name' => 'required',
                'user_contact_no' => 'required',
                'user_employee_id' => 'required',
                'role' => 'required',
                'user_service_provider' => 'required_if:role,==,Service Provider',
                'password' => 'required|confirmed|min:5',
                'password_confirmation' => 'required|min:5',
                'user_region' => '',
                'user_province' => '',
                'user_municipality' => '',
                'user_barangay' => '',
            ]);

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                $update_user = User::find($id);
                $update_user->user_last_name = $request->input('user_last_name');
                $update_user->user_first_name = $request->input('user_first_name');
                $update_user->user_middle_name = $request->input('user_middle_name');
                $update_user->user_contact_no = $request->input('user_contact_no');
                $update_user->email = $request->input('email');
                $update_user->user_employee_id = $request->input('user_employee_id');
                $update_user->username = $request->input('username');
                $update_user->role = $request->input('role');
                $update_user->user_service_provider = $request->input('user_service_provider');
                $update_user->password = Hash::make($request->input('password'));
                $update_user->is_active = $request->input('is_active');
                $update_user->user_region = $request->input('user_region');
                $update_user->user_province = $request->input('user_province');
                $update_user->user_municipality = $request->input('user_municipality');
                $update_user->user_barangay = $request->input('user_barangay');

                UsersAccountUsersActivityLogs::create([
                    'subject_user_account_email' => $request->email,
                    'subject_user_account_username' => $request->username,
                    'subject_user_account_last_name' => $request->user_last_name,
                    'subject_user_account_first_name' => $request->user_first_name,
                    'subject_user_account_middle_name' => $request->user_middle_name,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                $update_user->update();

                return 'The user account was successfully modified';
            }
        }
    }

    public function deleteUser($id){
        
        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Rights Management") == false){

            abort(401);
        }
        else{

            $user_id = User::findOrFail($id);

            UsersAccountUsersActivityLogs::create([
                'subject_user_account_email' => $user_id->email,
                'subject_user_account_username' => $user_id->username,
                'subject_user_account_last_name' => $user_id->user_last_name,
                'subject_user_account_first_name' => $user_id->user_first_name,
                'subject_user_account_middle_name' => $user_id->user_middle_name,
                'accountable_user_activity' => 'Delete',
                'accountable_user_email' => Auth::user()->email,
                'accountable_user_username' => Auth::user()->username,
                'accountable_user_last_name' => Auth::user()->user_last_name,
                'accountable_user_first_name' => Auth::user()->user_first_name,
                'accountable_user_middle_name' => Auth::user()->user_middle_name,
            ]);

            $user_id->delete();

            return 'The user account was successfully deleted';
        }
    }

    public function getUpdateCreatedUserPage($id){

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(!Auth::user()){
            return view('login');
        }else{
            abort(401);
        }
    }

    public function getDeteleCreatedUserPage($id){

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(!Auth::user()){
            return view('login');
        }else{
            abort(401);
        }
    }
}

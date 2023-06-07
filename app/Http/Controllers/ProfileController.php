<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UsersAccountUsersActivityLogs;
use App\Models\UsersProfilePhotos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public static function userScopingStatus(){

        // Get User Details Database

        $user_details = User::where('username','=',Auth::user()->username)->get();

        $region = $user_details[0]->user_region;
        $province = $user_details[0]->user_province;
        $municipality = $user_details[0]->user_municipality;
        $barangay = $user_details[0]->user_barangay;

        if(($region == null) && ($province == null) && ($municipality == null) && ($barangay == null)){
            return 'National Level';
        }
        else if(($region != null) && ($province == null) && ($municipality == null) && ($barangay == null)){
            return 'Regional Level';
        }   
        else if(($region != null) && ($province != null) && ($municipality == null) && ($barangay == null)){
            return 'Provincial Level';
        }
        else if(($region != null) && ($province != null) && ($municipality != null) && ($barangay == null)){
            return 'Municipal Level';
        }
        else if(($region != null) && ($province != null) && ($municipality != null) && ($barangay != null)){
            return 'Barangay Level';
        }

    }

    public function userChangePassword(Request $request){

        // Get User Details Database

        $user_details = User::where('username','=',Auth::user()->username)->get();

        if(!Auth::user()){

            return view('login');
        }
        else{

            $validator = Validator::make(

                array(

                    // Case Module

                    'old_password' => Hash::check($request->input_old_password, $user_details[0]->password),
                    'input_old_password' => true,
                    'new_password' => $request->new_password,
                    'new_password_confirmation' => $request->new_password_confirmation,

                ),

                array(

                    // Case Module

                    'old_password' => 'required',
                    'input_old_password' => 'same:old_password',
                    'new_password' => 'required|confirmed|min:5',
                    'new_password_confirmation' => 'required|min:5',

                )

                    
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                User::where('username','=',Auth::user()->username)->update(
    
                    array(
        
                        'password' => Hash::make($request->new_password),
                    )
                );

                $user_id = User::findOrFail($user_details[0]->id);

                UsersAccountUsersActivityLogs::create([
                    'subject_user_account_email' => $user_id->email,
                    'subject_user_account_username' => $user_id->username,
                    'subject_user_account_last_name' => $user_id->user_last_name,
                    'subject_user_account_first_name' => $user_id->user_first_name,
                    'subject_user_account_middle_name' => $user_id->user_middle_name,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return 'Password successfully updated';
            }
        }
    }

    public function getProfilePage(Request $request){

        $user_details = User::where('username','=',Auth::user()->username)->get();
        $user_role_details = UserRole::where('role_name','=',Auth::user()->role)->get();
        $user_profile_photo = UsersProfilePhotos::where('username','=',Auth::user()->username)->get();
        $service_provider_role = str_contains(Auth::user()->role, "Service Provider");
        $masterlist_page_access = str_contains($user_role_details[0]->page_access, 'Master List');
        $user_scoping = ProfileController::userScopingStatus();

        if(!Auth::user()){

            return view('login');
        }
        else{

            return view('admin.profile.profile', compact('user_details','user_role_details', 'user_profile_photo', 'service_provider_role', 'masterlist_page_access', 'user_scoping'))->render();
            
        }
    }
}

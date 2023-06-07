<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Directory;
use Illuminate\Support\Facades\Auth;
use App\Models\DirectoryType;
use App\Models\UserRole;
use App\Models\MaintenanceDirectoriesUsersActivityLogs;
use Illuminate\Support\Facades\Validator;

class DirectoryController extends Controller
{
    public function addDirectory(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{

            // Validate form

            $validator = Validator::make($request->all(), [
                'dir_first_name' => 'required',
                'dir_middle_name' => 'required',
                'dir_last_name' => 'required',
                'dir_post_desi' => 'required',
                'dir_directory_type' => 'required',
                'dir_contact_no_1' => 'required',
                'dir_email' => 'required|email',
                'dir_facebook' => 'required|url',
            ]);

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                Directory::create([
                    'dir_first_name' => $request->dir_first_name,
                    'dir_middle_name' => $request->dir_middle_name,
                    'dir_last_name' => $request->dir_last_name,
                    'dir_post_desi' => $request->dir_post_desi,
                    'dir_directory_type' => $request->dir_directory_type,
                    'dir_contact_no_1' => $request->dir_contact_no_1,
                    'dir_contact_no_2' => $request->dir_contact_no_2,
                    'dir_contact_no_3' => $request->dir_contact_no_3,
                    'dir_email' => $request->dir_email,
                    'dir_facebook' => $request->dir_facebook,            
                ]);

                MaintenanceDirectoriesUsersActivityLogs::create([
                    'subject_dir_first_name' => $request->dir_first_name,
                    'subject_dir_middle_name' => $request->dir_middle_name,
                    'subject_dir_last_name' => $request->dir_last_name,
                    'subject_dir_post_desi' => $request->dir_post_desi,
                    'subject_dir_directory_type' => $request->dir_directory_type,
                    'subject_dir_contact_no_1' => $request->dir_contact_no_1,
                    'subject_dir_contact_no_2' => $request->dir_contact_no_2,
                    'subject_dir_contact_no_3' => $request->dir_contact_no_3,
                    'subject_dir_email' => $request->dir_email,
                    'subject_dir_facebook' => $request->dir_facebook,
                    'accountable_user_activity' => 'Create',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return "The Directory details was successfully added";
            }
        }
    }

    public function getDirectory(Request $request){
        $directory = Directory::all();

        return $directory;
    }

     public function getDirectoriesPage(Request $request){
        
        // Get Database data

        $directory_paginator = Directory::paginate(25);
        $directory = Directory::all();
        $directory_type = DirectoryType::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            return view('restricted');
        }
        else{

            return view('admin.maintenance.directory', compact('directory','directory_type','directory_paginator'))->render();
        }
    }

    public function getSearchDirectoriesByLastName($directory_last_name_search){
        
        // Get Database data

        $directory_paginator = Directory::where('dir_last_name','=',$directory_last_name_search)->paginate(25);
        $directory = Directory::where('dir_last_name','=',$directory_last_name_search)->get();
        $directory_type = DirectoryType::all();
        $query_input = $directory_last_name_search;

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            return view('restricted');
        }
        else{

            return view('admin.maintenance.search_directory', compact('directory','directory_type','directory_paginator','query_input'))->render();
        }
    }

    public function editDirectoriesPage($id){

        // Get Database data
        
        $directory_id = Directory::findOrFail($id);

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            return view('restricted');
        }
        else{

            return view('admin.maintenance.edit_directory', compact('directory_id'))->render();
        }
    }

    public function updateDirectory(Request $request, $id){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{

            // Validate form

            $validator = Validator::make($request->all(), [
                'dir_first_name' => 'required',
                'dir_middle_name' => 'required',
                'dir_last_name' => 'required',
                'dir_post_desi' => 'required',
                'dir_directory_type' => 'required',
                'dir_contact_no_1' => 'required',
                'dir_email' => 'required|email',
                'dir_facebook' => 'required|url',
            ]);

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                $update_directories = Directory::find($id);
                $update_directories->dir_first_name = $request->input('dir_first_name');
                $update_directories->dir_middle_name = $request->input('dir_middle_name');
                $update_directories->dir_last_name = $request->input('dir_last_name');
                $update_directories->dir_post_desi = $request->input('dir_post_desi');
                $update_directories->dir_directory_type = $request->input('dir_directory_type');
                $update_directories->dir_contact_no_1 = $request->input('dir_contact_no_1');
                $update_directories->dir_contact_no_2 = $request->input('dir_contact_no_2');
                $update_directories->dir_contact_no_3 = $request->input('dir_contact_no_3');
                $update_directories->dir_email = $request->input('dir_email');
                $update_directories->dir_facebook = $request->input('dir_facebook');

                MaintenanceDirectoriesUsersActivityLogs::create([
                    'subject_dir_first_name' => $request->dir_first_name,
                    'subject_dir_middle_name' => $request->dir_middle_name,
                    'subject_dir_last_name' => $request->dir_last_name,
                    'subject_dir_post_desi' => $request->dir_post_desi,
                    'subject_dir_directory_type' => $request->dir_directory_type,
                    'subject_dir_contact_no_1' => $request->dir_contact_no_1,
                    'subject_dir_contact_no_2' => $request->dir_contact_no_2,
                    'subject_dir_contact_no_3' => $request->dir_contact_no_3,
                    'subject_dir_email' => $request->dir_email,
                    'subject_dir_facebook' => $request->dir_facebook,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                $update_directories->update();

                return "The Directory details was successfully modified";
            }
        }
    }

    public function deleteDirectory($id){
        
        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{
 
            $directories_id = Directory::findOrFail($id);

            MaintenanceDirectoriesUsersActivityLogs::create([
                'subject_dir_first_name' => $directories_id->dir_first_name,
                'subject_dir_middle_name' => $directories_id->dir_middle_name,
                'subject_dir_last_name' => $directories_id->dir_last_name,
                'subject_dir_post_desi' => $directories_id->dir_post_desi,
                'subject_dir_directory_type' => $directories_id->dir_directory_type,
                'subject_dir_contact_no_1' => $directories_id->dir_contact_no_1,
                'subject_dir_contact_no_2' => $directories_id->dir_contact_no_2,
                'subject_dir_contact_no_3' => $directories_id->dir_contact_no_3,
                'subject_dir_email' => $directories_id->dir_email,
                'subject_dir_facebook' => $directories_id->dir_facebook,
                'accountable_user_activity' => 'Delete',
                'accountable_user_email' => Auth::user()->email,
                'accountable_user_username' => Auth::user()->username,
                'accountable_user_last_name' => Auth::user()->user_last_name,
                'accountable_user_first_name' => Auth::user()->user_first_name,
                'accountable_user_middle_name' => Auth::user()->user_middle_name,
            ]);

            $directories_id->delete();

            return 'The Directory details was successfully deleted';
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DirectoryType;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Models\MaintenanceDropDownListUsersActivityLogs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class DirectoryTypeController extends Controller
{
    public function addDirectoryType(Request $request){

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
                    'name' => $request->name,
                ),
                array(
                    'name' => 'required|unique:directory_types',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{
            
                DirectoryType::create([
                    'name' => $request->name,
                ]);

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Service Provider',
                    'subject_item_name' => $request->name,
                    'accountable_user_activity' => 'Create',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                return "The Service Provider name was successfully added";
            }
        }
    }

    public function getDirectoryType(Request $request){
        
        $directorytype = DirectoryType::select('name')->get();

            return $directorytype;
    }

    public function getDirectoriesTypePage(Request $request){

        // Get Database data

        $directorytype = DirectoryType::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            return view('restricted');
        }
        else{
            
        return view('admin.maintenance.directory_type', compact('directorytype'))->render();
        }
    }

    public function updateDirectoryType(Request $request, $id){

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
                    'name' => $request->name,
                ),
                array(
                    'name' => 'required|unique:directory_types',
                )
            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{

                // Update Service Provider
                
                $update_service_provider = DirectoryType::find($id);
                $update_service_provider->name = $request->input('name');

                MaintenanceDropDownListUsersActivityLogs::create([
                    'subject_category_name' => 'Service Provider',
                    'subject_item_name' => $request->name,
                    'accountable_user_activity' => 'Update',
                    'accountable_user_email' => Auth::user()->email,
                    'accountable_user_username' => Auth::user()->username,
                    'accountable_user_last_name' => Auth::user()->user_last_name,
                    'accountable_user_first_name' => Auth::user()->user_first_name,
                    'accountable_user_middle_name' => Auth::user()->user_middle_name,
                ]);

                $update_service_provider->update();

                return "The Service Provider name was successfully modified";
            }
        }
    }

    public function deleteDirectoryType($id){
        
        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Maintenance") == false){

            abort(401);
        }
        else{

            $service_provider_id = DirectoryType::findOrFail($id);

            MaintenanceDropDownListUsersActivityLogs::create([
                'subject_category_name' => 'Service Provider',
                'subject_item_name' => $service_provider_id->name,
                'accountable_user_activity' => 'Delete',
                'accountable_user_email' => Auth::user()->email,
                'accountable_user_username' => Auth::user()->username,
                'accountable_user_last_name' => Auth::user()->user_last_name,
                'accountable_user_first_name' => Auth::user()->user_first_name,
                'accountable_user_middle_name' => Auth::user()->user_middle_name,
            ]);

            $service_provider_id->delete();

            return 'The Service Provider name was successfully deleted';
        }
    }
}

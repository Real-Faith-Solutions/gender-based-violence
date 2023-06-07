<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\FamilyBackgroundInfos;
use App\Models\IncidenceDetailInfos;
use App\Models\PerpetratorDetailInfos;
use App\Models\InterventionModuleInfos;
use DB;
use Illuminate\Support\Facades\Password;

class ParentPageRedirect extends Controller
{
    public function homePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/dashboard');
        }

    }

    public function adminHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/dashboard');
        }

    }

    public function rightsManagementHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/rights-management/user');
        }

    }

    public function caseFolderHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/case-folder/master-list');
        }

    }


    public function getApiAddHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            abort(401);
        }

    }

    public function loginHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/');
        }

    }

    public function registrationHomePage(){

        if(!Auth::check()){
            return view('registration');
        }else{
            return Redirect::to('/');
        }

    }

    public function maintenanceHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/maintenance/directory-type');
        }

    }

    public function editCaseformHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/case-folder/master-list');
        }

    }

    public function viewCaseformHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/case-folder/master-list');
        }

    }

    public function updateCaseformHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/case-folder/master-list');
        }

    }

    public function editUserformHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/rights-management/user');
        }

    }

    public function updateUserformHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/rights-management/user');
        }

    }

    public function editUserRoleformHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/rights-management/user-role');
        }

    }

    public function getSearchCasesHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/case-folder/master-list');
        }

    }

    public function getSearchUserByLastNameHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/rights-management/user');
        }

    }

    public function getSearchDirectoriesByLastNameHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/maintenance/directory');
        }

    }

    public function getSortListOfGBVCasesPerMonthHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/report/list-of-gbv-cases-per-month');
        }

    }

    public function getReportHomePage(){

        if(!Auth::check()){
            return view('login');
        }else{
            return Redirect::to('/admin/report/list-of-cases-per-status-report');
        }

    }
}

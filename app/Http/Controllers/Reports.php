<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Models\Cases;
use App\Models\IncidenceDetails;

class Reports extends Controller
{
    public function getReportsPage(Request $request){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            return view('admin.report.reports');
        }
    }

    public function getListOfCasesPerStatusReport(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            if(str_contains(Auth::user()->role, "Service Provider") == true){

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->paginate(40);
                }

            }
            else{

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $cases = Cases::get();
                    $cases_paginator = Cases::paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->paginate(40);
                }

            }

            return view('admin.report.list-of-cases-per-status-report', compact('cases_paginator', 'cases'))->render();
        }
        
    }

    public function getListOfPerpetratorRelationshipToVictim(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            if(str_contains(Auth::user()->role, "Service Provider") == true){

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $perpetrator_relationship_to_victim = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $perpetrator_relationship_to_victim = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $perpetrator_relationship_to_victim = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $perpetrator_relationship_to_victim = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $perpetrator_relationship_to_victim = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }

            }
            else{

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $perpetrator_relationship_to_victim = Cases::select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $perpetrator_relationship_to_victim = Cases::where('region','=',Auth::user()->user_region)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $perpetrator_relationship_to_victim = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $perpetrator_relationship_to_victim = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $perpetrator_relationship_to_victim = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('perp_d_rel_victim')->groupBy('perp_d_rel_victim')->get();
                }

            }

            return view('admin.report.list-of-perpetrator-relationship-to-victim', compact('perpetrator_relationship_to_victim'))->render();
        }
        
    }

    public function getListOfGBVCasesPerMonth(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            if(str_contains(Auth::user()->role, "Service Provider") == true){

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->paginate(40);
                }

            }
            else{

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $cases = Cases::get();
                    $cases_paginator = Cases::paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->paginate(40);
                }

            }

            return view('admin.report.list-of-gbv-cases-per-month', compact('cases_paginator', 'cases'))->render();
        }
        
    }

    public function getSortListOfGBVCasesPerMonth(Request $request, $date_from, $date_to){

        // Get the value Date from and to

        $date_from_sort_gbv_cases_per_month = $date_from;
        $date_to_sort_gbv_cases_per_month = $date_to;

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            if(str_contains(Auth::user()->role, "Service Provider") == true){

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }

            }
            else{

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $cases = Cases::whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->get();
                    $cases_paginator = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from), date($date_to)])->paginate(40);
                }

            }

            return view('admin.report.list-of-gbv-cases-per-month', compact('cases_paginator', 'cases', 'date_from_sort_gbv_cases_per_month', 'date_to_sort_gbv_cases_per_month'))->render();
        }
        
    }

    public function getListOfGBVCasesPerMunicipality(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            if(str_contains(Auth::user()->role, "Service Provider") == true){

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $extracted_municipality_per_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $extracted_municipality_per_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $extracted_municipality_per_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $extracted_municipality_per_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $extracted_municipality_per_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('province','city')->distinct()->get();
                }

            }
            else{

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $extracted_municipality_per_province = Cases::select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $extracted_municipality_per_province = Cases::where('region','=',Auth::user()->user_region)->select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $extracted_municipality_per_province = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $extracted_municipality_per_province = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('province','city')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $extracted_municipality_per_province = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('province','city')->distinct()->get();
                }

            }

            return view('admin.report.list-of-gbv-cases-per-municipality', compact('extracted_municipality_per_province'))->render();
        }
        
    }

    public function getListOfGBVCasesPerProvince(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            if(str_contains(Auth::user()->role, "Service Provider") == true){

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $extracted_province_per_region = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $extracted_province_per_region = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $extracted_province_per_region = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $extracted_province_per_region = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $extracted_province_per_region = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('region','province')->distinct()->get();
                }

            }
            else{

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $extracted_province_per_region = Cases::select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $extracted_province_per_region = Cases::where('region','=',Auth::user()->user_region)->select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $extracted_province_per_region = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $extracted_province_per_region = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('region','province')->distinct()->get();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $extracted_province_per_region = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('region','province')->distinct()->get();
                }

            }

            return view('admin.report.list-of-gbv-cases-per-province', compact('extracted_province_per_region'))->render();
        }
        
    }

    public function getListOfGBVCasesPerFormOfViolence(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Reports") == false){

            return view('restricted');
        }
        else{

            if(str_contains(Auth::user()->role, "Service Provider") == true){

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }

            }
            else{

                if(ProfileController::userScopingStatus() === 'National Level'){

                    $intimate_partner_violence = Cases::where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                    $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                    $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                    $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }
                elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                    $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                    $rape = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                    $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                    $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                    $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();
                }

            }

            return view('admin.report.list-of-gbv-cases-per-form-of-violence', compact('intimate_partner_violence', 'rape', 'trafficking_in_person', 'sexual_harassment', 'child_abuse_exploitation_and_discrimination'))->render();
        }
        
    }

}

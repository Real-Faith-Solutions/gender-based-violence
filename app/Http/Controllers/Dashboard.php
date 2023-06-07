<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cases;
use App\Models\PersonalDetails;
use App\Models\FamilyBackgrounds;
use App\Models\IncidenceDetails;
use App\Models\PerpetratorDetails;
use App\Models\InterventionModules;
use App\Models\ReferralModules;
use App\Models\CaseModules;
use App\Models\FamilyBackgroundInfos;
use App\Models\IncidenceDetailInfos;
use App\Models\PerpetratorDetailInfos;
use App\Models\InterventionModuleInfos;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\UserRole;

class Dashboard extends Controller
{
    public function getProvince(Request $request){

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Dashboard") == false){

            return view('restricted');
        }
        else{
            $overall_province = PersonalDetails::select('province')->get();
            $provinces = PersonalDetails::select('province')->groupBy('province')->get();

            $test = compact('provinces');

            foreach($provinces as $province){
                echo $province->province.',';
            }

           
            foreach($provinces as $province){
                echo PersonalDetails::where('province','=',$province->province)->get()->count().',';
            }
            
            
            return $request->userId.$request->title.$request->completed;
        }
    }

    public function getDashboardPage(Request $request){

        // For GBV Cases Reporting per Month Graph
        $year = $request->year;

        // For Total GBV Cases Reporting per Province Graph
        $date_from_sort_province = $request->date_from_sort_province;
        $date_to_sort_province = $request->date_to_sort_province;
        $region_name_for_sort_province = $request->region_name_for_sort_province;

        // For Total GBV Cases Reporting per Municipality Graph
        $date_from_sort_municipality = $request->date_from_sort_municipality;
        $date_to_sort_municipality = $request->date_to_sort_municipality;
        $province_name_for_sort_municipality = $request->province_name_for_sort_municipality;

        // For Total GBV Cases Reporting per Barangay Graph
        $date_from_sort_barangay = $request->date_from_sort_barangay;
        $date_to_sort_barangay = $request->date_to_sort_barangay;
        $city_name_for_sort_barangay = $request->city_name_for_sort_barangay;

        // For Total GBV Cases Reporting per Ethnicity Graph
        $date_from_sort_ethnicity = $request->date_from_sort_ethnicity;
        $date_to_sort_ethnicity = $request->date_to_sort_ethnicity;


        if(str_contains(Auth::user()->role, "Service Provider") == true){

            // Start if User is Service Provider

            if(ProfileController::userScopingStatus() === 'National Level'){

                // Start of National Level Data

                // Get Database Data

                $count_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->get();
                $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();


                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('im_serv_prov','=',Auth::user()->user_service_provider)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of National Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                // Start of Regional Level Data

                // Get Database Data

                $count_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->get();
                $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('im_serv_prov','=',Auth::user()->user_service_provider)
                            ->where('region','=',Auth::user()->user_region)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Regional Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                // Start of Provincial Level Data

                // Get Database Data

                $count_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->get();
                $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('im_serv_prov','=',Auth::user()->user_service_provider)
                            ->where('region','=',Auth::user()->user_region)
                            ->where('province','=',Auth::user()->user_province)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Provincial Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                // Start of Municipal Level Data

                // Get Database Data

                $count_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->get();
                $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('im_serv_prov','=',Auth::user()->user_service_provider)
                            ->where('region','=',Auth::user()->user_region)
                            ->where('province','=',Auth::user()->user_province)
                            ->where('city','=',Auth::user()->user_municipality)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Municipal Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                // Start of Barangay Level Data

                // Get Database Data

                $count_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->get();
                $intimate_partner_violence = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('im_serv_prov','=',Auth::user()->user_service_provider)
                            ->where('region','=',Auth::user()->user_region)
                            ->where('province','=',Auth::user()->user_province)
                            ->where('city','=',Auth::user()->user_municipality)
                            ->where('barangay','=',Auth::user()->user_barangay)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Barangay Level Data
            }

        }
        else{

            // Start if User is not a Service Provider

            if(ProfileController::userScopingStatus() === 'National Level'){

                // Start of National Level Data

                // Get Database Data

                $count_cases = Cases::select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::get();
                $intimate_partner_violence = Cases::where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();


                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of National Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Regional Level'){

                // Start of Regional Level Data

                // Get Database Data

                $count_cases = Cases::where('region','=',Auth::user()->user_region)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('region','=',Auth::user()->user_region)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('region','=',Auth::user()->user_region)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('region','=',Auth::user()->user_region)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('region','=',Auth::user()->user_region)->get();
                $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('region','=',Auth::user()->user_region)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('region','=',Auth::user()->user_region)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('region','=',Auth::user()->user_region)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('region','=',Auth::user()->user_region)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('region','=',Auth::user()->user_region)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Regional Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Provincial Level'){

                // Start of Provincial Level Data

                // Get Database Data

                $count_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->get();
                $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('region','=',Auth::user()->user_region)
                            ->where('province','=',Auth::user()->user_province)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Provincial Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Municipal Level'){

                // Start of Municipal Level Data

                // Get Database Data

                $count_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->get();
                $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('region','=',Auth::user()->user_region)
                            ->where('province','=',Auth::user()->user_province)
                            ->where('city','=',Auth::user()->user_municipality)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Municipal Level Data
            }
            elseif(ProfileController::userScopingStatus() === 'Barangay Level'){

                // Start of Barangay Level Data

                // Get Database Data

                $count_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('case_no')->get()->count();
                $count_ongoing_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('cm_case_status','=','Ongoing')->get()->count();
                $count_completed_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('cm_case_status','=','Completed')->get()->count();
                $count_closed_cases = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('cm_case_status','=','Closed')->get()->count();
                $count_completed_and_closed_cases = ($count_completed_cases + $count_closed_cases);
                $cases_data = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->get();
                $intimate_partner_violence = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Intimate partner violence%')->get()->count();
                $rape = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Rape%')->get()->count();
                $trafficking_in_person = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Trafficking in Person%')->get()->count();
                $sexual_harassment = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Sexual Harassment%')->get()->count();
                $child_abuse_exploitation_and_discrimination = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->where('nature_of_incidence', 'like', '%Child Abuse, Exploitation and Discrimination%')->get()->count();

                
                // Data Total GBV Cases Reporting per Province Graph

                // Get Unique Region List

                $regions = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('region')->groupBy('region')->get();

                if(!empty($date_from_sort_province) && !empty($date_to_sort_province) && !empty($region_name_for_sort_province)){

                    $extracted_province_from_sorted_list_of_province = Cases::where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_province),date($date_to_sort_province)])->where('region','=',$region_name_for_sort_province)->select('province')->groupBy('province')->get();

                }else{

                    $extracted_province_from_sorted_list_of_province = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('province')->groupBy('province')->get();
                }


                // Data Total GBV Cases Reporting per Municipality Graph

                // Get Unique Province List

                $provinces = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('province')->groupBy('province')->get();

                if(!empty($date_from_sort_municipality) && !empty($date_to_sort_municipality) && !empty($province_name_for_sort_municipality)){

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_municipality),date($date_to_sort_municipality)])->where('province','=',$province_name_for_sort_municipality)->select('city')->groupBy('city')->get();

                }else{

                    $extracted_municipality_from_sorted_list_of_municipality = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('city')->groupBy('city')->get();
                }

                
                // Data Total GBV Cases Reporting per Barangay Graph

                // Get Unique Municipal List

                $cities = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('city')->groupBy('city')->get();

                if(!empty($date_from_sort_barangay) && !empty($date_to_sort_barangay) && !empty($city_name_for_sort_barangay)){

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_barangay),date($date_to_sort_barangay)])->where('city','=',$city_name_for_sort_barangay)->select('barangay')->groupBy('barangay')->get();

                }else{

                    $extracted_barangay_from_sorted_list_of_barangay = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('barangay')->groupBy('barangay')->get();
                }


                // Data for Total GBV Cases Reporting per Ethnicity Graph

                if(!empty($date_from_sort_ethnicity) && !empty($date_to_sort_ethnicity)){

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereBetween('date_of_intake', [date($date_from_sort_ethnicity),date($date_to_sort_ethnicity)])->select('ethnicity')->groupBy('ethnicity')->get();

                }else{

                    $extracted_ethnicity_from_sorted_list_of_ethnicity = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->select('ethnicity')->groupBy('ethnicity')->get();
                }
                

                // Data for GBV Cases Reporting per Month Graph

                // Extract Year from Date of Intake

                $extract_years_from_date_of_intake = DB::table('cases')
                            ->where('region','=',Auth::user()->user_region)
                            ->where('province','=',Auth::user()->user_province)
                            ->where('city','=',Auth::user()->user_municipality)
                            ->where('barangay','=',Auth::user()->user_barangay)
                            ->select([DB::raw('EXTRACT(YEAR FROM cases.date_of_intake) as year')])
                            ->groupBy('year')
                            ->pluck('year');

                if(!empty($year)){

                    $january = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date($year))->whereMonth('date_of_intake', date(12))->count();

                }else{

                    $january = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(1))->count();
                    $febuary = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(2))->count();
                    $march = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(3))->count();
                    $april = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(4))->count();
                    $may = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(5))->count();
                    $june = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(6))->count();
                    $july = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(7))->count();
                    $august = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(8))->count();
                    $september = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(9))->count();
                    $october = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(10))->count();
                    $november = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(11))->count();
                    $december = Cases::where('region','=',Auth::user()->user_region)->where('province','=',Auth::user()->user_province)->where('city','=',Auth::user()->user_municipality)->where('barangay','=',Auth::user()->user_barangay)->whereYear('date_of_intake', date('Y'))->whereMonth('date_of_intake', date(12))->count();
                }

                // End of Barangay Level Data
            }
        }

        
        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Dashboard") == false){

            return view('restricted');
        }
        else{

            return view('admin.dashboard', compact(
                                                'count_cases',
                                                'count_ongoing_cases',
                                                'count_completed_and_closed_cases',
                                                'intimate_partner_violence',
                                                'rape',
                                                'trafficking_in_person',
                                                'sexual_harassment',
                                                'child_abuse_exploitation_and_discrimination',
                                                'cases_data', 
                                                'january', 
                                                'febuary', 
                                                'march', 
                                                'april', 
                                                'may', 
                                                'june', 
                                                'july',
                                                'august',
                                                'september',
                                                'october',
                                                'november',
                                                'december',
                                                'extract_years_from_date_of_intake',
                                                'year',
                                                'regions',
                                                'date_from_sort_province',
                                                'date_to_sort_province',
                                                'region_name_for_sort_province',
                                                'extracted_province_from_sorted_list_of_province',
                                                'provinces',
                                                'date_from_sort_municipality',
                                                'date_to_sort_municipality','province_name_for_sort_municipality',
                                                'extracted_municipality_from_sorted_list_of_municipality',
                                                'date_from_sort_ethnicity',
                                                'date_to_sort_ethnicity',
                                                'extracted_ethnicity_from_sorted_list_of_ethnicity',
                                                'cities',
                                                'date_from_sort_barangay',
                                                'date_to_sort_barangay',
                                                'city_name_for_sort_barangay',
                                                'extracted_barangay_from_sorted_list_of_barangay'
                                            ))->render();
        }
        
    }
}

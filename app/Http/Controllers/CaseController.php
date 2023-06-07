<?php

namespace App\Http\Controllers;

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
use App\Models\UserRole;
use App\Models\CasesUsersActivityLogs;
use App\Models\DirectoryType;
use App\Models\Directory;
use App\Models\PlaceOfIncidences;
use App\Models\RelationshipToVictimSurvivors;
use App\Models\Religions;
use App\Models\CasesUploadedFiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CaseController extends Controller
{

    public function putSeparator($value){

        // Put Separator on value
        
        if(!empty($value)){
            return $value.'|';
        }
        else{
            return '';
        }

    }

    public function addNewCase(Request $request){

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if(str_contains($get_user_master_list_rights, "Add") == false){

                return "Sorry you don't have the rights to create case please contact the administrator";
                
            }else{

                if($request->form_status == 'Submitted'){

                    $validator = Validator::make(

                        array(

                            // Personal Details
        
                            'client_made_a_report_before' => $request->client_made_a_report_before,
                            'date_of_intake' => $request->date_of_intake,
                            'case_no' => $request->case_no,
                            'type_of_client' => $request->type_of_client,
                            'last_name' => $request->last_name,
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'birth_date' => $request->birth_date,
                            'sex' => $request->sex,
                            'extension_name' => $request->extension_name,
                            'alias_name' => $request->alias_name,
                            'age' => $request->age,
                            'client_diverse_sogie' => $request->client_diverse_sogie,
                            'civil_status' => $request->civil_status,
                            'education' => $request->education,
                            'religion' => $request->religion,
                            'religion_if_oth_pls_spec' => $request->religion_if_oth_pls_spec,
                            'nationality' => $request->nationality,
                            'nationality_if_oth_pls_spec' => $request->nationality_if_oth_pls_spec,
                            'ethnicity' => $request->ethnicity,
                            'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,
                            'employment_status' => $request->employment_status,
                            'if_self_emp_pls_ind' => $request->if_self_emp_pls_ind,
                            'house_hold_no' => $request->house_hold_no,
                            'region' => $request->region,
                            'province' => $request->province,
                            'city' => $request->city,
                            'barangay' => $request->barangay,
                            'street' => $request->street,
                            'is_idp' => $request->is_idp,
                            'is_pwd' => $request->is_pwd,
                            'if_pwd_pls_specify' => $request->if_pwd_pls_specify,
                            'per_det_cont_info' => $request->per_det_cont_info,
        
                            // Family Background
        
                            'name_par_guar' => $request->name_par_guar,
                            'job_vict_sur' => $request->job_vict_sur,
                            'age_vict_sur' => $request->age_vict_sur,
                            'rel_vict_sur' => $request->rel_vict_sur,
                            'rttvs_if_oth_pls_spec' => $request->rttvs_if_oth_pls_spec,
                            'fam_back_region' => $request->fam_back_region,
                            'fam_back_province' => $request->fam_back_province,
                            'fam_back_city' => $request->fam_back_city,
                            'fam_back_barangay' => $request->fam_back_barangay,
                            'fam_back_house_no' => $request->fam_back_house_no,
                            'fam_back_street' => $request->fam_back_street,
                            'fam_back_cont_num' => $request->fam_back_cont_num,
        
                            // Incidence Details
        
                            'id_date_int' => $request->id_date_int,
                            'id_name_intervi' => $request->id_name_intervi,
                            'id_pos_desi_int' => $request->id_pos_desi_int,
                            'id_int_part_vio' => $request->id_int_part_vio,
                            'id_int_part_vio_sub_opt' => $request->id_ipv_phys.$request->id_ipv_sexual.$request->id_ipv_psycho.$request->id_ipv_econo,
                            'id_rape' => $request->id_rape,
                            'id_rape_sub_opt' => $request->id_rape_incest.$request->id_rape_sta_rape.$request->id_rape_sex_int.$request->id_rape_sex_assa.$request->id_rape_mar_rape,
                            'id_traf_per' => $request->id_traf_per,
                            'id_traf_per_sub_opt' => $request->id_traf_per_sex_exp.$request->id_traf_per_onl_exp.$request->id_traf_per_others.$request->id_traf_per_forc_lab.$request->id_traf_per_srem_org.$request->id_traf_per_prost,
                            'id_traf_per_others' => $request->id_traf_per_others,
                            'id_traf_per_others_spec' => $request->id_traf_per_others_spec,
                            'id_sex_hara' => $request->id_sex_hara,
                            'id_sex_hara_sub_opt' => $request->id_sex_hara_ver.$request->id_sex_hara_others.$request->id_sex_hara_phys.$request->id_sex_hara_use_obj,
                            'id_sex_hara_others' => $request->id_sex_hara_others,
                            'id_sex_hara_others_spec' => $request->id_sex_hara_others_spec,
                            'id_chi_abu' => $request->id_chi_abu,
                            'id_chi_abu_sub_opt' => $request->id_chi_abu_efpaccp.$request->id_chi_abu_lasc_cond.$request->id_chi_abu_others.$request->id_chi_abu_sex_int.$request->id_chi_abu_phys_abu,
                            'id_chi_abu_others' => $request->id_chi_abu_others,
                            'id_chi_abu_others_spec' => $request->id_chi_abu_others_spec,
                            'id_descr_inci' => $request->id_descr_inci,
                            'id_date_of_inci' => $request->id_date_of_inci,
                            'id_time_of_inci' => $request->id_time_of_inci,
                            'inci_det_house_no' => $request->inci_det_house_no,
                            'inci_det_street' => $request->inci_det_street,
                            'inci_det_region' => $request->inci_det_region,
                            'inci_det_province' => $request->inci_det_province,
                            'inci_det_city' => $request->inci_det_city,
                            'inci_det_barangay' => $request->inci_det_barangay,
                            'id_pla_of_inci' => $request->id_pla_of_inci,
                            'id_pi_oth_pls_spec' => $request->id_pi_oth_pls_spec,
                            'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
        
                            // Perpetrator Details
                            
                            'perp_d_last_name' => $request->perp_d_last_name,
                            'perp_d_first_name' => $request->perp_d_first_name,
                            'perp_d_middle_name' => $request->perp_d_middle_name,
                            'perp_d_extension_name' => $request->perp_d_extension_name,
                            'perp_d_alias_name' => $request->perp_d_alias_name,
                            'perp_d_sex_radio' => $request->perp_d_sex_radio,
                            'perp_d_birthdate' => $request->perp_d_birthdate,
                            'perp_d_age' => $request->perp_d_age,
                            'perp_d_rel_victim' => $request->perp_d_rel_victim,
                            'perp_d_rel_vic_pls_spec' => $request->perp_d_rel_vic_pls_spec,
                            'perp_d_occup' => $request->perp_d_occup,
                            'perp_d_educ_att' => $request->perp_d_educ_att,
                            'perp_d_nationality' => $request->perp_d_nationality,
                            'perp_d_nat_if_oth_pls_spec' => $request->perp_d_nat_if_oth_pls_spec,
                            'perp_d_religion' => $request->perp_d_religion,
                            'perp_d_rel_if_oth_pls_spec' => $request->perp_d_rel_if_oth_pls_spec,
                            'perp_d_house_no' => $request->perp_d_house_no,
                            'perp_d_street' => $request->perp_d_street,
                            'perp_d_region' => $request->perp_d_region,
                            'perp_d_province' => $request->perp_d_province,
                            'perp_d_city' => $request->perp_d_city,
                            'perp_d_barangay' => $request->perp_d_barangay,
                            'perp_d_curr_loc' => $request->perp_d_curr_loc,
                            'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                            'perp_d_if_yes_pls_ind' => $request->perp_d_if_yes_pls_ind,
                            'perp_d_addr_par_gua' => $request->perp_d_addr_par_gua,
                            'perp_d_cont_par_gua' => $request->perp_d_cont_par_gua,
                            'perp_d_rel_guar_perp' => $request->perp_d_rel_guar_perp,
                            'perp_d_rel_rgp_pls_spec' => $request->perp_d_rel_rgp_pls_spec,
                            'perp_d_oth_info_perp' => $request->perp_d_oth_info_perp,
        
                            // Intervention Module
        
                            'im_type_of_service' => $request->im_type_of_service,
                            'im_typ_serv_if_oth_spec' => $request->im_typ_serv_if_oth_spec,
                            'im_speci_interv' => $request->im_speci_interv,
                            'im_spe_int_if_oth_spec' => $request->im_spe_int_if_oth_spec,
                            'im_serv_prov' => $request->im_serv_prov,
                            'im_ser_pro_if_oth_spec' => $request->im_ser_pro_if_oth_spec,
                            'im_speci_obje' => $request->im_speci_obje,
                            'im_target_date' => $request->im_target_date,
                            'im_status' => $request->im_status,
                            'im_if_status_com_pd' => $request->im_if_status_com_pd,
                            'im_dsp_full_name' => $request->im_dsp_full_name,
                            'im_dsp_post_desi' => $request->im_dsp_post_desi,
                            'im_dsp_email' => $request->im_dsp_email,
                            'im_dsp_contact_no_1' => $request->im_dsp_contact_no_1,
                            'im_dsp_contact_no_2' => $request->im_dsp_contact_no_2,
                            'im_dsp_contact_no_3' => $request->im_dsp_contact_no_3,
                            'im_dasp_full_name' => $request->im_dasp_full_name,
                            'im_dasp_post_desi' => $request->im_dasp_post_desi,
                            'im_dasp_email' => $request->im_dasp_email,
                            'im_dasp_contact_no_1' => $request->im_dasp_contact_no_1,
                            'im_dasp_contact_no_2' => $request->im_dasp_contact_no_2,
                            'im_dasp_contact_no_3' => $request->im_dasp_contact_no_3,
                            'im_summary' => $request->im_summary,
        
                            // Referral Module
        
                            'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                            'rm_name_ref_org' => $request->rm_name_ref_org,
                            'rm_ref_fro_ref_org' => $request->rm_ref_fro_ref_org,
                            'rm_addr_ref_org' => $request->rm_addr_ref_org,
                            'rm_referred_by' => $request->rm_referred_by,
                            'rm_position_title' => $request->rm_position_title,
                            'rm_contact_no' => $request->rm_contact_no,
                            'rm_email_add' => $request->rm_email_add,
        
                            // Case Module
        
                            'cm_case_status' => $request->cm_case_status,
                            'cm_assessment' => $request->cm_assessment,
                            'cm_recommendation' => $request->cm_recommendation,
                            'cm_remarks' => $request->cm_remarks,

                        ),

                        array(
    
                            // Personal Details
        
                            'client_made_a_report_before' => '',
                            'date_of_intake' => 'required',
                            'case_no' => 'required|unique:cases',
                            'type_of_client' => 'required',
                            'last_name' => 'required',
                            'first_name' => 'required',
                            'middle_name' => 'required',
                            'birth_date' => 'required',
                            'sex' => 'required',
                            'extension_name' => '',
                            'alias_name' => '',
                            'age' => 'required',
                            'client_diverse_sogie' => 'required',
                            'civil_status' => 'required',
                            'education' => 'required',
                            'religion' => 'required',
                            'religion_if_oth_pls_spec' => '',
                            'nationality' => 'required',
                            'nationality_if_oth_pls_spec' => '',
                            'ethnicity' => 'required',
                            'ethnicity_if_oth_pls_spec' => '',
                            'employment_status' => 'required',
                            'if_self_emp_pls_ind' => '',
                            'house_hold_no' => '',
                            'region' => 'required',
                            'province' => 'required',
                            'city' => 'required',
                            'barangay' => 'required',
                            'street' => '',
                            'is_idp' => 'required',
                            'is_pwd' => 'required',
                            'if_pwd_pls_specify' => '',
                            'per_det_cont_info' => 'required',
        
                            // Family Background
        
                            'name_par_guar' => 'required',
                            'job_vict_sur' => 'required',
                            'age_vict_sur' => 'required',
                            'rel_vict_sur' => 'required',
                            'rttvs_if_oth_pls_spec' => '',
                            'fam_back_region' => 'required',
                            'fam_back_province' => 'required',
                            'fam_back_city' => 'required',
                            'fam_back_barangay' => 'required',
                            'fam_back_house_no' => '',
                            'fam_back_street' => '',
                            'fam_back_cont_num' => 'required',
        
                            // Incidence Details
        
                            'id_date_int' => 'required',
                            'id_name_intervi' => 'required',
                            'id_pos_desi_int' => 'required',
                            'id_int_part_vio' => 'required_without_all:id_rape,id_traf_per,id_sex_hara,id_chi_abu|required_with:id_int_part_vio_sub_opt',
                            'id_int_part_vio_sub_opt' => 'required_with:id_int_part_vio',
                            'id_rape' => 'required_without_all:id_int_part_vio,id_traf_per,id_sex_hara,id_chi_abu|required_with:id_rape_sub_opt',
                            'id_rape_sub_opt' => 'required_with:id_rape',
                            'id_traf_per' => 'required_without_all:id_int_part_vio,id_rape,id_sex_hara,id_chi_abu|required_with:id_traf_per_sub_opt',
                            'id_traf_per_sub_opt' => 'required_with:id_traf_per',
                            'id_traf_per_others' => '',
                            'id_traf_per_others_spec' => 'required_if:id_traf_per_others,Others',
                            'id_sex_hara' => 'required_without_all:id_int_part_vio,id_rape,id_traf_per,id_chi_abu|required_with:id_sex_hara_sub_opt',
                            'id_sex_hara_sub_opt' => 'required_with:id_sex_hara',
                            'id_sex_hara_others' => '',
                            'id_sex_hara_others_spec' => 'required_if:id_sex_hara_others,Others',
                            'id_chi_abu' => 'required_without_all:id_int_part_vio,id_rape,id_traf_per,id_sex_hara|required_with:id_chi_abu_sub_opt',
                            'id_chi_abu_sub_opt' => 'required_with:id_chi_abu',
                            'id_chi_abu_others' => '',
                            'id_chi_abu_others_spec' => 'required_if:id_chi_abu_others,Others',
                            'id_descr_inci' => 'required',
                            'id_date_of_inci' => 'required',
                            'id_time_of_inci' => '',
                            'inci_det_house_no' => '',
                            'inci_det_street' => '',
                            'inci_det_region' => 'required',
                            'inci_det_province' => 'required',
                            'inci_det_city' => 'required',
                            'inci_det_barangay' => 'required',
                            'id_pla_of_inci' => 'required',
                            'id_pi_oth_pls_spec' => '',
                            'id_was_inc_perp_onl' => 'required',
        
                            // Perpetrator Details
                            
                            'perp_d_last_name' => 'required',
                            'perp_d_first_name' => 'required',
                            'perp_d_middle_name' => 'required',
                            'perp_d_extension_name' => '',
                            'perp_d_alias_name' => '',
                            'perp_d_sex_radio' => 'required',
                            'perp_d_birthdate' => 'required',
                            'perp_d_age' => 'required',
                            'perp_d_rel_victim' => 'required',
                            'perp_d_rel_vic_pls_spec' => '',
                            'perp_d_occup' => 'required',
                            'perp_d_educ_att' => 'required',
                            'perp_d_nationality' => 'required',
                            'perp_d_nat_if_oth_pls_spec' => '',
                            'perp_d_religion' => 'required',
                            'perp_d_rel_if_oth_pls_spec' => '',
                            'perp_d_house_no' => '',
                            'perp_d_street' => '',
                            'perp_d_region' => 'required',
                            'perp_d_province' => 'required',
                            'perp_d_city' => 'required',
                            'perp_d_barangay' => 'required',
                            'perp_d_curr_loc' => 'required',
                            'perp_d_is_perp_minor' => 'required',
                            'perp_d_if_yes_pls_ind' => '',
                            'perp_d_addr_par_gua' => 'required',
                            'perp_d_cont_par_gua' => 'required',
                            'perp_d_rel_guar_perp' => 'required',
                            'perp_d_rel_rgp_pls_spec' => '',
                            'perp_d_oth_info_perp' => '',
        
                            // Intervention Module
        
                            'im_type_of_service' => 'required',
                            'im_typ_serv_if_oth_spec' => '',
                            'im_speci_interv' => 'required',
                            'im_spe_int_if_oth_spec' => '',
                            'im_serv_prov' => 'required',
                            'im_ser_pro_if_oth_spec' => '',
                            'im_speci_obje' => 'required',
                            'im_target_date' => 'required',
                            'im_status' => 'required',
                            'im_if_status_com_pd' => 'required_if:im_status,Provided',
                            'im_dsp_full_name' => 'required',
                            'im_dsp_post_desi' => 'required',
                            'im_dsp_email' => 'required',
                            'im_dsp_contact_no_1' => 'required',
                            'im_dsp_contact_no_2' => '',
                            'im_dsp_contact_no_3' => '',
                            'im_dasp_full_name' => '',
                            'im_dasp_post_desi' => '',
                            'im_dasp_email' => '',
                            'im_dasp_contact_no_1' => '',
                            'im_dasp_contact_no_2' => '',
                            'im_dasp_contact_no_3' => '',
                            'im_summary' => 'required',
        
                            // Referral Module
        
                            'rm_was_cli_ref_by_org' => 'required',
                            'rm_name_ref_org' => 'required_if:rm_was_cli_ref_by_org,Yes',
                            'rm_ref_fro_ref_org' => 'required_if:rm_was_cli_ref_by_org,Yes',
                            'rm_addr_ref_org' => 'required_if:rm_was_cli_ref_by_org,Yes',
                            'rm_referred_by' => 'required_if:rm_was_cli_ref_by_org,Yes',
                            'rm_position_title' => 'required_if:rm_was_cli_ref_by_org,Yes',
                            'rm_contact_no' => 'required_if:rm_was_cli_ref_by_org,Yes',
                            'rm_email_add' => 'required_if:rm_was_cli_ref_by_org,Yes',
        
                            // Case Module
        
                            'cm_case_status' => 'required',
                            'cm_assessment' => 'required',
                            'cm_recommendation' => 'required',
                            'cm_remarks' => 'required',

                        )
    
                            
                    );
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{
        
                        Cases::create([
                            'case_no' => $request->case_no,
                            'last_name' => $request->last_name,
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'date_of_intake' => $request->date_of_intake,
                            'im_serv_prov' => $request->im_serv_prov,
                            'form_status' => $request->form_status,
                            'cm_case_status' => $request->cm_case_status,
                            'region' => $request->region,
                            'province' => $request->province,
                            'city' => $request->city,
                            'barangay' => $request->barangay,
                            'client_made_a_report_before' => $request->client_made_a_report_before,
                            'age' => $request->age,
                            'sex' => $request->sex,
                            'civil_status' => $request->civil_status,
                            'client_diverse_sogie' => $request->client_diverse_sogie,
                            'education' => $request->education,
                            'religion' => $request->religion,
                            'ethnicity' => $request->ethnicity,
                            'nationality' => $request->nationality,
                            'is_idp' => $request->is_idp,
                            'is_pwd' => $request->is_pwd,
                            'age_vict_sur' => $request->age_vict_sur,
                            'nature_of_incidence' => CaseController::putSeparator($request->id_int_part_vio).CaseController::putSeparator($request->id_rape).CaseController::putSeparator($request->id_traf_per).CaseController::putSeparator($request->id_sex_hara).CaseController::putSeparator($request->id_chi_abu),
                            'sub_option_of_nature_of_incidence' => CaseController::putSeparator($request->id_ipv_phys).CaseController::putSeparator($request->id_ipv_sexual).CaseController::putSeparator($request->id_ipv_psycho).CaseController::putSeparator($request->id_ipv_econo).CaseController::putSeparator($request->id_rape_incest).CaseController::putSeparator($request->id_rape_sta_rape).CaseController::putSeparator($request->id_rape_sex_int).CaseController::putSeparator($request->id_rape_sex_assa).CaseController::putSeparator($request->id_rape_mar_rape).CaseController::putSeparator($request->id_traf_per_sex_exp).CaseController::putSeparator($request->id_traf_per_onl_exp).CaseController::putSeparator($request->id_traf_per_others).CaseController::putSeparator($request->id_traf_per_others_spec).CaseController::putSeparator($request->id_traf_per_forc_lab).CaseController::putSeparator($request->id_traf_per_srem_org).CaseController::putSeparator($request->id_traf_per_prost).CaseController::putSeparator($request->id_sex_hara_ver).CaseController::putSeparator($request->id_sex_hara_others).CaseController::putSeparator($request->id_sex_hara_others_spec).CaseController::putSeparator($request->id_sex_hara_phys).CaseController::putSeparator($request->id_sex_hara_use_obj).CaseController::putSeparator($request->id_chi_abu_efpaccp).CaseController::putSeparator($request->id_chi_abu_lasc_cond).CaseController::putSeparator($request->id_chi_abu_others).CaseController::putSeparator($request->id_chi_abu_others_spec).CaseController::putSeparator($request->id_chi_abu_sex_int).CaseController::putSeparator($request->id_chi_abu_phys_abu),
                            'id_pla_of_inci' => $request->id_pla_of_inci,
                            'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                            'perp_d_age' => $request->perp_d_age,
                            'perp_d_sex_radio' => $request->perp_d_sex_radio,
                            'perp_d_rel_victim' => $request->perp_d_rel_victim,
                            'perp_d_occup' => $request->perp_d_occup,
                            'perp_d_nationality' => $request->perp_d_nationality,
                            'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                            'im_type_of_service' => $request->im_type_of_service,
                            'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                            'type_of_client' => $request->type_of_client,
                            'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,

                        ]);
        
                        PersonalDetails::create([
                            'client_made_a_report_before' => $request->client_made_a_report_before,
                            'date_of_intake' => $request->date_of_intake,
                            'case_no' => $request->case_no,
                            'type_of_client' => $request->type_of_client,
                            'last_name' => $request->last_name,
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'birth_date' => $request->birth_date,
                            'sex' => $request->sex,
                            'extension_name' => $request->extension_name,
                            'alias_name' => $request->alias_name,
                            'age' => $request->age,
                            'client_diverse_sogie' => $request->client_diverse_sogie,
                            'civil_status' => $request->civil_status,
                            'education' => $request->education,
                            'religion' => $request->religion,
                            'religion_if_oth_pls_spec' => $request->religion_if_oth_pls_spec,
                            'nationality' => $request->nationality,
                            'nationality_if_oth_pls_spec' => $request->nationality_if_oth_pls_spec,
                            'ethnicity' => $request->ethnicity,
                            'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,
                            'employment_status' => $request->employment_status,
                            'if_self_emp_pls_ind' => $request->if_self_emp_pls_ind,
                            'house_hold_no' => $request->house_hold_no,
                            'region' => $request->region,
                            'province' => $request->province,
                            'city' => $request->city,
                            'barangay' => $request->barangay,
                            'street' => $request->street,
                            'is_idp' => $request->is_idp,
                            'is_pwd' => $request->is_pwd,
                            'if_pwd_pls_specify' => $request->if_pwd_pls_specify,
                            'per_det_cont_info' => $request->per_det_cont_info,
                        ]);
        
                        FamilyBackgrounds::create([
                            'case_no' => $request->case_no,
                            'name_par_guar' => $request->name_par_guar,
                            'job_vict_sur' => $request->job_vict_sur,
                            'age_vict_sur' => $request->age_vict_sur,
                            'rel_vict_sur' => $request->rel_vict_sur,
                            'rttvs_if_oth_pls_spec' => $request->rttvs_if_oth_pls_spec,
                            'fam_back_region' => $request->fam_back_region,
                            'fam_back_province' => $request->fam_back_province,
                            'fam_back_city' => $request->fam_back_city,
                            'fam_back_barangay' => $request->fam_back_barangay,
                            'fam_back_house_no' => $request->fam_back_house_no,
                            'fam_back_street' => $request->fam_back_street,
                            'fam_back_cont_num' => $request->fam_back_cont_num,
                        ]);
        
                        IncidenceDetails::create([
                            'case_no' => $request->case_no,
                            'id_date_int' => $request->id_date_int,
                            'id_name_intervi' => $request->id_name_intervi,
                            'id_pos_desi_int' => $request->id_pos_desi_int,
                            'id_int_part_vio' => $request->id_int_part_vio,
                            'id_ipv_phys' => $request->id_ipv_phys,
                            'id_ipv_sexual' => $request->id_ipv_sexual,
                            'id_ipv_psycho' => $request->id_ipv_psycho,
                            'id_ipv_econo' => $request->id_ipv_econo,
                            'id_rape' => $request->id_rape,
                            'id_rape_incest' => $request->id_rape_incest,
                            'id_rape_sta_rape' => $request->id_rape_sta_rape,
                            'id_rape_sex_int' => $request->id_rape_sex_int,
                            'id_rape_sex_assa' => $request->id_rape_sex_assa,
                            'id_rape_mar_rape' => $request->id_rape_mar_rape,
                            'id_traf_per' => $request->id_traf_per,
                            'id_traf_per_sex_exp' => $request->id_traf_per_sex_exp,
                            'id_traf_per_onl_exp' => $request->id_traf_per_onl_exp,
                            'id_traf_per_others' => $request->id_traf_per_others,
                            'id_traf_per_others_spec' => $request->id_traf_per_others_spec,
                            'id_traf_per_forc_lab' => $request->id_traf_per_forc_lab,
                            'id_traf_per_srem_org' => $request->id_traf_per_srem_org,
                            'id_traf_per_prost' => $request->id_traf_per_prost,
                            'id_sex_hara' => $request->id_sex_hara,
                            'id_sex_hara_ver' => $request->id_sex_hara_ver,
                            'id_sex_hara_others' => $request->id_sex_hara_others,
                            'id_sex_hara_others_spec' => $request->id_sex_hara_others_spec,
                            'id_sex_hara_phys' => $request->id_sex_hara_phys,
                            'id_sex_hara_use_obj' => $request->id_sex_hara_use_obj,
                            'id_chi_abu' => $request->id_chi_abu,
                            'id_chi_abu_efpaccp' => $request->id_chi_abu_efpaccp,
                            'id_chi_abu_lasc_cond' => $request->id_chi_abu_lasc_cond,
                            'id_chi_abu_others' => $request->id_chi_abu_others,
                            'id_chi_abu_others_spec' => $request->id_chi_abu_others_spec,
                            'id_chi_abu_sex_int' => $request->id_chi_abu_sex_int,
                            'id_chi_abu_phys_abu' => $request->id_chi_abu_phys_abu,
                            'id_descr_inci' => $request->id_descr_inci,
                            'id_date_of_inci' => $request->id_date_of_inci,
                            'id_time_of_inci' => $request->id_time_of_inci,
                            'inci_det_house_no' => $request->inci_det_house_no,
                            'inci_det_street' => $request->inci_det_street,
                            'inci_det_region' => $request->inci_det_region,
                            'inci_det_province' => $request->inci_det_province,
                            'inci_det_city' => $request->inci_det_city,
                            'inci_det_barangay' => $request->inci_det_barangay,
                            'id_pla_of_inci' => $request->id_pla_of_inci,
                            'id_pi_oth_pls_spec' => $request->id_pi_oth_pls_spec,
                            'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                        ]);
        
                        PerpetratorDetails::create([
                            'case_no' => $request->case_no,
                            'perp_d_last_name' => $request->perp_d_last_name,
                            'perp_d_first_name' => $request->perp_d_first_name,
                            'perp_d_middle_name' => $request->perp_d_middle_name,
                            'perp_d_extension_name' => $request->perp_d_extension_name,
                            'perp_d_alias_name' => $request->perp_d_alias_name,
                            'perp_d_sex_radio' => $request->perp_d_sex_radio,
                            'perp_d_birthdate' => $request->perp_d_birthdate,
                            'perp_d_age' => $request->perp_d_age,
                            'perp_d_rel_victim' => $request->perp_d_rel_victim,
                            'perp_d_rel_vic_pls_spec' => $request->perp_d_rel_vic_pls_spec,
                            'perp_d_occup' => $request->perp_d_occup,
                            'perp_d_educ_att' => $request->perp_d_educ_att,
                            'perp_d_nationality' => $request->perp_d_nationality,
                            'perp_d_nat_if_oth_pls_spec' => $request->perp_d_nat_if_oth_pls_spec,
                            'perp_d_religion' => $request->perp_d_religion,
                            'perp_d_rel_if_oth_pls_spec' => $request->perp_d_rel_if_oth_pls_spec,
                            'perp_d_house_no' => $request->perp_d_house_no,
                            'perp_d_street' => $request->perp_d_street,
                            'perp_d_region' => $request->perp_d_region,
                            'perp_d_province' => $request->perp_d_province,
                            'perp_d_city' => $request->perp_d_city,
                            'perp_d_barangay' => $request->perp_d_barangay,
                            'perp_d_curr_loc' => $request->perp_d_curr_loc,
                            'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                            'perp_d_if_yes_pls_ind' => $request->perp_d_if_yes_pls_ind,
                            'perp_d_addr_par_gua' => $request->perp_d_addr_par_gua,
                            'perp_d_cont_par_gua' => $request->perp_d_cont_par_gua,
                            'perp_d_rel_guar_perp' => $request->perp_d_rel_guar_perp,
                            'perp_d_rel_rgp_pls_spec' => $request->perp_d_rel_rgp_pls_spec,
                            'perp_d_oth_info_perp' => $request->perp_d_oth_info_perp,
                        ]);
        
                        InterventionModules::create([
                            'case_no' => $request->case_no,
                            'im_type_of_service' => $request->im_type_of_service,
                            'im_typ_serv_if_oth_spec' => $request->im_typ_serv_if_oth_spec,
                            'im_speci_interv' => $request->im_speci_interv,
                            'im_spe_int_if_oth_spec' => $request->im_spe_int_if_oth_spec,
                            'im_serv_prov' => $request->im_serv_prov,
                            'im_ser_pro_if_oth_spec' => $request->im_ser_pro_if_oth_spec,
                            'im_speci_obje' => $request->im_speci_obje,
                            'im_target_date' => $request->im_target_date,
                            'im_status' => $request->im_status,
                            'im_if_status_com_pd' => $request->im_if_status_com_pd,
                            'im_dsp_full_name' => $request->im_dsp_full_name,
                            'im_dsp_post_desi' => $request->im_dsp_post_desi,
                            'im_dsp_email' => $request->im_dsp_email,
                            'im_dsp_contact_no_1' => $request->im_dsp_contact_no_1,
                            'im_dsp_contact_no_2' => $request->im_dsp_contact_no_2,
                            'im_dsp_contact_no_3' => $request->im_dsp_contact_no_3,
                            'im_dasp_full_name' => $request->im_dasp_full_name,
                            'im_dasp_post_desi' => $request->im_dasp_post_desi,
                            'im_dasp_email' => $request->im_dasp_email,
                            'im_dasp_contact_no_1' => $request->im_dasp_contact_no_1,
                            'im_dasp_contact_no_2' => $request->im_dasp_contact_no_2,
                            'im_dasp_contact_no_3' => $request->im_dasp_contact_no_3,
                            'im_summary' => $request->im_summary,
                        ]);
        
                        ReferralModules::create([
                            'case_no' => $request->case_no,
                            'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                            'rm_name_ref_org' => $request->rm_name_ref_org,
                            'rm_ref_fro_ref_org' => $request->rm_ref_fro_ref_org,
                            'rm_addr_ref_org' => $request->rm_addr_ref_org,
                            'rm_referred_by' => $request->rm_referred_by,
                            'rm_position_title' => $request->rm_position_title,
                            'rm_contact_no' => $request->rm_contact_no,
                            'rm_email_add' => $request->rm_email_add,
        
                        ]);
        
                        CaseModules::create([
                            'case_no' => $request->case_no,
                            'cm_case_status' => $request->cm_case_status,
                            'cm_remarks' => $request->cm_remarks,
                            'cm_assessment' => $request->cm_assessment,
                            'cm_recommendation' => $request->cm_recommendation,
                            'cm_upload' => $request->cm_upload,
                        ]);
        
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $request->case_no,
                            'accountable_user_activity' => 'Create',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
        
                        return "Case successfully created and submitted";
                    }
    
                }elseif($request->form_status == 'Draft'){
    
                    $validator = Validator::make($request->all(), [
                        'case_no' => 'required|unique:cases',
                        'region' => 'required',
                        'province' => 'required',
                        'city' => 'required',
                        'barangay' => 'required',    
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{
        
                        Cases::create([
                            'case_no' => $request->case_no,
                            'last_name' => $request->last_name,
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'date_of_intake' => $request->date_of_intake,
                            'im_serv_prov' => $request->im_serv_prov,
                            'form_status' => $request->form_status,
                            'cm_case_status' => $request->cm_case_status,
                            'region' => $request->region,
                            'province' => $request->province,
                            'city' => $request->city,
                            'barangay' => $request->barangay,
                            'client_made_a_report_before' => $request->client_made_a_report_before,
                            'age' => $request->age,
                            'sex' => $request->sex,
                            'civil_status' => $request->civil_status,
                            'client_diverse_sogie' => $request->client_diverse_sogie,
                            'education' => $request->education,
                            'religion' => $request->religion,
                            'ethnicity' => $request->ethnicity,
                            'nationality' => $request->nationality,
                            'is_idp' => $request->is_idp,
                            'is_pwd' => $request->is_pwd,
                            'age_vict_sur' => $request->age_vict_sur,
                            'nature_of_incidence' => CaseController::putSeparator($request->id_int_part_vio).CaseController::putSeparator($request->id_rape).CaseController::putSeparator($request->id_traf_per).CaseController::putSeparator($request->id_sex_hara).CaseController::putSeparator($request->id_chi_abu),
                            'sub_option_of_nature_of_incidence' => CaseController::putSeparator($request->id_ipv_phys).CaseController::putSeparator($request->id_ipv_sexual).CaseController::putSeparator($request->id_ipv_psycho).CaseController::putSeparator($request->id_ipv_econo).CaseController::putSeparator($request->id_rape_incest).CaseController::putSeparator($request->id_rape_sta_rape).CaseController::putSeparator($request->id_rape_sex_int).CaseController::putSeparator($request->id_rape_sex_assa).CaseController::putSeparator($request->id_rape_mar_rape).CaseController::putSeparator($request->id_traf_per_sex_exp).CaseController::putSeparator($request->id_traf_per_onl_exp).CaseController::putSeparator($request->id_traf_per_others).CaseController::putSeparator($request->id_traf_per_others_spec).CaseController::putSeparator($request->id_traf_per_forc_lab).CaseController::putSeparator($request->id_traf_per_srem_org).CaseController::putSeparator($request->id_traf_per_prost).CaseController::putSeparator($request->id_sex_hara_ver).CaseController::putSeparator($request->id_sex_hara_others).CaseController::putSeparator($request->id_sex_hara_others_spec).CaseController::putSeparator($request->id_sex_hara_phys).CaseController::putSeparator($request->id_sex_hara_use_obj).CaseController::putSeparator($request->id_chi_abu_efpaccp).CaseController::putSeparator($request->id_chi_abu_lasc_cond).CaseController::putSeparator($request->id_chi_abu_others).CaseController::putSeparator($request->id_chi_abu_others_spec).CaseController::putSeparator($request->id_chi_abu_sex_int).CaseController::putSeparator($request->id_chi_abu_phys_abu),
                            'id_pla_of_inci' => $request->id_pla_of_inci,
                            'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                            'perp_d_age' => $request->perp_d_age,
                            'perp_d_sex_radio' => $request->perp_d_sex_radio,
                            'perp_d_rel_victim' => $request->perp_d_rel_victim,
                            'perp_d_occup' => $request->perp_d_occup,
                            'perp_d_nationality' => $request->perp_d_nationality,
                            'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                            'im_type_of_service' => $request->im_type_of_service,
                            'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                            'type_of_client' => $request->type_of_client,
                            'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,

                        ]);
        
                        PersonalDetails::create([
                            'client_made_a_report_before' => $request->client_made_a_report_before,
                            'date_of_intake' => $request->date_of_intake,
                            'case_no' => $request->case_no,
                            'type_of_client' => $request->type_of_client,
                            'last_name' => $request->last_name,
                            'first_name' => $request->first_name,
                            'middle_name' => $request->middle_name,
                            'birth_date' => $request->birth_date,
                            'sex' => $request->sex,
                            'extension_name' => $request->extension_name,
                            'alias_name' => $request->alias_name,
                            'age' => $request->age,
                            'client_diverse_sogie' => $request->client_diverse_sogie,
                            'civil_status' => $request->civil_status,
                            'education' => $request->education,
                            'religion' => $request->religion,
                            'religion_if_oth_pls_spec' => $request->religion_if_oth_pls_spec,
                            'nationality' => $request->nationality,
                            'nationality_if_oth_pls_spec' => $request->nationality_if_oth_pls_spec,
                            'ethnicity' => $request->ethnicity,
                            'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,
                            'employment_status' => $request->employment_status,
                            'if_self_emp_pls_ind' => $request->if_self_emp_pls_ind,
                            'house_hold_no' => $request->house_hold_no,
                            'region' => $request->region,
                            'province' => $request->province,
                            'city' => $request->city,
                            'barangay' => $request->barangay,
                            'street' => $request->street,
                            'is_idp' => $request->is_idp,
                            'is_pwd' => $request->is_pwd,
                            'if_pwd_pls_specify' => $request->if_pwd_pls_specify,
                            'per_det_cont_info' => $request->per_det_cont_info,
                        ]);
        
                        FamilyBackgrounds::create([
                            'case_no' => $request->case_no,
                            'name_par_guar' => $request->name_par_guar,
                            'job_vict_sur' => $request->job_vict_sur,
                            'age_vict_sur' => $request->age_vict_sur,
                            'rel_vict_sur' => $request->rel_vict_sur,
                            'rttvs_if_oth_pls_spec' => $request->rttvs_if_oth_pls_spec,
                            'fam_back_region' => $request->fam_back_region,
                            'fam_back_province' => $request->fam_back_province,
                            'fam_back_city' => $request->fam_back_city,
                            'fam_back_barangay' => $request->fam_back_barangay,
                            'fam_back_house_no' => $request->fam_back_house_no,
                            'fam_back_street' => $request->fam_back_street,
                            'fam_back_cont_num' => $request->fam_back_cont_num,
                        ]);
        
                        IncidenceDetails::create([
                            'case_no' => $request->case_no,
                            'id_date_int' => $request->id_date_int,
                            'id_name_intervi' => $request->id_name_intervi,
                            'id_pos_desi_int' => $request->id_pos_desi_int,
                            'id_int_part_vio' => $request->id_int_part_vio,
                            'id_ipv_phys' => $request->id_ipv_phys,
                            'id_ipv_sexual' => $request->id_ipv_sexual,
                            'id_ipv_psycho' => $request->id_ipv_psycho,
                            'id_ipv_econo' => $request->id_ipv_econo,
                            'id_rape' => $request->id_rape,
                            'id_rape_incest' => $request->id_rape_incest,
                            'id_rape_sta_rape' => $request->id_rape_sta_rape,
                            'id_rape_sex_int' => $request->id_rape_sex_int,
                            'id_rape_sex_assa' => $request->id_rape_sex_assa,
                            'id_rape_mar_rape' => $request->id_rape_mar_rape,
                            'id_traf_per' => $request->id_traf_per,
                            'id_traf_per_sex_exp' => $request->id_traf_per_sex_exp,
                            'id_traf_per_onl_exp' => $request->id_traf_per_onl_exp,
                            'id_traf_per_others' => $request->id_traf_per_others,
                            'id_traf_per_others_spec' => $request->id_traf_per_others_spec,
                            'id_traf_per_forc_lab' => $request->id_traf_per_forc_lab,
                            'id_traf_per_srem_org' => $request->id_traf_per_srem_org,
                            'id_traf_per_prost' => $request->id_traf_per_prost,
                            'id_sex_hara' => $request->id_sex_hara,
                            'id_sex_hara_ver' => $request->id_sex_hara_ver,
                            'id_sex_hara_others' => $request->id_sex_hara_others,
                            'id_sex_hara_others_spec' => $request->id_sex_hara_others_spec,
                            'id_sex_hara_phys' => $request->id_sex_hara_phys,
                            'id_sex_hara_use_obj' => $request->id_sex_hara_use_obj,
                            'id_chi_abu' => $request->id_chi_abu,
                            'id_chi_abu_efpaccp' => $request->id_chi_abu_efpaccp,
                            'id_chi_abu_lasc_cond' => $request->id_chi_abu_lasc_cond,
                            'id_chi_abu_others' => $request->id_chi_abu_others,
                            'id_chi_abu_others_spec' => $request->id_chi_abu_others_spec,
                            'id_chi_abu_sex_int' => $request->id_chi_abu_sex_int,
                            'id_chi_abu_phys_abu' => $request->id_chi_abu_phys_abu,
                            'id_descr_inci' => $request->id_descr_inci,
                            'id_date_of_inci' => $request->id_date_of_inci,
                            'id_time_of_inci' => $request->id_time_of_inci,
                            'inci_det_house_no' => $request->inci_det_house_no,
                            'inci_det_street' => $request->inci_det_street,
                            'inci_det_region' => $request->inci_det_region,
                            'inci_det_province' => $request->inci_det_province,
                            'inci_det_city' => $request->inci_det_city,
                            'inci_det_barangay' => $request->inci_det_barangay,
                            'id_pla_of_inci' => $request->id_pla_of_inci,
                            'id_pi_oth_pls_spec' => $request->id_pi_oth_pls_spec,
                            'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                        ]);
        
                        PerpetratorDetails::create([
                            'case_no' => $request->case_no,
                            'perp_d_last_name' => $request->perp_d_last_name,
                            'perp_d_first_name' => $request->perp_d_first_name,
                            'perp_d_middle_name' => $request->perp_d_middle_name,
                            'perp_d_extension_name' => $request->perp_d_extension_name,
                            'perp_d_alias_name' => $request->perp_d_alias_name,
                            'perp_d_sex_radio' => $request->perp_d_sex_radio,
                            'perp_d_birthdate' => $request->perp_d_birthdate,
                            'perp_d_age' => $request->perp_d_age,
                            'perp_d_rel_victim' => $request->perp_d_rel_victim,
                            'perp_d_rel_vic_pls_spec' => $request->perp_d_rel_vic_pls_spec,
                            'perp_d_occup' => $request->perp_d_occup,
                            'perp_d_educ_att' => $request->perp_d_educ_att,
                            'perp_d_nationality' => $request->perp_d_nationality,
                            'perp_d_nat_if_oth_pls_spec' => $request->perp_d_nat_if_oth_pls_spec,
                            'perp_d_religion' => $request->perp_d_religion,
                            'perp_d_rel_if_oth_pls_spec' => $request->perp_d_rel_if_oth_pls_spec,
                            'perp_d_house_no' => $request->perp_d_house_no,
                            'perp_d_street' => $request->perp_d_street,
                            'perp_d_region' => $request->perp_d_region,
                            'perp_d_province' => $request->perp_d_province,
                            'perp_d_city' => $request->perp_d_city,
                            'perp_d_barangay' => $request->perp_d_barangay,
                            'perp_d_curr_loc' => $request->perp_d_curr_loc,
                            'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                            'perp_d_if_yes_pls_ind' => $request->perp_d_if_yes_pls_ind,
                            'perp_d_addr_par_gua' => $request->perp_d_addr_par_gua,
                            'perp_d_cont_par_gua' => $request->perp_d_cont_par_gua,
                            'perp_d_rel_guar_perp' => $request->perp_d_rel_guar_perp,
                            'perp_d_rel_rgp_pls_spec' => $request->perp_d_rel_rgp_pls_spec,
                            'perp_d_oth_info_perp' => $request->perp_d_oth_info_perp,
                        ]);
        
                        InterventionModules::create([
                            'case_no' => $request->case_no,
                            'im_type_of_service' => $request->im_type_of_service,
                            'im_typ_serv_if_oth_spec' => $request->im_typ_serv_if_oth_spec,
                            'im_speci_interv' => $request->im_speci_interv,
                            'im_spe_int_if_oth_spec' => $request->im_spe_int_if_oth_spec,
                            'im_serv_prov' => $request->im_serv_prov,
                            'im_ser_pro_if_oth_spec' => $request->im_ser_pro_if_oth_spec,
                            'im_speci_obje' => $request->im_speci_obje,
                            'im_target_date' => $request->im_target_date,
                            'im_status' => $request->im_status,
                            'im_if_status_com_pd' => $request->im_if_status_com_pd,
                            'im_dsp_full_name' => $request->im_dsp_full_name,
                            'im_dsp_post_desi' => $request->im_dsp_post_desi,
                            'im_dsp_email' => $request->im_dsp_email,
                            'im_dsp_contact_no_1' => $request->im_dsp_contact_no_1,
                            'im_dsp_contact_no_2' => $request->im_dsp_contact_no_2,
                            'im_dsp_contact_no_3' => $request->im_dsp_contact_no_3,
                            'im_dasp_full_name' => $request->im_dasp_full_name,
                            'im_dasp_post_desi' => $request->im_dasp_post_desi,
                            'im_dasp_email' => $request->im_dasp_email,
                            'im_dasp_contact_no_1' => $request->im_dasp_contact_no_1,
                            'im_dasp_contact_no_2' => $request->im_dasp_contact_no_2,
                            'im_dasp_contact_no_3' => $request->im_dasp_contact_no_3,
                            'im_summary' => $request->im_summary,
                        ]);
        
                        ReferralModules::create([
                            'case_no' => $request->case_no,
                            'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                            'rm_name_ref_org' => $request->rm_name_ref_org,
                            'rm_ref_fro_ref_org' => $request->rm_ref_fro_ref_org,
                            'rm_addr_ref_org' => $request->rm_addr_ref_org,
                            'rm_referred_by' => $request->rm_referred_by,
                            'rm_position_title' => $request->rm_position_title,
                            'rm_contact_no' => $request->rm_contact_no,
                            'rm_email_add' => $request->rm_email_add,
        
                        ]);
        
                        CaseModules::create([
                            'case_no' => $request->case_no,
                            'cm_case_status' => $request->cm_case_status,
                            'cm_remarks' => $request->cm_remarks,
                            'cm_assessment' => $request->cm_assessment,
                            'cm_recommendation' => $request->cm_recommendation,
                            'cm_upload' => $request->cm_upload,
                        ]);
        
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $request->case_no,
                            'accountable_user_activity' => 'Create',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
        
                        return "Case successfully saved as draft";
                    }
                }
            }
        }   
    }

    // Start of Modal add record

    public function addFamilyBackgroundInfos(Request $request){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if(str_contains($get_user_master_list_rights, "Add") == false){

                return "Sorry you don't have the rights to add record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed add record was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [
   
                        'case_no_modal' => 'required',
                        'name_par_guar_modal' => 'required',
                        'job_vict_sur_modal' => 'required',
                        'age_vict_sur_modal' => 'required',
                        'rel_vict_sur_modal' => 'required',
                        'rttvs_if_oth_pls_spec_modal' => '',
                        'fam_back_house_no_modal' => '',
                        'fam_back_street_modal' => '',
                        'fam_back_region_modal' => 'required',
                        'fam_back_province_modal' => 'required',
                        'fam_back_city_modal' => 'required',
                        'fam_back_barangay_modal' => 'required',
                        'fam_back_cont_num_modal' => 'required',
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{
        
                        FamilyBackgroundInfos::create([
                            'case_no_modal' => $request->case_no_modal,
                            'name_par_guar_modal' => $request->name_par_guar_modal,
                            'age_vict_sur_modal' => $request->age_vict_sur_modal,
                            'job_vict_sur_modal' => $request->job_vict_sur_modal,
                            'rel_vict_sur_modal' => $request->rel_vict_sur_modal,
                            'rttvs_if_oth_pls_spec_modal' => $request->rttvs_if_oth_pls_spec_modal,
                            'fam_back_region_modal' => $request->fam_back_region_modal,
                            'fam_back_province_modal' => $request->fam_back_province_modal,
                            'fam_back_city_modal' => $request->fam_back_city_modal,
                            'fam_back_barangay_modal' => $request->fam_back_barangay_modal,
                            'fam_back_house_no_modal' => $request->fam_back_house_no_modal,
                            'fam_back_street_modal' => $request->fam_back_street_modal,
                            'fam_back_cont_num_modal' => $request->fam_back_cont_num_modal,
                        ]);
        
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $request->case_no_modal,
                            'accountable_user_activity' => 'Create-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
        
                        return 'Creating Family Background Info Success';
                    }

                }
            }
        }
    }

    public function getFamilyBackgroundInfos(Request $request){

        // Get Database data

        $familyBackgroundinfos = FamilyBackgroundInfos::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $familyBackgroundinfos;
        }
    }

    public function getDataFamByCaseNo($case_no_modal){

        // Get Database data

        $dataFam = FamilyBackgroundInfos::query()
            ->where('case_no_modal', $case_no_modal)
            ->get();

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");
        

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return compact('dataFam', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved');
        }
    }

    public function getDataFamByID($id){

        // Get Database data

        $dataFam_id = FamilyBackgroundInfos::findOrFail($id);

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $dataFam_id;
        }
    }

    public function addIncidenceDetailInfos(Request $request){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if(str_contains($get_user_master_list_rights, "Add") == false){

                return "Sorry you don't have the rights to add record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed add record was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [

                        'case_no_modal' => 'required',
                        'id_date_int_modal' => 'required',
                        'id_name_intervi_modal' => 'required',
                        'id_pos_desi_int_modal' => 'required',
                        'id_int_part_vio_modal' => 'required_without_all:id_rape_modal,id_traf_per_modal,id_sex_hara_modal,id_chi_abu_modal',
                        'id_ipv_phys_modal' => '',
                        'id_ipv_sexual_modal' => '',
                        'id_ipv_psycho_modal' => '',
                        'id_ipv_econo_modal' => '',
                        'id_rape_modal' => 'required_without_all:id_int_part_vio_modal,id_traf_per_modal,id_sex_hara_modal,id_chi_abu_modal',
                        'id_rape_incest_modal' => '',
                        'id_rape_sta_rape_modal' => '',
                        'id_rape_sex_int_modal' => '',
                        'id_rape_sex_assa_modal' => '',
                        'id_rape_mar_rape_modal' => '',
                        'id_traf_per_modal' => 'required_without_all:id_int_part_vio_modal,id_rape_modal,id_sex_hara_modal,id_chi_abu_modal',
                        'id_traf_per_sex_exp_modal' => '',
                        'id_traf_per_onl_exp_modal' => '',
                        'id_traf_per_others_modal' => '',
                        'id_traf_per_others_spec_modal' => 'required_if:id_traf_per_others_modal,Others',
                        'id_traf_per_forc_lab_modal' => '',
                        'id_traf_per_srem_org_modal' => '',
                        'id_traf_per_prost_modal' => '',
                        'id_sex_hara_modal' => 'required_without_all:id_int_part_vio_modal,id_rape_modal,id_traf_per_modal,id_chi_abu_modal',
                        'id_sex_hara_ver_modal' => '',
                        'id_sex_hara_others_modal' => '',
                        'id_sex_hara_others_spec_modal' => 'required_if:id_sex_hara_others_modal,Others',
                        'id_sex_hara_phys_modal' => '',
                        'id_sex_hara_use_obj_modal' => '',
                        'id_chi_abu_modal' => 'required_without_all:id_int_part_vio_modal,id_rape_modal,id_traf_per_modal,id_sex_hara_modal',
                        'id_chi_abu_efpaccp_modal' => '',
                        'id_chi_abu_lasc_cond_modal' => '',
                        'id_chi_abu_others_modal' => '',
                        'id_chi_abu_others_spec_modal' => 'required_if:id_chi_abu_others_modal,Others',
                        'id_chi_abu_sex_int_modal' => '',
                        'id_chi_abu_phys_abu_modal' => '',
                        'id_descr_inci_modal' => 'required',
                        'id_date_of_inci_modal' => 'required',
                        'id_time_of_inci_modal' => '',
                        'inci_det_house_no_modal' => '',
                        'inci_det_street_modal' => '',
                        'inci_det_region_modal' => 'required',
                        'inci_det_province_modal' => 'required',
                        'inci_det_city_modal' => 'required',
                        'inci_det_barangay_modal' => 'required',
                        'id_pla_of_inci_modal' => 'required',
                        'id_pi_oth_pls_spec_modal' => '',
                        'id_was_inc_perp_onl_modal' => 'required',               
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{
        
                        IncidenceDetailInfos::create([
                            'case_no_modal' => $request->case_no_modal,
                            'id_date_int_modal' => $request->id_date_int_modal,
                            'id_name_intervi_modal' => $request->id_name_intervi_modal,
                            'id_pos_desi_int_modal' => $request->id_pos_desi_int_modal,
                            'id_int_part_vio_modal' => $request->id_int_part_vio_modal,
                            'id_ipv_phys_modal' => $request->id_ipv_phys_modal,
                            'id_ipv_sexual_modal' => $request->id_ipv_sexual_modal,
                            'id_ipv_psycho_modal' => $request->id_ipv_psycho_modal,
                            'id_ipv_econo_modal' => $request->id_ipv_econo_modal,
                            'id_rape_modal' => $request->id_rape_modal,
                            'id_rape_incest_modal' => $request->id_rape_incest_modal,
                            'id_rape_sta_rape_modal' => $request->id_rape_sta_rape_modal,
                            'id_rape_sex_int_modal' => $request->id_rape_sex_int_modal,
                            'id_rape_sex_assa_modal' => $request->id_rape_sex_assa_modal,
                            'id_rape_mar_rape_modal' => $request->id_rape_mar_rape_modal,
                            'id_traf_per_modal' => $request->id_traf_per_modal,
                            'id_traf_per_sex_exp_modal' => $request->id_traf_per_sex_exp_modal,
                            'id_traf_per_onl_exp_modal' => $request->id_traf_per_onl_exp_modal,
                            'id_traf_per_others_modal' => $request->id_traf_per_others_modal,
                            'id_traf_per_others_spec_modal' => $request->id_traf_per_others_spec_modal,
                            'id_traf_per_forc_lab_modal' => $request->id_traf_per_forc_lab_modal,
                            'id_traf_per_srem_org_modal' => $request->id_traf_per_srem_org_modal,
                            'id_traf_per_prost_modal' => $request->id_traf_per_prost_modal,
                            'id_sex_hara_modal' => $request->id_sex_hara_modal,
                            'id_sex_hara_ver_modal' => $request->id_sex_hara_ver_modal,
                            'id_sex_hara_others_modal' => $request->id_sex_hara_others_modal,
                            'id_sex_hara_others_spec_modal' => $request->id_sex_hara_others_spec_modal,
                            'id_sex_hara_phys_modal' => $request->id_sex_hara_phys_modal,
                            'id_sex_hara_use_obj_modal' => $request->id_sex_hara_use_obj_modal,
                            'id_chi_abu_modal' => $request->id_chi_abu_modal,
                            'id_chi_abu_efpaccp_modal' => $request->id_chi_abu_efpaccp_modal,
                            'id_chi_abu_lasc_cond_modal' => $request->id_chi_abu_lasc_cond_modal,
                            'id_chi_abu_others_modal' => $request->id_chi_abu_others_modal,
                            'id_chi_abu_others_spec_modal' => $request->id_chi_abu_others_spec_modal,
                            'id_chi_abu_sex_int_modal' => $request->id_chi_abu_sex_int_modal,
                            'id_chi_abu_phys_abu_modal' => $request->id_chi_abu_phys_abu_modal,
                            'id_descr_inci_modal' => $request->id_descr_inci_modal,
                            'id_date_of_inci_modal' => $request->id_date_of_inci_modal,
                            'id_time_of_inci_modal' => $request->id_time_of_inci_modal,
                            'inci_det_house_no_modal' => $request->inci_det_house_no_modal,
                            'inci_det_street_modal' => $request->inci_det_street_modal,
                            'inci_det_region_modal' => $request->inci_det_region_modal,
                            'inci_det_province_modal' => $request->inci_det_province_modal,
                            'inci_det_city_modal' => $request->inci_det_city_modal,
                            'inci_det_barangay_modal' => $request->inci_det_barangay_modal,
                            'id_pla_of_inci_modal' => $request->id_pla_of_inci_modal,
                            'id_pi_oth_pls_spec_modal' => $request->id_pi_oth_pls_spec_modal,
                            'id_was_inc_perp_onl_modal' => $request->id_was_inc_perp_onl_modal,
                        ]);
        
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $request->case_no_modal,
                            'accountable_user_activity' => 'Create-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
        
                        return 'Creating Incidence Details Info Success';
                    }

                }
            }
        }
    }

    public function getIncidenceDetailInfos(Request $request){

        // Get Database Data

        $incidencedetailinfos = IncidenceDetailInfos::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $incidencedetailinfos;
        }
    }

    public function getDataInciByCaseNo($case_no_modal){

        // Get Database data

        $dataInci = IncidenceDetailInfos::query()
            ->where('case_no_modal', $case_no_modal)
            ->get();

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{
        
            return compact('dataInci', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved');
        }
    }

    public function getDataInciByID($id){

        // Get Database data

        $dataInci_id = IncidenceDetailInfos::findOrFail($id);

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{
        
            return $dataInci_id;
        }
    }

    public function addPerpetratorDetailInfos(Request $request){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if(str_contains($get_user_master_list_rights, "Add") == false){

                return "Sorry you don't have the rights to add record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed add record was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [
    
                        'case_no_modal' => 'required',
                        'perp_d_last_name_modal' => 'required',
                        'perp_d_first_name_modal' => 'required',
                        'perp_d_middle_name_modal' => 'required',
                        'perp_d_extension_name_modal' => '',
                        'perp_d_alias_name_modal' => '',
                        'perp_d_sex_radio_modal' => 'required',
                        'perp_d_birthdate_modal' => 'required',
                        'perp_d_age_modal' => 'required',
                        'perp_d_rel_victim_modal' => 'required',
                        'perp_d_rel_vic_pls_spec_modal' => '',
                        'perp_d_occup_modal' => 'required',
                        'perp_d_educ_att_modal' => 'required',
                        'perp_d_nationality_modal' => 'required',
                        'perp_d_nat_if_oth_pls_spec_modal' => '',
                        'perp_d_religion_modal' => 'required',
                        'perp_d_rel_if_oth_pls_spec_modal' => '',
                        'perp_d_house_no_modal' => '',
                        'perp_d_street_modal' => '',
                        'perp_d_region_modal' => 'required',
                        'perp_d_province_modal' => 'required',
                        'perp_d_city_modal' => 'required',
                        'perp_d_barangay_modal' => 'required',
                        'perp_d_curr_loc_modal' => 'required',
                        'perp_d_is_perp_minor_modal' => 'required',
                        'perp_d_if_yes_pls_ind_modal' => '',
                        'perp_d_addr_par_gua_modal' => 'required',
                        'perp_d_cont_par_gua_modal' => 'required',
                        'perp_d_rel_guar_perp_modal' => 'required',
                        'perp_d_rel_rgp_pls_spec_modal' => '',
                        'perp_d_oth_info_perp_modal' => '',                
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{
        
                        PerpetratorDetailInfos::create([
                            'case_no_modal' => $request->case_no_modal,
                            'perp_d_last_name_modal' => $request->perp_d_last_name_modal,
                            'perp_d_first_name_modal' => $request->perp_d_first_name_modal,
                            'perp_d_middle_name_modal' => $request->perp_d_middle_name_modal,
                            'perp_d_extension_name_modal' => $request->perp_d_extension_name_modal,
                            'perp_d_alias_name_modal' => $request->perp_d_alias_name_modal,
                            'perp_d_sex_radio_modal' => $request->perp_d_sex_radio_modal,
                            'perp_d_birthdate_modal' => $request->perp_d_birthdate_modal,
                            'perp_d_age_modal' => $request->perp_d_age_modal,
                            'perp_d_rel_victim_modal' => $request->perp_d_rel_victim_modal,
                            'perp_d_rel_vic_pls_spec_modal' => $request->perp_d_rel_vic_pls_spec_modal,
                            'perp_d_occup_modal' => $request->perp_d_occup_modal,
                            'perp_d_educ_att_modal' => $request->perp_d_educ_att_modal,
                            'perp_d_nationality_modal' => $request->perp_d_nationality_modal,
                            'perp_d_nat_if_oth_pls_spec_modal' => $request->perp_d_nat_if_oth_pls_spec_modal,
                            'perp_d_religion_modal' => $request->perp_d_religion_modal,
                            'perp_d_rel_if_oth_pls_spec_modal' => $request->perp_d_rel_if_oth_pls_spec_modal,
                            'perp_d_house_no_modal' => $request->perp_d_house_no_modal,
                            'perp_d_street_modal' => $request->perp_d_street_modal,
                            'perp_d_region_modal' => $request->perp_d_region_modal,
                            'perp_d_province_modal' => $request->perp_d_province_modal,
                            'perp_d_city_modal' => $request->perp_d_city_modal,
                            'perp_d_barangay_modal' => $request->perp_d_barangay_modal,
                            'perp_d_curr_loc_modal' => $request->perp_d_curr_loc_modal,
                            'perp_d_is_perp_minor_modal' => $request->perp_d_is_perp_minor_modal,
                            'perp_d_if_yes_pls_ind_modal' => $request->perp_d_if_yes_pls_ind_modal,
                            'perp_d_addr_par_gua_modal' => $request->perp_d_addr_par_gua_modal,
                            'perp_d_cont_par_gua_modal' => $request->perp_d_cont_par_gua_modal,
                            'perp_d_rel_guar_perp_modal' => $request->perp_d_rel_guar_perp_modal,
                            'perp_d_rel_rgp_pls_spec_modal' => $request->perp_d_rel_rgp_pls_spec_modal,
                            'perp_d_oth_info_perp_modal' => $request->perp_d_oth_info_perp_modal,
                        ]);
        
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $request->case_no_modal,
                            'accountable_user_activity' => 'Create-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
        
                        return 'Creating Perpetrator Details Info Success';
                    }

                }
            }
        }

    }

    public function getPerpetratorDetailInfos(Request $request){

        // Get Database data

        $perpetratordetailinfos = PerpetratorDetailInfos::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $perpetratordetailinfos;
        }
    }

    public function getDataPerpetByCaseNo($case_no_modal){

        // Get Database data

        $dataPerpet = PerpetratorDetailInfos::query()
            ->where('case_no_modal', $case_no_modal)
            ->get();

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{
       
            return compact('dataPerpet', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved');
        }
    }

    public function getDataPerpetByID($id){

        // Get Database data

        $dataPerpet_id = PerpetratorDetailInfos::findOrFail($id);

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{
       
            return $dataPerpet_id;
        }
    }

    public function addInterventionModuleInfos(Request $request){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if(str_contains($get_user_master_list_rights, "Add") == false){

                return "Sorry you don't have the rights to add record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed add record was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [
    
                        'case_no_modal' => 'required',
                        'im_type_of_service_modal' => 'required',
                        'im_typ_serv_if_oth_spec_modal' => '',
                        'im_speci_interv_modal' => 'required',
                        'im_spe_int_if_oth_spec_modal' => '',
                        'im_serv_prov_modal' => 'required',
                        'im_ser_pro_if_oth_spec_modal' => '',
                        'im_speci_obje_modal' => 'required',
                        'im_target_date_modal' => 'required',
                        'im_status_modal' => 'required',
                        'im_if_status_com_pd_modal' => 'required_if:im_status_modal,Provided',
                        'im_dsp_full_name_modal' => 'required',
                        'im_dsp_post_desi_modal' => 'required',
                        'im_dsp_email_modal' => 'required|email',
                        'im_dsp_contact_no_1_modal' => 'required',
                        'im_dsp_contact_no_2_modal' => '',
                        'im_dsp_contact_no_3_modal' => '',
                        'im_dasp_full_name_modal' => '',
                        'im_dasp_post_desi_modal' => '',
                        'im_dasp_email_modal' => '',
                        'im_dasp_contact_no_1_modal' => '',
                        'im_dasp_contact_no_2_modal' => '',
                        'im_dasp_contact_no_3_modal' => '',
                        'im_summary_modal' => 'required',                
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{
        
                        InterventionModuleInfos::create([
                            'case_no_modal' => $request->case_no_modal,
                            'im_type_of_service_modal' => $request->im_type_of_service_modal,
                            'im_typ_serv_if_oth_spec_modal' => $request->im_typ_serv_if_oth_spec_modal,
                            'im_speci_interv_modal' => $request->im_speci_interv_modal,
                            'im_spe_int_if_oth_spec_modal' => $request->im_spe_int_if_oth_spec_modal,
                            'im_serv_prov_modal' => $request->im_serv_prov_modal,
                            'im_ser_pro_if_oth_spec_modal' => $request->im_ser_pro_if_oth_spec_modal,
                            'im_speci_obje_modal' => $request->im_speci_obje_modal,
                            'im_target_date_modal' => $request->im_target_date_modal,
                            'im_status_modal' => $request->im_status_modal,
                            'im_if_status_com_pd_modal' => $request->im_if_status_com_pd_modal,
                            'im_dsp_full_name_modal' => $request->im_dsp_full_name_modal,
                            'im_dsp_post_desi_modal' => $request->im_dsp_post_desi_modal,
                            'im_dsp_email_modal' => $request->im_dsp_email_modal,
                            'im_dsp_contact_no_1_modal' => $request->im_dsp_contact_no_1_modal,
                            'im_dsp_contact_no_2_modal' => $request->im_dsp_contact_no_2_modal,
                            'im_dsp_contact_no_3_modal' => $request->im_dsp_contact_no_3_modal,
                            'im_dasp_full_name_modal' => $request->im_dasp_full_name_modal,
                            'im_dasp_post_desi_modal' => $request->im_dasp_post_desi_modal,
                            'im_dasp_email_modal' => $request->im_dasp_email_modal,
                            'im_dasp_contact_no_1_modal' => $request->im_dasp_contact_no_1_modal,
                            'im_dasp_contact_no_2_modal' => $request->im_dasp_contact_no_2_modal,
                            'im_dasp_contact_no_3_modal' => $request->im_dasp_contact_no_3_modal,
                            'im_summary_modal' => $request->im_summary_modal,
                        ]);
        
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $request->case_no_modal,
                            'accountable_user_activity' => 'Create-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
        
                        return 'Creating Intervention Module Info Success';
        
                    }

                }
            }
        }
    }

    public function getInterventionModuleInfos(Request $request){

        // Get Database data

        $interventionmoduleinfos = InterventionModuleInfos::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $interventionmoduleinfos;
        }
    }

    public function getDataInterByCaseNo($case_no_modal){

        // Get Database data

        $dataInter = InterventionModuleInfos::query()
            ->where('case_no_modal', $case_no_modal)
            ->get();

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{
        
            return compact('dataInter', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved');
        }
    }

    public function getDataInterByID($id){

        // Get Database data

        $dataInter_id = InterventionModuleInfos::findOrFail($id);

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{
        
            return $dataInter_id;
        }
    }
    #end modal add record

    public function getCase(Request $request){

        // Get Database data

        $cases = Cases::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $cases;
        }
    }

    public function getPersonalDetailsCase(Request $request){

        // Get Database data

        $personalDetails = PersonalDetails::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $personalDetails;
        }
    }

    public function getFamilyBackgroundsCase(Request $request){

        // Get database data

        $familyBackgrounds = FamilyBackgrounds::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $familyBackgrounds;
        }
    }

    public function getIncidenceDetailsCase(Request $request){

        // Get Database data

        $incidenceDetails = IncidenceDetails::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $incidenceDetails;
        }
    }

    public function getPerpetratorDetailsCase(Request $request){

        // Get Database data

        $perpetratorDetails = PerpetratorDetails::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $perpetratorDetails;
        }
    }

    public function getInterventionModulesCase(Request $request){

        // Get database data

        $interventionModules = InterventionModules::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $interventionModules;
        }
    }

    public function getReferralModulesCase(Request $request){

        // Get Database data

        $referralModules = ReferralModules::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $referralModules;
        }
    }

    public function getCaseModulesCase(Request $request){

        // Get Database data

        $caseModules = CaseModules::all();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $caseModules;
        }
    }

    public function getCreateCasePage(Request $request){

        // Get Database data

        $service_providers = DirectoryType::all();
        $place_of_incidences = PlaceOfIncidences::all();
        $relationship_to_victim_survivors = RelationshipToVictimSurvivors::all();
        $religions = Religions::all();

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        if((str_contains($get_user_page_access, "Master List") == false) || (str_contains($get_user_master_list_rights, "Add") == false)){

            return view('restricted');
        }
        else{

            return view('admin.case_folder.create_case_form', compact('service_providers', 'place_of_incidences', 'relationship_to_victim_survivors', 'religions'));
        }

    }

    public function getCasesPage(Request $request){

        // Get User Area Scoping

        $user_region = Auth::user()->user_region;
        $user_province = Auth::user()->user_province;
        $user_municipality = Auth::user()->user_municipality;
        $user_barangay = Auth::user()->user_barangay;

        // Detect User Role for cases results sorting

        if(str_contains(Auth::user()->role, "Service Provider") == true){

            if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                // Get Database Regional data

                $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->get();
            }
            else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                
                // Get Database Provincial data

                $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->get();
            }
            else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                
                // Get Database Municipal data

                $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
            }
            else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                
                // Get Database Barangay data

                $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();

            }else{
                
                // Get Database National data

                $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->get();
            }
            
        }else{

            if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                // Get Database Regional data

                $cases_paginator = Cases::where('region','=',$user_region)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('region','=',$user_region)->get();
            }
            else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                
                // Get Database Provincial data

                $cases_paginator = Cases::where('region','=',$user_region)->where('province','=',$user_province)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('region','=',$user_region)->where('province','=',$user_province)->get();
            }
            else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                
                // Get Database Municipal data

                $cases_paginator = Cases::where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
            }
            else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                
                // Get Database Barangay data

                $cases_paginator = Cases::where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->orderBy('form_status')->paginate(25);
                $cases = Cases::where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();

            }else{
                
                // Get Database National data

                $cases_paginator = Cases::orderBy('form_status')->paginate(25);
                $cases = Cases::all();
            }

        }

        // Detect Case Manager

        $case_manager = str_contains(Auth::user()->role, "Case Manager");
        
        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            return view('admin.case_folder.master-list', compact('cases', 'cases_paginator', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved', 'case_manager'))->render();
        }
    }

    public function getSearchCasesPage($case_search_option, $case_no_or_last_name_search){

        // Get User Area Scoping

        $user_region = Auth::user()->user_region;
        $user_province = Auth::user()->user_province;
        $user_municipality = Auth::user()->user_municipality;
        $user_barangay = Auth::user()->user_barangay;

        // Detect Case Manager

        $case_manager = str_contains(Auth::user()->role, "Case Manager");

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

        // Detect User Role for cases results sorting

        if(str_contains(Auth::user()->role, "Service Provider") == true){

            // Detect Search Option

            if($case_search_option == 'case-no'){

                if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                    // Get Database Regional data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                    
                    // Get Database Provincial data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                    
                    // Get Database Municipal data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                    
                    // Get Database Barangay data

                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();
    
                }else{
                    
                    // Get Database National data

                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('case_no','=',$case_no_or_last_name_search)->get();
                }

                $query_input = $case_no_or_last_name_search;

                if(str_contains($get_user_page_access, "Master List") == false){

                    return view('restricted');
                }
                else{

                    return view('admin.case_folder.search_cases', compact('cases', 'cases_paginator', 'query_input', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved', 'case_manager'))->render();
                }

            }elseif($case_search_option == 'last-name'){

                if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                    // Get Database Regional data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                    
                    // Get Database Provincial data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                    
                    // Get Database Municipal data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                    
                    // Get Database Barangay data

                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();
    
                }else{
                    
                    // Get Database National data

                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('last_name','=',$case_no_or_last_name_search)->get();
                }
                
                $query_input = $case_no_or_last_name_search;

                if(str_contains($get_user_page_access, "Master List") == false){

                    return view('restricted');
                }
                else{

                    return view('admin.case_folder.search_cases', compact('cases', 'cases_paginator', 'query_input', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved', 'case_manager'))->render();
                }

            }else{

                if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                    // Get Database Regional data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                    
                    // Get Database Provincial data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                    
                    // Get Database Municipal data
    
                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                    
                    // Get Database Barangay data

                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();

                }else{
                    
                    // Get Database National data

                    $cases_paginator = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->orderBy('form_status')->paginate(25);
                    $cases = Cases::where('im_serv_prov','=',Auth::user()->user_service_provider)->get();
                }

                $query_input = $case_no_or_last_name_search;

                if(str_contains($get_user_page_access, "Master List") == false){

                    return view('restricted');
                }
                else{

                    return view('admin.case_folder.search_cases', compact('cases', 'cases_paginator', 'query_input', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved', 'case_manager'))->render();
                }
            }

        }else{

            // Detect Search Option

            if($case_search_option == 'case-no'){

                if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                    // Get Database Regional data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->paginate(25);
                    $cases = Cases::where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                    
                    // Get Database Provincial data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->paginate(25);
                    $cases = Cases::where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                    
                    // Get Database Municipal data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->paginate(25);
                    $cases = Cases::where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                    
                    // Get Database Barangay data

                    $cases_paginator = Cases::orderBy('form_status')->where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->paginate(25);
                    $cases = Cases::where('case_no','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();

                }else{
                    
                    // Get Database National data

                    $cases_paginator = Cases::orderBy('form_status')->where('case_no','=',$case_no_or_last_name_search)->paginate(25);
                    $cases = Cases::where('case_no','=',$case_no_or_last_name_search)->get();
                }
                
                $query_input = $case_no_or_last_name_search;
    
                if(str_contains($get_user_page_access, "Master List") == false){
    
                    return view('restricted');
                }
                else{
    
                    return view('admin.case_folder.search_cases', compact('cases', 'cases_paginator', 'query_input', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved', 'case_manager'))->render();
                }
            
            }elseif($case_search_option == 'last-name'){

                if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                    // Get Database Regional data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->paginate(25);
                    $cases = Cases::where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                    
                    // Get Database Provincial data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->paginate(25);
                    $cases = Cases::where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                    
                    // Get Database Municipal data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->paginate(25);
                    $cases = Cases::where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                    
                    // Get Database Barangay data

                    $cases_paginator = Cases::orderBy('form_status')->where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->paginate(25);
                    $cases = Cases::where('last_name','=',$case_no_or_last_name_search)->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();

                }else{
                    
                    // Get Database National data

                    $cases_paginator = Cases::orderBy('form_status')->where('last_name','=',$case_no_or_last_name_search)->paginate(25);
                    $cases = Cases::where('last_name','=',$case_no_or_last_name_search)->get();
                }

                $query_input = $case_no_or_last_name_search;

                if(str_contains($get_user_page_access, "Master List") == false){

                    return view('restricted');
                }
                else{

                    return view('admin.case_folder.search_cases', compact('cases', 'cases_paginator', 'query_input', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved', 'case_manager'))->render();
                }
           
            }else{

                if(($user_region != null) && ($user_province == null) && ($user_municipality == null) && ($user_barangay == null)){
                
                    // Get Database Regional data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('region','=',$user_region)->paginate(25);
                    $cases = Cases::where('region','=',$user_region)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality == null) && ($user_barangay == null)){
                    
                    // Get Database Provincial data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('region','=',$user_region)->where('province','=',$user_province)->paginate(25);
                    $cases = Cases::where('region','=',$user_region)->where('province','=',$user_province)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay == null)){
                    
                    // Get Database Municipal data
    
                    $cases_paginator = Cases::orderBy('form_status')->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->paginate(25);
                    $cases = Cases::where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->get();
                }
                else if(($user_region != null) && ($user_province != null) && ($user_municipality != null) && ($user_barangay != null)){
                    
                    // Get Database Barangay data

                    $cases_paginator = Cases::orderBy('form_status')->where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->paginate(25);
                    $cases = Cases::where('region','=',$user_region)->where('province','=',$user_province)->where('city','=',$user_municipality)->where('barangay','=',$user_barangay)->get();

                }else{
                    
                    // Get Database National data

                    $cases_paginator = Cases::orderBy('form_status')->paginate(25);
                    $cases = Cases::all();
                }

                $query_input = $case_no_or_last_name_search;

                if(str_contains($get_user_page_access, "Master List") == false){

                    return view('restricted');
                }
                else{

                    return view('admin.case_folder.search_cases', compact('cases', 'cases_paginator', 'query_input', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved', 'case_manager'))->render();
                }
            }

        }
        
    }


    public function getCaseByID(Request $request){

        $caseid = Cases::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $caseid;

        }
    }

    public function validateCaseNo($case_no){

         // Get Database data

        $case_no_list = json_encode(Cases::where('case_no','=',$case_no)->get());

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if($case_no_list != '[]'){

                return 'Case No. already exists on the database';
                
            }else{

                return 'Case No. can be added';
            }

            return $case_no_list;
    
        }
    }

    public function getPersonalDetailsCaseByID(Request $request){

        // Get Database data

        $personalDetails = PersonalDetails::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $personalDetails;
        }
    }

    public function getFamilyBackgroundsCaseByID(Request $request){

        // Get Database data

        $familyBackgrounds = FamilyBackgrounds::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $familyBackgrounds;
        }
    }

    public function getIncidenceDetailsCaseByID(Request $request){

        // Get Database data

        $incidenceDetails = IncidenceDetails::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $incidenceDetails;
        }
    }

    public function getPerpetratorDetailsCaseByID(Request $request){

        // Get Database data

        $perpetratorDetails = PerpetratorDetails::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $perpetratorDetails;
        }
    }

    public function getInterventionModulesCaseByID(Request $request){

        // Get Database data

        $interventionModules = InterventionModules::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $interventionModules;
        }
    }

    public function getReferralModulesCaseByID(Request $request){

        // Get Database data

        $referralModules = ReferralModules::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $referralModules;
        }
    }

    public function getCaseModulesCaseByID(Request $request){

        // Get Database data

        $caseModules = CaseModules::query()->where('id', $request->id)->first();

        // Detect User Role Page Access for Page Restriction

        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            return $caseModules;
        }
    }

    public function editCaseform($case_no){
        
        // Get Database data
        
        $editcaseformPerso = PersonalDetails::where('case_no','=',$case_no)->get();
        $editcaseformFambac = FamilyBackgrounds::where('case_no','=',$case_no)->get();
        $editcaseformInci = IncidenceDetails::where('case_no','=',$case_no)->get();
        $editcaseformPerpet = PerpetratorDetails::where('case_no','=',$case_no)->get();
        $editcaseformInter = InterventionModules::where('case_no','=',$case_no)->get();
        $editcaseformRefer = ReferralModules::where('case_no','=',$case_no)->get();
        $editcaseformCaseMod = CaseModules::where('case_no','=',$case_no)->get();
        $service_providers = DirectoryType::all();
        $place_of_incidences = PlaceOfIncidences::all();
        $relationship_to_victim_survivors = RelationshipToVictimSurvivors::all();
        $religions = Religions::all();
        $family_background_infos = FamilyBackgroundInfos::where('case_no_modal','=',$case_no)->get();
        $incidence_detail_infos = IncidenceDetailInfos::where('case_no_modal','=',$case_no)->get();
        $perpetrator_detail_infos = PerpetratorDetailInfos::where('case_no_modal','=',$case_no)->get();
        $intervention_module_infos = InterventionModuleInfos::where('case_no_modal','=',$case_no)->get();
        $cases_users_activity_logs_accountable_user_usernames = CasesUsersActivityLogs::where('subject_case_no','=',$case_no)->select('accountable_user_username')->distinct()->get();
        $cases_details = Cases::where('case_no','=',$case_no)->get();

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            return view('admin.case_folder.edit_create_case_form', compact('editcaseformPerso', 'editcaseformFambac', 'editcaseformInci', 'editcaseformPerpet', 'editcaseformInter', 'editcaseformRefer', 'editcaseformCaseMod', 'service_providers', 'place_of_incidences', 'relationship_to_victim_survivors', 'religions', 'family_background_infos', 'incidence_detail_infos', 'perpetrator_detail_infos', 'intervention_module_infos', 'cases_users_activity_logs_accountable_user_usernames', 'cases_details', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved'));
        }
    }

    public function viewCaseform($case_no){
        
        // Get Database data
        
        $viewcaseformPerso = PersonalDetails::where('case_no','=',$case_no)->get();
        $viewcaseformFambac = FamilyBackgrounds::where('case_no','=',$case_no)->get();
        $viewcaseformInci = IncidenceDetails::where('case_no','=',$case_no)->get();
        $viewcaseformPerpet = PerpetratorDetails::where('case_no','=',$case_no)->get();
        $viewcaseformInter = InterventionModules::where('case_no','=',$case_no)->get();
        $viewcaseformRefer = ReferralModules::where('case_no','=',$case_no)->get();
        $viewcaseformCaseMod = CaseModules::where('case_no','=',$case_no)->get();
        $service_providers = DirectoryType::all();
        $place_of_incidences = PlaceOfIncidences::all();
        $relationship_to_victim_survivors = RelationshipToVictimSurvivors::all();
        $religions = Religions::all();
        $family_background_infos = FamilyBackgroundInfos::where('case_no_modal','=',$case_no)->get();
        $incidence_detail_infos = IncidenceDetailInfos::where('case_no_modal','=',$case_no)->get();
        $perpetrator_detail_infos = PerpetratorDetailInfos::where('case_no_modal','=',$case_no)->get();
        $intervention_module_infos = InterventionModuleInfos::where('case_no_modal','=',$case_no)->get();
        $cases_users_activity_logs_accountable_user_usernames = CasesUsersActivityLogs::where('subject_case_no','=',$case_no)->select('accountable_user_username')->distinct()->get();
        $cases_details = Cases::where('case_no','=',$case_no)->get();

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            return view('admin.case_folder.view_create_case_form', compact('viewcaseformPerso', 'viewcaseformFambac', 'viewcaseformInci', 'viewcaseformPerpet', 'viewcaseformInter', 'viewcaseformRefer', 'viewcaseformCaseMod', 'service_providers', 'place_of_incidences', 'relationship_to_victim_survivors', 'religions', 'family_background_infos', 'incidence_detail_infos', 'perpetrator_detail_infos', 'intervention_module_infos', 'cases_users_activity_logs_accountable_user_usernames', 'cases_details'));
        }
    }

    public function updateCaseform(Request $request, $case_no){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($case_no) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$case_no];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Revise") == false){

                return "Sorry you don't have the rights to update this case please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed editing was disabled';
    
                }else{

                    if($request->form_status == 'Submitted'){

                        $validator = Validator::make(

                            array(
    
                                // Personal Details
            
                                'client_made_a_report_before' => $request->client_made_a_report_before,
                                'date_of_intake' => $request->date_of_intake,
                                'type_of_client' => $request->type_of_client,
                                'last_name' => $request->last_name,
                                'first_name' => $request->first_name,
                                'middle_name' => $request->middle_name,
                                'birth_date' => $request->birth_date,
                                'sex' => $request->sex,
                                'extension_name' => $request->extension_name,
                                'alias_name' => $request->alias_name,
                                'age' => $request->age,
                                'client_diverse_sogie' => $request->client_diverse_sogie,
                                'civil_status' => $request->civil_status,
                                'education' => $request->education,
                                'religion' => $request->religion,
                                'religion_if_oth_pls_spec' => $request->religion_if_oth_pls_spec,
                                'nationality' => $request->nationality,
                                'nationality_if_oth_pls_spec' => $request->nationality_if_oth_pls_spec,
                                'ethnicity' => $request->ethnicity,
                                'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,
                                'employment_status' => $request->employment_status,
                                'if_self_emp_pls_ind' => $request->if_self_emp_pls_ind,
                                'house_hold_no' => $request->house_hold_no,
                                'region' => $request->region,
                                'province' => $request->province,
                                'city' => $request->city,
                                'barangay' => $request->barangay,
                                'street' => $request->street,
                                'is_idp' => $request->is_idp,
                                'is_pwd' => $request->is_pwd,
                                'if_pwd_pls_specify' => $request->if_pwd_pls_specify,
                                'per_det_cont_info' => $request->per_det_cont_info,
            
                                // Family Background
            
                                'name_par_guar' => $request->name_par_guar,
                                'job_vict_sur' => $request->job_vict_sur,
                                'age_vict_sur' => $request->age_vict_sur,
                                'rel_vict_sur' => $request->rel_vict_sur,
                                'rttvs_if_oth_pls_spec' => $request->rttvs_if_oth_pls_spec,
                                'fam_back_region' => $request->fam_back_region,
                                'fam_back_province' => $request->fam_back_province,
                                'fam_back_city' => $request->fam_back_city,
                                'fam_back_barangay' => $request->fam_back_barangay,
                                'fam_back_house_no' => $request->fam_back_house_no,
                                'fam_back_street' => $request->fam_back_street,
                                'fam_back_cont_num' => $request->fam_back_cont_num,
            
                                // Incidence Details
            
                                'id_date_int' => $request->id_date_int,
                                'id_name_intervi' => $request->id_name_intervi,
                                'id_pos_desi_int' => $request->id_pos_desi_int,
                                'id_int_part_vio' => $request->id_int_part_vio,
                                'id_int_part_vio_sub_opt' => $request->id_ipv_phys.$request->id_ipv_sexual.$request->id_ipv_psycho.$request->id_ipv_econo,
                                'id_rape' => $request->id_rape,
                                'id_rape_sub_opt' => $request->id_rape_incest.$request->id_rape_sta_rape.$request->id_rape_sex_int.$request->id_rape_sex_assa.$request->id_rape_mar_rape,
                                'id_traf_per' => $request->id_traf_per,
                                'id_traf_per_sub_opt' => $request->id_traf_per_sex_exp.$request->id_traf_per_onl_exp.$request->id_traf_per_others.$request->id_traf_per_forc_lab.$request->id_traf_per_srem_org.$request->id_traf_per_prost,
                                'id_traf_per_others' => $request->id_traf_per_others,
                                'id_traf_per_others_spec' => $request->id_traf_per_others_spec,
                                'id_sex_hara' => $request->id_sex_hara,
                                'id_sex_hara_sub_opt' => $request->id_sex_hara_ver.$request->id_sex_hara_others.$request->id_sex_hara_phys.$request->id_sex_hara_use_obj,
                                'id_sex_hara_others' => $request->id_sex_hara_others,
                                'id_sex_hara_others_spec' => $request->id_sex_hara_others_spec,
                                'id_chi_abu' => $request->id_chi_abu,
                                'id_chi_abu_sub_opt' => $request->id_chi_abu_efpaccp.$request->id_chi_abu_lasc_cond.$request->id_chi_abu_others.$request->id_chi_abu_sex_int.$request->id_chi_abu_phys_abu,
                                'id_chi_abu_others' => $request->id_chi_abu_others,
                                'id_chi_abu_others_spec' => $request->id_chi_abu_others_spec,
                                'id_descr_inci' => $request->id_descr_inci,
                                'id_date_of_inci' => $request->id_date_of_inci,
                                'id_time_of_inci' => $request->id_time_of_inci,
                                'inci_det_house_no' => $request->inci_det_house_no,
                                'inci_det_street' => $request->inci_det_street,
                                'inci_det_region' => $request->inci_det_region,
                                'inci_det_province' => $request->inci_det_province,
                                'inci_det_city' => $request->inci_det_city,
                                'inci_det_barangay' => $request->inci_det_barangay,
                                'id_pla_of_inci' => $request->id_pla_of_inci,
                                'id_pi_oth_pls_spec' => $request->id_pi_oth_pls_spec,
                                'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
            
                                // Perpetrator Details
                                
                                'perp_d_last_name' => $request->perp_d_last_name,
                                'perp_d_first_name' => $request->perp_d_first_name,
                                'perp_d_middle_name' => $request->perp_d_middle_name,
                                'perp_d_extension_name' => $request->perp_d_extension_name,
                                'perp_d_alias_name' => $request->perp_d_alias_name,
                                'perp_d_sex_radio' => $request->perp_d_sex_radio,
                                'perp_d_birthdate' => $request->perp_d_birthdate,
                                'perp_d_age' => $request->perp_d_age,
                                'perp_d_rel_victim' => $request->perp_d_rel_victim,
                                'perp_d_rel_vic_pls_spec' => $request->perp_d_rel_vic_pls_spec,
                                'perp_d_occup' => $request->perp_d_occup,
                                'perp_d_educ_att' => $request->perp_d_educ_att,
                                'perp_d_nationality' => $request->perp_d_nationality,
                                'perp_d_nat_if_oth_pls_spec' => $request->perp_d_nat_if_oth_pls_spec,
                                'perp_d_religion' => $request->perp_d_religion,
                                'perp_d_rel_if_oth_pls_spec' => $request->perp_d_rel_if_oth_pls_spec,
                                'perp_d_house_no' => $request->perp_d_house_no,
                                'perp_d_street' => $request->perp_d_street,
                                'perp_d_region' => $request->perp_d_region,
                                'perp_d_province' => $request->perp_d_province,
                                'perp_d_city' => $request->perp_d_city,
                                'perp_d_barangay' => $request->perp_d_barangay,
                                'perp_d_curr_loc' => $request->perp_d_curr_loc,
                                'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                                'perp_d_if_yes_pls_ind' => $request->perp_d_if_yes_pls_ind,
                                'perp_d_addr_par_gua' => $request->perp_d_addr_par_gua,
                                'perp_d_cont_par_gua' => $request->perp_d_cont_par_gua,
                                'perp_d_rel_guar_perp' => $request->perp_d_rel_guar_perp,
                                'perp_d_rel_rgp_pls_spec' => $request->perp_d_rel_rgp_pls_spec,
                                'perp_d_oth_info_perp' => $request->perp_d_oth_info_perp,
            
                                // Intervention Module
            
                                'im_type_of_service' => $request->im_type_of_service,
                                'im_typ_serv_if_oth_spec' => $request->im_typ_serv_if_oth_spec,
                                'im_speci_interv' => $request->im_speci_interv,
                                'im_spe_int_if_oth_spec' => $request->im_spe_int_if_oth_spec,
                                'im_serv_prov' => $request->im_serv_prov,
                                'im_ser_pro_if_oth_spec' => $request->im_ser_pro_if_oth_spec,
                                'im_speci_obje' => $request->im_speci_obje,
                                'im_target_date' => $request->im_target_date,
                                'im_status' => $request->im_status,
                                'im_if_status_com_pd' => $request->im_if_status_com_pd,
                                'im_dsp_full_name' => $request->im_dsp_full_name,
                                'im_dsp_post_desi' => $request->im_dsp_post_desi,
                                'im_dsp_email' => $request->im_dsp_email,
                                'im_dsp_contact_no_1' => $request->im_dsp_contact_no_1,
                                'im_dsp_contact_no_2' => $request->im_dsp_contact_no_2,
                                'im_dsp_contact_no_3' => $request->im_dsp_contact_no_3,
                                'im_dasp_full_name' => $request->im_dasp_full_name,
                                'im_dasp_post_desi' => $request->im_dasp_post_desi,
                                'im_dasp_email' => $request->im_dasp_email,
                                'im_dasp_contact_no_1' => $request->im_dasp_contact_no_1,
                                'im_dasp_contact_no_2' => $request->im_dasp_contact_no_2,
                                'im_dasp_contact_no_3' => $request->im_dasp_contact_no_3,
                                'im_summary' => $request->im_summary,
            
                                // Referral Module
            
                                'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                                'rm_name_ref_org' => $request->rm_name_ref_org,
                                'rm_ref_fro_ref_org' => $request->rm_ref_fro_ref_org,
                                'rm_addr_ref_org' => $request->rm_addr_ref_org,
                                'rm_referred_by' => $request->rm_referred_by,
                                'rm_position_title' => $request->rm_position_title,
                                'rm_contact_no' => $request->rm_contact_no,
                                'rm_email_add' => $request->rm_email_add,
            
                                // Case Module
            
                                'cm_case_status' => $request->cm_case_status,
                                'cm_assessment' => $request->cm_assessment,
                                'cm_recommendation' => $request->cm_recommendation,
                                'cm_remarks' => $request->cm_remarks,
    
                            ),
    
                            array(
        
                                // Personal Details
            
                                'client_made_a_report_before' => '',
                                'date_of_intake' => 'required',
                                'type_of_client' => 'required',
                                'last_name' => 'required',
                                'first_name' => 'required',
                                'middle_name' => 'required',
                                'birth_date' => 'required',
                                'sex' => 'required',
                                'extension_name' => '',
                                'alias_name' => '',
                                'age' => 'required',
                                'client_diverse_sogie' => 'required',
                                'civil_status' => 'required',
                                'education' => 'required',
                                'religion' => 'required',
                                'religion_if_oth_pls_spec' => '',
                                'nationality' => 'required',
                                'nationality_if_oth_pls_spec' => '',
                                'ethnicity' => 'required',
                                'ethnicity_if_oth_pls_spec' => '',
                                'employment_status' => 'required',
                                'if_self_emp_pls_ind' => '',
                                'house_hold_no' => '',
                                'region' => 'required',
                                'province' => 'required',
                                'city' => 'required',
                                'barangay' => 'required',
                                'street' => '',
                                'is_idp' => 'required',
                                'is_pwd' => 'required',
                                'if_pwd_pls_specify' => '',
                                'per_det_cont_info' => 'required',
            
                                // Family Background
            
                                'name_par_guar' => 'required',
                                'job_vict_sur' => 'required',
                                'age_vict_sur' => 'required',
                                'rel_vict_sur' => 'required',
                                'rttvs_if_oth_pls_spec' => '',
                                'fam_back_region' => 'required',
                                'fam_back_province' => 'required',
                                'fam_back_city' => 'required',
                                'fam_back_barangay' => 'required',
                                'fam_back_house_no' => '',
                                'fam_back_street' => '',
                                'fam_back_cont_num' => 'required',
            
                                // Incidence Details
            
                                'id_date_int' => 'required',
                                'id_name_intervi' => 'required',
                                'id_pos_desi_int' => 'required',
                                'id_int_part_vio' => 'required_without_all:id_rape,id_traf_per,id_sex_hara,id_chi_abu|required_with:id_int_part_vio_sub_opt',
                                'id_int_part_vio_sub_opt' => 'required_with:id_int_part_vio',
                                'id_rape' => 'required_without_all:id_int_part_vio,id_traf_per,id_sex_hara,id_chi_abu|required_with:id_rape_sub_opt',
                                'id_rape_sub_opt' => 'required_with:id_rape',
                                'id_traf_per' => 'required_without_all:id_int_part_vio,id_rape,id_sex_hara,id_chi_abu|required_with:id_traf_per_sub_opt',
                                'id_traf_per_sub_opt' => 'required_with:id_traf_per',
                                'id_traf_per_others' => '',
                                'id_traf_per_others_spec' => 'required_if:id_traf_per_others,Others',
                                'id_sex_hara' => 'required_without_all:id_int_part_vio,id_rape,id_traf_per,id_chi_abu|required_with:id_sex_hara_sub_opt',
                                'id_sex_hara_sub_opt' => 'required_with:id_sex_hara',
                                'id_sex_hara_others' => '',
                                'id_sex_hara_others_spec' => 'required_if:id_sex_hara_others,Others',
                                'id_chi_abu' => 'required_without_all:id_int_part_vio,id_rape,id_traf_per,id_sex_hara|required_with:id_chi_abu_sub_opt',
                                'id_chi_abu_sub_opt' => 'required_with:id_chi_abu',
                                'id_chi_abu_others' => '',
                                'id_chi_abu_others_spec' => 'required_if:id_chi_abu_others,Others',
                                'id_descr_inci' => 'required',
                                'id_date_of_inci' => 'required',
                                'id_time_of_inci' => '',
                                'inci_det_house_no' => '',
                                'inci_det_street' => '',
                                'inci_det_region' => 'required',
                                'inci_det_province' => 'required',
                                'inci_det_city' => 'required',
                                'inci_det_barangay' => 'required',
                                'id_pla_of_inci' => 'required',
                                'id_pi_oth_pls_spec' => '',
                                'id_was_inc_perp_onl' => 'required',
            
                                // Perpetrator Details
                                
                                'perp_d_last_name' => 'required',
                                'perp_d_first_name' => 'required',
                                'perp_d_middle_name' => 'required',
                                'perp_d_extension_name' => '',
                                'perp_d_alias_name' => '',
                                'perp_d_sex_radio' => 'required',
                                'perp_d_birthdate' => 'required',
                                'perp_d_age' => 'required',
                                'perp_d_rel_victim' => 'required',
                                'perp_d_rel_vic_pls_spec' => '',
                                'perp_d_occup' => 'required',
                                'perp_d_educ_att' => 'required',
                                'perp_d_nationality' => 'required',
                                'perp_d_nat_if_oth_pls_spec' => '',
                                'perp_d_religion' => 'required',
                                'perp_d_rel_if_oth_pls_spec' => '',
                                'perp_d_house_no' => '',
                                'perp_d_street' => '',
                                'perp_d_region' => 'required',
                                'perp_d_province' => 'required',
                                'perp_d_city' => 'required',
                                'perp_d_barangay' => 'required',
                                'perp_d_curr_loc' => 'required',
                                'perp_d_is_perp_minor' => 'required',
                                'perp_d_if_yes_pls_ind' => '',
                                'perp_d_addr_par_gua' => 'required',
                                'perp_d_cont_par_gua' => 'required',
                                'perp_d_rel_guar_perp' => 'required',
                                'perp_d_rel_rgp_pls_spec' => '',
                                'perp_d_oth_info_perp' => '',
            
                                // Intervention Module
            
                                'im_type_of_service' => 'required',
                                'im_typ_serv_if_oth_spec' => '',
                                'im_speci_interv' => 'required',
                                'im_spe_int_if_oth_spec' => '',
                                'im_serv_prov' => 'required',
                                'im_ser_pro_if_oth_spec' => '',
                                'im_speci_obje' => 'required',
                                'im_target_date' => 'required',
                                'im_status' => 'required',
                                'im_if_status_com_pd' => 'required_if:im_status,Provided',
                                'im_dsp_full_name' => 'required',
                                'im_dsp_post_desi' => 'required',
                                'im_dsp_email' => 'required',
                                'im_dsp_contact_no_1' => 'required',
                                'im_dsp_contact_no_2' => '',
                                'im_dsp_contact_no_3' => '',
                                'im_dasp_full_name' => '',
                                'im_dasp_post_desi' => '',
                                'im_dasp_email' => '',
                                'im_dasp_contact_no_1' => '',
                                'im_dasp_contact_no_2' => '',
                                'im_dasp_contact_no_3' => '',
                                'im_summary' => 'required',
            
                                // Referral Module
            
                                'rm_was_cli_ref_by_org' => 'required',
                                'rm_name_ref_org' => 'required_if:rm_was_cli_ref_by_org,Yes',
                                'rm_ref_fro_ref_org' => 'required_if:rm_was_cli_ref_by_org,Yes',
                                'rm_addr_ref_org' => 'required_if:rm_was_cli_ref_by_org,Yes',
                                'rm_referred_by' => 'required_if:rm_was_cli_ref_by_org,Yes',
                                'rm_position_title' => 'required_if:rm_was_cli_ref_by_org,Yes',
                                'rm_contact_no' => 'required_if:rm_was_cli_ref_by_org,Yes',
                                'rm_email_add' => 'required_if:rm_was_cli_ref_by_org,Yes',
            
                                // Case Module
            
                                'cm_case_status' => 'required',
                                'cm_assessment' => 'required',
                                'cm_recommendation' => 'required',
                                'cm_remarks' => 'required',
    
                            )
             
                        );
            
                        if ($validator->fails()){
            
                            $errors = $validator->errors();
            
                            return $errors;
            
                        }else{
            
                            Cases::where('case_no','=',$case_no)->update(
        
                                array(
                    
                                    'last_name' => $request->last_name,
                                    'first_name' => $request->first_name,
                                    'middle_name' => $request->middle_name,
                                    'date_of_intake' => $request->date_of_intake,
                                    'im_serv_prov' => $request->im_serv_prov,
                                    'form_status' => $request->form_status,
                                    'cm_case_status' => $request->cm_case_status,
                                    'region' => $request->region,
                                    'province' => $request->province,
                                    'city' => $request->city,
                                    'barangay' => $request->barangay,
                                    'client_made_a_report_before' => $request->client_made_a_report_before,
                                    'age' => $request->age,
                                    'sex' => $request->sex,
                                    'civil_status' => $request->civil_status,
                                    'client_diverse_sogie' => $request->client_diverse_sogie,
                                    'education' => $request->education,
                                    'religion' => $request->religion,
                                    'ethnicity' => $request->ethnicity,
                                    'nationality' => $request->nationality,
                                    'is_idp' => $request->is_idp,
                                    'is_pwd' => $request->is_pwd,
                                    'age_vict_sur' => $request->age_vict_sur,
                                    'nature_of_incidence' => CaseController::putSeparator($request->id_int_part_vio).CaseController::putSeparator($request->id_rape).CaseController::putSeparator($request->id_traf_per).CaseController::putSeparator($request->id_sex_hara).CaseController::putSeparator($request->id_chi_abu),
                                    'sub_option_of_nature_of_incidence' => CaseController::putSeparator($request->id_ipv_phys).CaseController::putSeparator($request->id_ipv_sexual).CaseController::putSeparator($request->id_ipv_psycho).CaseController::putSeparator($request->id_ipv_econo).CaseController::putSeparator($request->id_rape_incest).CaseController::putSeparator($request->id_rape_sta_rape).CaseController::putSeparator($request->id_rape_sex_int).CaseController::putSeparator($request->id_rape_sex_assa).CaseController::putSeparator($request->id_rape_mar_rape).CaseController::putSeparator($request->id_traf_per_sex_exp).CaseController::putSeparator($request->id_traf_per_onl_exp).CaseController::putSeparator($request->id_traf_per_others).CaseController::putSeparator($request->id_traf_per_others_spec).CaseController::putSeparator($request->id_traf_per_forc_lab).CaseController::putSeparator($request->id_traf_per_srem_org).CaseController::putSeparator($request->id_traf_per_prost).CaseController::putSeparator($request->id_sex_hara_ver).CaseController::putSeparator($request->id_sex_hara_others).CaseController::putSeparator($request->id_sex_hara_others_spec).CaseController::putSeparator($request->id_sex_hara_phys).CaseController::putSeparator($request->id_sex_hara_use_obj).CaseController::putSeparator($request->id_chi_abu_efpaccp).CaseController::putSeparator($request->id_chi_abu_lasc_cond).CaseController::putSeparator($request->id_chi_abu_others).CaseController::putSeparator($request->id_chi_abu_others_spec).CaseController::putSeparator($request->id_chi_abu_sex_int).CaseController::putSeparator($request->id_chi_abu_phys_abu),
                                    'id_pla_of_inci' => $request->id_pla_of_inci,
                                    'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                                    'perp_d_age' => $request->perp_d_age,
                                    'perp_d_sex_radio' => $request->perp_d_sex_radio,
                                    'perp_d_rel_victim' => $request->perp_d_rel_victim,
                                    'perp_d_occup' => $request->perp_d_occup,
                                    'perp_d_nationality' => $request->perp_d_nationality,
                                    'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                                    'im_type_of_service' => $request->im_type_of_service,
                                    'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                                    'type_of_client' => $request->type_of_client,
                                    'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,

                                )
                            );
                    
                            PersonalDetails::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'client_made_a_report_before' => $request->client_made_a_report_before,
                                    'date_of_intake' => $request->date_of_intake,
                                    'type_of_client' => $request->type_of_client,
                                    'last_name' => $request->last_name,
                                    'first_name' => $request->first_name,
                                    'middle_name' => $request->middle_name,
                                    'birth_date' => $request->birth_date,
                                    'sex' => $request->sex,
                                    'extension_name' => $request->extension_name,
                                    'alias_name' => $request->alias_name,
                                    'age' => $request->age,
                                    'client_diverse_sogie' => $request->client_diverse_sogie,
                                    'civil_status' => $request->civil_status,
                                    'education' => $request->education,
                                    'religion' => $request->religion,
                                    'religion_if_oth_pls_spec' => $request->religion_if_oth_pls_spec,
                                    'nationality' => $request->nationality,
                                    'nationality_if_oth_pls_spec' => $request->nationality_if_oth_pls_spec,
                                    'ethnicity' => $request->ethnicity,
                                    'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,
                                    'employment_status' => $request->employment_status,
                                    'if_self_emp_pls_ind' => $request->if_self_emp_pls_ind,
                                    'house_hold_no' => $request->house_hold_no,
                                    'region' => $request->region,
                                    'province' => $request->province,
                                    'city' => $request->city,
                                    'barangay' => $request->barangay,
                                    'street' => $request->street,
                                    'is_idp' => $request->is_idp,
                                    'is_pwd' => $request->is_pwd,
                                    'if_pwd_pls_specify' => $request->if_pwd_pls_specify,
                                    'per_det_cont_info' => $request->per_det_cont_info,
                    
                                )
                            );
                    
                            FamilyBackgrounds::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'name_par_guar' => $request->name_par_guar,
                                    'job_vict_sur' => $request->job_vict_sur,
                                    'age_vict_sur' => $request->age_vict_sur,
                                    'rel_vict_sur' => $request->rel_vict_sur,
                                    'rttvs_if_oth_pls_spec' => $request->rttvs_if_oth_pls_spec,
                                    'fam_back_region' => $request->fam_back_region,
                                    'fam_back_province' => $request->fam_back_province,
                                    'fam_back_city' => $request->fam_back_city,
                                    'fam_back_barangay' => $request->fam_back_barangay,
                                    'fam_back_house_no' => $request->fam_back_house_no,
                                    'fam_back_street' => $request->fam_back_street,
                                    'fam_back_cont_num' => $request->fam_back_cont_num,
                                    
                                )
                            );
                    
                            IncidenceDetails::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'id_date_int' => $request->id_date_int,
                                    'id_name_intervi' => $request->id_name_intervi,
                                    'id_pos_desi_int' => $request->id_pos_desi_int,
                                    'id_int_part_vio' => $request->id_int_part_vio,
                                    'id_ipv_phys' => $request->id_ipv_phys,
                                    'id_ipv_sexual' => $request->id_ipv_sexual,
                                    'id_ipv_psycho' => $request->id_ipv_psycho,
                                    'id_ipv_econo' => $request->id_ipv_econo,
                                    'id_rape' => $request->id_rape,
                                    'id_rape_incest' => $request->id_rape_incest,
                                    'id_rape_sta_rape' => $request->id_rape_sta_rape,
                                    'id_rape_sex_int' => $request->id_rape_sex_int,
                                    'id_rape_sex_assa' => $request->id_rape_sex_assa,
                                    'id_rape_mar_rape' => $request->id_rape_mar_rape,
                                    'id_traf_per' => $request->id_traf_per,
                                    'id_traf_per_sex_exp' => $request->id_traf_per_sex_exp,
                                    'id_traf_per_onl_exp' => $request->id_traf_per_onl_exp,
                                    'id_traf_per_others' => $request->id_traf_per_others,
                                    'id_traf_per_others_spec' => $request->id_traf_per_others_spec,
                                    'id_traf_per_forc_lab' => $request->id_traf_per_forc_lab,
                                    'id_traf_per_srem_org' => $request->id_traf_per_srem_org,
                                    'id_traf_per_prost' => $request->id_traf_per_prost,
                                    'id_sex_hara' => $request->id_sex_hara,
                                    'id_sex_hara_ver' => $request->id_sex_hara_ver,
                                    'id_sex_hara_others' => $request->id_sex_hara_others,
                                    'id_sex_hara_others_spec' => $request->id_sex_hara_others_spec,
                                    'id_sex_hara_phys' => $request->id_sex_hara_phys,
                                    'id_sex_hara_use_obj' => $request->id_sex_hara_use_obj,
                                    'id_chi_abu' => $request->id_chi_abu,
                                    'id_chi_abu_efpaccp' => $request->id_chi_abu_efpaccp,
                                    'id_chi_abu_lasc_cond' => $request->id_chi_abu_lasc_cond,
                                    'id_chi_abu_others' => $request->id_chi_abu_others,
                                    'id_chi_abu_others_spec' => $request->id_chi_abu_others_spec,
                                    'id_chi_abu_sex_int' => $request->id_chi_abu_sex_int,
                                    'id_chi_abu_phys_abu' => $request->id_chi_abu_phys_abu,
                                    'id_descr_inci' => $request->id_descr_inci,
                                    'id_date_of_inci' => $request->id_date_of_inci,
                                    'id_time_of_inci' => $request->id_time_of_inci,
                                    'inci_det_house_no' => $request->inci_det_house_no,
                                    'inci_det_street' => $request->inci_det_street,
                                    'inci_det_region' => $request->inci_det_region,
                                    'inci_det_province' => $request->inci_det_province,
                                    'inci_det_city' => $request->inci_det_city,
                                    'inci_det_barangay' => $request->inci_det_barangay,
                                    'id_pla_of_inci' => $request->id_pla_of_inci,
                                    'id_pi_oth_pls_spec' => $request->id_pi_oth_pls_spec,
                                    'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                                )
                            );
                    
                            PerpetratorDetails::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'perp_d_last_name' => $request->perp_d_last_name,
                                    'perp_d_first_name' => $request->perp_d_first_name,
                                    'perp_d_middle_name' => $request->perp_d_middle_name,
                                    'perp_d_extension_name' => $request->perp_d_extension_name,
                                    'perp_d_alias_name' => $request->perp_d_alias_name,
                                    'perp_d_sex_radio' => $request->perp_d_sex_radio,
                                    'perp_d_birthdate' => $request->perp_d_birthdate,
                                    'perp_d_age' => $request->perp_d_age,
                                    'perp_d_rel_victim' => $request->perp_d_rel_victim,
                                    'perp_d_rel_vic_pls_spec' => $request->perp_d_rel_vic_pls_spec,
                                    'perp_d_occup' => $request->perp_d_occup,
                                    'perp_d_educ_att' => $request->perp_d_educ_att,
                                    'perp_d_nationality' => $request->perp_d_nationality,
                                    'perp_d_nat_if_oth_pls_spec' => $request->perp_d_nat_if_oth_pls_spec,
                                    'perp_d_religion' => $request->perp_d_religion,
                                    'perp_d_rel_if_oth_pls_spec' => $request->perp_d_rel_if_oth_pls_spec,
                                    'perp_d_house_no' => $request->perp_d_house_no,
                                    'perp_d_street' => $request->perp_d_street,
                                    'perp_d_region' => $request->perp_d_region,
                                    'perp_d_province' => $request->perp_d_province,
                                    'perp_d_city' => $request->perp_d_city,
                                    'perp_d_barangay' => $request->perp_d_barangay,
                                    'perp_d_curr_loc' => $request->perp_d_curr_loc,
                                    'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                                    'perp_d_if_yes_pls_ind' => $request->perp_d_if_yes_pls_ind,
                                    'perp_d_addr_par_gua' => $request->perp_d_addr_par_gua,
                                    'perp_d_cont_par_gua' => $request->perp_d_cont_par_gua,
                                    'perp_d_rel_guar_perp' => $request->perp_d_rel_guar_perp,
                                    'perp_d_rel_rgp_pls_spec' => $request->perp_d_rel_rgp_pls_spec,
                                    'perp_d_oth_info_perp' => $request->perp_d_oth_info_perp, 
                                )
                            );
                    
                            InterventionModules::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'im_type_of_service' => $request->im_type_of_service,
                                    'im_typ_serv_if_oth_spec' => $request->im_typ_serv_if_oth_spec,
                                    'im_speci_interv' => $request->im_speci_interv,
                                    'im_spe_int_if_oth_spec' => $request->im_spe_int_if_oth_spec,
                                    'im_serv_prov' => $request->im_serv_prov,
                                    'im_ser_pro_if_oth_spec' => $request->im_ser_pro_if_oth_spec,
                                    'im_speci_obje' => $request->im_speci_obje,
                                    'im_target_date' => $request->im_target_date,
                                    'im_status' => $request->im_status,
                                    'im_if_status_com_pd' => $request->im_if_status_com_pd,
                                    'im_dsp_full_name' => $request->im_dsp_full_name,
                                    'im_dsp_post_desi' => $request->im_dsp_post_desi,
                                    'im_dsp_email' => $request->im_dsp_email,
                                    'im_dsp_contact_no_1' => $request->im_dsp_contact_no_1,
                                    'im_dsp_contact_no_2' => $request->im_dsp_contact_no_2,
                                    'im_dsp_contact_no_3' => $request->im_dsp_contact_no_3,
                                    'im_dasp_full_name' => $request->im_dasp_full_name,
                                    'im_dasp_post_desi' => $request->im_dasp_post_desi,
                                    'im_dasp_email' => $request->im_dasp_email,
                                    'im_dasp_contact_no_1' => $request->im_dasp_contact_no_1,
                                    'im_dasp_contact_no_2' => $request->im_dasp_contact_no_2,
                                    'im_dasp_contact_no_3' => $request->im_dasp_contact_no_3,
                                    'im_summary' => $request->im_summary,
                                )
                            );
                    
                            ReferralModules::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                                    'rm_name_ref_org' => $request->rm_name_ref_org,
                                    'rm_ref_fro_ref_org' => $request->rm_ref_fro_ref_org,
                                    'rm_addr_ref_org' => $request->rm_addr_ref_org,
                                    'rm_referred_by' => $request->rm_referred_by,
                                    'rm_position_title' => $request->rm_position_title,
                                    'rm_contact_no' => $request->rm_contact_no,
                                    'rm_email_add' => $request->rm_email_add,
                                )
                            );
                    
                            CaseModules::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'cm_case_status' => $request->cm_case_status,
                                    'cm_remarks' => $request->cm_remarks,
                                    'cm_assessment' => $request->cm_assessment,
                                    'cm_recommendation' => $request->cm_recommendation,
                                    'cm_upload' => $request->cm_upload,
                    
                                )
                            );
                    
                            CasesUsersActivityLogs::create([
                                'subject_case_no' => $request->case_no,
                                'accountable_user_activity' => 'Update',
                                'accountable_user_email' => Auth::user()->email,
                                'accountable_user_username' => Auth::user()->username,
                                'accountable_user_last_name' => Auth::user()->user_last_name,
                                'accountable_user_first_name' => Auth::user()->user_first_name,
                                'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                            ]);
            
                            return "Case successfully submitted";
                        }
        
                    }elseif($request->form_status == 'Draft'){
        
                        $validator = Validator::make($request->all(), [
        
                            // Personal Details
                            
                            'client_made_a_report_before' => '',
                            'date_of_intake' => '',
                            'type_of_client' => '',
                            'last_name' => '',
                            'first_name' => '',
                            'middle_name' => '',
                            'birth_date' => '',
                            'sex' => '',
                            'extension_name' => '',
                            'alias_name' => '',
                            'age' => '',
                            'client_diverse_sogie' => '',
                            'civil_status' => '',
                            'education' => '',
                            'religion' => '',
                            'religion_if_oth_pls_spec' => '',
                            'nationality' => '',
                            'nationality_if_oth_pls_spec' => '',
                            'ethnicity' => '',
                            'ethnicity_if_oth_pls_spec' => '',
                            'employment_status' => '',
                            'if_self_emp_pls_ind' => '',
                            'house_hold_no' => '',
                            'region' => 'required',
                            'province' => 'required',
                            'city' => 'required',
                            'barangay' => 'required',
                            'street' => '',
                            'is_idp' => '',
                            'is_pwd' => '',
                            'if_pwd_pls_specify' => '',
                            'per_det_cont_info' => '',  
                        ]);
            
                        if ($validator->fails()){
            
                            $errors = $validator->errors();
            
                            return $errors;
            
                        }else{
            
                            Cases::where('case_no','=',$case_no)->update(
        
                                array(
                    
                                    'last_name' => $request->last_name,
                                    'first_name' => $request->first_name,
                                    'middle_name' => $request->middle_name,
                                    'date_of_intake' => $request->date_of_intake,
                                    'im_serv_prov' => $request->im_serv_prov,
                                    'form_status' => $request->form_status,
                                    'cm_case_status' => $request->cm_case_status,
                                    'region' => $request->region,
                                    'province' => $request->province,
                                    'city' => $request->city,
                                    'barangay' => $request->barangay,
                                    'client_made_a_report_before' => $request->client_made_a_report_before,
                                    'age' => $request->age,
                                    'sex' => $request->sex,
                                    'civil_status' => $request->civil_status,
                                    'client_diverse_sogie' => $request->client_diverse_sogie,
                                    'education' => $request->education,
                                    'religion' => $request->religion,
                                    'ethnicity' => $request->ethnicity,
                                    'nationality' => $request->nationality,
                                    'is_idp' => $request->is_idp,
                                    'is_pwd' => $request->is_pwd,
                                    'age_vict_sur' => $request->age_vict_sur,
                                    'nature_of_incidence' => CaseController::putSeparator($request->id_int_part_vio).CaseController::putSeparator($request->id_rape).CaseController::putSeparator($request->id_traf_per).CaseController::putSeparator($request->id_sex_hara).CaseController::putSeparator($request->id_chi_abu),
                                    'sub_option_of_nature_of_incidence' => CaseController::putSeparator($request->id_ipv_phys).CaseController::putSeparator($request->id_ipv_sexual).CaseController::putSeparator($request->id_ipv_psycho).CaseController::putSeparator($request->id_ipv_econo).CaseController::putSeparator($request->id_rape_incest).CaseController::putSeparator($request->id_rape_sta_rape).CaseController::putSeparator($request->id_rape_sex_int).CaseController::putSeparator($request->id_rape_sex_assa).CaseController::putSeparator($request->id_rape_mar_rape).CaseController::putSeparator($request->id_traf_per_sex_exp).CaseController::putSeparator($request->id_traf_per_onl_exp).CaseController::putSeparator($request->id_traf_per_others).CaseController::putSeparator($request->id_traf_per_others_spec).CaseController::putSeparator($request->id_traf_per_forc_lab).CaseController::putSeparator($request->id_traf_per_srem_org).CaseController::putSeparator($request->id_traf_per_prost).CaseController::putSeparator($request->id_sex_hara_ver).CaseController::putSeparator($request->id_sex_hara_others).CaseController::putSeparator($request->id_sex_hara_others_spec).CaseController::putSeparator($request->id_sex_hara_phys).CaseController::putSeparator($request->id_sex_hara_use_obj).CaseController::putSeparator($request->id_chi_abu_efpaccp).CaseController::putSeparator($request->id_chi_abu_lasc_cond).CaseController::putSeparator($request->id_chi_abu_others).CaseController::putSeparator($request->id_chi_abu_others_spec).CaseController::putSeparator($request->id_chi_abu_sex_int).CaseController::putSeparator($request->id_chi_abu_phys_abu),
                                    'id_pla_of_inci' => $request->id_pla_of_inci,
                                    'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                                    'perp_d_age' => $request->perp_d_age,
                                    'perp_d_sex_radio' => $request->perp_d_sex_radio,
                                    'perp_d_rel_victim' => $request->perp_d_rel_victim,
                                    'perp_d_occup' => $request->perp_d_occup,
                                    'perp_d_nationality' => $request->perp_d_nationality,
                                    'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                                    'im_type_of_service' => $request->im_type_of_service,
                                    'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                                    'type_of_client' => $request->type_of_client,
                                    'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,

                                )
                            );
                    
                            PersonalDetails::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'client_made_a_report_before' => $request->client_made_a_report_before,
                                    'date_of_intake' => $request->date_of_intake,
                                    'type_of_client' => $request->type_of_client,
                                    'last_name' => $request->last_name,
                                    'first_name' => $request->first_name,
                                    'middle_name' => $request->middle_name,
                                    'birth_date' => $request->birth_date,
                                    'sex' => $request->sex,
                                    'extension_name' => $request->extension_name,
                                    'alias_name' => $request->alias_name,
                                    'age' => $request->age,
                                    'client_diverse_sogie' => $request->client_diverse_sogie,
                                    'civil_status' => $request->civil_status,
                                    'education' => $request->education,
                                    'religion' => $request->religion,
                                    'religion_if_oth_pls_spec' => $request->religion_if_oth_pls_spec,
                                    'nationality' => $request->nationality,
                                    'nationality_if_oth_pls_spec' => $request->nationality_if_oth_pls_spec,
                                    'ethnicity' => $request->ethnicity,
                                    'ethnicity_if_oth_pls_spec' => $request->ethnicity_if_oth_pls_spec,
                                    'employment_status' => $request->employment_status,
                                    'if_self_emp_pls_ind' => $request->if_self_emp_pls_ind,
                                    'house_hold_no' => $request->house_hold_no,
                                    'region' => $request->region,
                                    'province' => $request->province,
                                    'city' => $request->city,
                                    'barangay' => $request->barangay,
                                    'street' => $request->street,
                                    'is_idp' => $request->is_idp,
                                    'is_pwd' => $request->is_pwd,
                                    'if_pwd_pls_specify' => $request->if_pwd_pls_specify,
                                    'per_det_cont_info' => $request->per_det_cont_info,
                    
                                )
                            );
                    
                            FamilyBackgrounds::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'name_par_guar' => $request->name_par_guar,
                                    'job_vict_sur' => $request->job_vict_sur,
                                    'age_vict_sur' => $request->age_vict_sur,
                                    'rel_vict_sur' => $request->rel_vict_sur,
                                    'rttvs_if_oth_pls_spec' => $request->rttvs_if_oth_pls_spec,
                                    'fam_back_region' => $request->fam_back_region,
                                    'fam_back_province' => $request->fam_back_province,
                                    'fam_back_city' => $request->fam_back_city,
                                    'fam_back_barangay' => $request->fam_back_barangay,
                                    'fam_back_house_no' => $request->fam_back_house_no,
                                    'fam_back_street' => $request->fam_back_street,
                                    'fam_back_cont_num' => $request->fam_back_cont_num,
                                    
                                )
                            );
                    
                            IncidenceDetails::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'id_date_int' => $request->id_date_int,
                                    'id_name_intervi' => $request->id_name_intervi,
                                    'id_pos_desi_int' => $request->id_pos_desi_int,
                                    'id_int_part_vio' => $request->id_int_part_vio,
                                    'id_ipv_phys' => $request->id_ipv_phys,
                                    'id_ipv_sexual' => $request->id_ipv_sexual,
                                    'id_ipv_psycho' => $request->id_ipv_psycho,
                                    'id_ipv_econo' => $request->id_ipv_econo,
                                    'id_rape' => $request->id_rape,
                                    'id_rape_incest' => $request->id_rape_incest,
                                    'id_rape_sta_rape' => $request->id_rape_sta_rape,
                                    'id_rape_sex_int' => $request->id_rape_sex_int,
                                    'id_rape_sex_assa' => $request->id_rape_sex_assa,
                                    'id_rape_mar_rape' => $request->id_rape_mar_rape,
                                    'id_traf_per' => $request->id_traf_per,
                                    'id_traf_per_sex_exp' => $request->id_traf_per_sex_exp,
                                    'id_traf_per_onl_exp' => $request->id_traf_per_onl_exp,
                                    'id_traf_per_others' => $request->id_traf_per_others,
                                    'id_traf_per_others_spec' => $request->id_traf_per_others_spec,
                                    'id_traf_per_forc_lab' => $request->id_traf_per_forc_lab,
                                    'id_traf_per_srem_org' => $request->id_traf_per_srem_org,
                                    'id_traf_per_prost' => $request->id_traf_per_prost,
                                    'id_sex_hara' => $request->id_sex_hara,
                                    'id_sex_hara_ver' => $request->id_sex_hara_ver,
                                    'id_sex_hara_others' => $request->id_sex_hara_others,
                                    'id_sex_hara_others_spec' => $request->id_sex_hara_others_spec,
                                    'id_sex_hara_phys' => $request->id_sex_hara_phys,
                                    'id_sex_hara_use_obj' => $request->id_sex_hara_use_obj,
                                    'id_chi_abu' => $request->id_chi_abu,
                                    'id_chi_abu_efpaccp' => $request->id_chi_abu_efpaccp,
                                    'id_chi_abu_lasc_cond' => $request->id_chi_abu_lasc_cond,
                                    'id_chi_abu_others' => $request->id_chi_abu_others,
                                    'id_chi_abu_others_spec' => $request->id_chi_abu_others_spec,
                                    'id_chi_abu_sex_int' => $request->id_chi_abu_sex_int,
                                    'id_chi_abu_phys_abu' => $request->id_chi_abu_phys_abu,
                                    'id_descr_inci' => $request->id_descr_inci,
                                    'id_date_of_inci' => $request->id_date_of_inci,
                                    'id_time_of_inci' => $request->id_time_of_inci,
                                    'inci_det_house_no' => $request->inci_det_house_no,
                                    'inci_det_street' => $request->inci_det_street,
                                    'inci_det_region' => $request->inci_det_region,
                                    'inci_det_province' => $request->inci_det_province,
                                    'inci_det_city' => $request->inci_det_city,
                                    'inci_det_barangay' => $request->inci_det_barangay,
                                    'id_pla_of_inci' => $request->id_pla_of_inci,
                                    'id_pi_oth_pls_spec' => $request->id_pi_oth_pls_spec,
                                    'id_was_inc_perp_onl' => $request->id_was_inc_perp_onl,
                                )
                            );
                    
                            PerpetratorDetails::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'perp_d_last_name' => $request->perp_d_last_name,
                                    'perp_d_first_name' => $request->perp_d_first_name,
                                    'perp_d_middle_name' => $request->perp_d_middle_name,
                                    'perp_d_extension_name' => $request->perp_d_extension_name,
                                    'perp_d_alias_name' => $request->perp_d_alias_name,
                                    'perp_d_sex_radio' => $request->perp_d_sex_radio,
                                    'perp_d_birthdate' => $request->perp_d_birthdate,
                                    'perp_d_age' => $request->perp_d_age,
                                    'perp_d_rel_victim' => $request->perp_d_rel_victim,
                                    'perp_d_rel_vic_pls_spec' => $request->perp_d_rel_vic_pls_spec,
                                    'perp_d_occup' => $request->perp_d_occup,
                                    'perp_d_educ_att' => $request->perp_d_educ_att,
                                    'perp_d_nationality' => $request->perp_d_nationality,
                                    'perp_d_nat_if_oth_pls_spec' => $request->perp_d_nat_if_oth_pls_spec,
                                    'perp_d_religion' => $request->perp_d_religion,
                                    'perp_d_rel_if_oth_pls_spec' => $request->perp_d_rel_if_oth_pls_spec,
                                    'perp_d_house_no' => $request->perp_d_house_no,
                                    'perp_d_street' => $request->perp_d_street,
                                    'perp_d_region' => $request->perp_d_region,
                                    'perp_d_province' => $request->perp_d_province,
                                    'perp_d_city' => $request->perp_d_city,
                                    'perp_d_barangay' => $request->perp_d_barangay,
                                    'perp_d_curr_loc' => $request->perp_d_curr_loc,
                                    'perp_d_is_perp_minor' => $request->perp_d_is_perp_minor,
                                    'perp_d_if_yes_pls_ind' => $request->perp_d_if_yes_pls_ind,
                                    'perp_d_addr_par_gua' => $request->perp_d_addr_par_gua,
                                    'perp_d_cont_par_gua' => $request->perp_d_cont_par_gua,
                                    'perp_d_rel_guar_perp' => $request->perp_d_rel_guar_perp,
                                    'perp_d_rel_rgp_pls_spec' => $request->perp_d_rel_rgp_pls_spec,
                                    'perp_d_oth_info_perp' => $request->perp_d_oth_info_perp, 
                                )
                            );
                    
                            InterventionModules::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'im_type_of_service' => $request->im_type_of_service,
                                    'im_typ_serv_if_oth_spec' => $request->im_typ_serv_if_oth_spec,
                                    'im_speci_interv' => $request->im_speci_interv,
                                    'im_spe_int_if_oth_spec' => $request->im_spe_int_if_oth_spec,
                                    'im_serv_prov' => $request->im_serv_prov,
                                    'im_ser_pro_if_oth_spec' => $request->im_ser_pro_if_oth_spec,
                                    'im_speci_obje' => $request->im_speci_obje,
                                    'im_target_date' => $request->im_target_date,
                                    'im_status' => $request->im_status,
                                    'im_if_status_com_pd' => $request->im_if_status_com_pd,
                                    'im_dsp_full_name' => $request->im_dsp_full_name,
                                    'im_dsp_post_desi' => $request->im_dsp_post_desi,
                                    'im_dsp_email' => $request->im_dsp_email,
                                    'im_dsp_contact_no_1' => $request->im_dsp_contact_no_1,
                                    'im_dsp_contact_no_2' => $request->im_dsp_contact_no_2,
                                    'im_dsp_contact_no_3' => $request->im_dsp_contact_no_3,
                                    'im_dasp_full_name' => $request->im_dasp_full_name,
                                    'im_dasp_post_desi' => $request->im_dasp_post_desi,
                                    'im_dasp_email' => $request->im_dasp_email,
                                    'im_dasp_contact_no_1' => $request->im_dasp_contact_no_1,
                                    'im_dasp_contact_no_2' => $request->im_dasp_contact_no_2,
                                    'im_dasp_contact_no_3' => $request->im_dasp_contact_no_3,
                                    'im_summary' => $request->im_summary,
                                )
                            );
                    
                            ReferralModules::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'rm_was_cli_ref_by_org' => $request->rm_was_cli_ref_by_org,
                                    'rm_name_ref_org' => $request->rm_name_ref_org,
                                    'rm_ref_fro_ref_org' => $request->rm_ref_fro_ref_org,
                                    'rm_addr_ref_org' => $request->rm_addr_ref_org,
                                    'rm_referred_by' => $request->rm_referred_by,
                                    'rm_position_title' => $request->rm_position_title,
                                    'rm_contact_no' => $request->rm_contact_no,
                                    'rm_email_add' => $request->rm_email_add,
                                )
                            );
                    
                            CaseModules::where('case_no','=',$case_no)->update(
                    
                                array(
                    
                                    'cm_case_status' => $request->cm_case_status,
                                    'cm_remarks' => $request->cm_remarks,
                                    'cm_assessment' => $request->cm_assessment,
                                    'cm_recommendation' => $request->cm_recommendation,
                                    'cm_upload' => $request->cm_upload,
                    
                                )
                            );
                    
                            CasesUsersActivityLogs::create([
                                'subject_case_no' => $request->case_no,
                                'accountable_user_activity' => 'Update',
                                'accountable_user_email' => Auth::user()->email,
                                'accountable_user_username' => Auth::user()->username,
                                'accountable_user_last_name' => Auth::user()->user_last_name,
                                'accountable_user_first_name' => Auth::user()->user_first_name,
                                'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                            ]);
            
                            return "Case successfully saved as draft";
                        }
                    }

                }
            }
        }
    }

    public function getUpdateCreatedCasePage($id){

        if(!Auth::user()){
            return view('login');
        }else{
            abort(401);
        }
    }

    public function uploadFilesForCase(Request $request, $case_no){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if(str_contains($get_user_master_list_rights, "Upload") == false){

                return "Sorry you don't have the rights to upload files, uploaded file was not saved please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed, the uploaded file was not saved';
    
                }else{

                    if($request->hasFile('file')){

                        // Get file details
        
                        $filename_with_ext = $request->file('file')->getClientOriginalName();
                        $filename = pathinfo($filename_with_ext, PATHINFO_FILENAME);
                        $extension = $request->file('file')->getClientOriginalExtension();
        
                        // Validate form
        
                        $validator = Validator::make(
                            
                            array(
                                'case_no' => $case_no,
                                'file' => $filename_with_ext,
                            ),
                            array(
                                'case_no' => 'required',
                                'file' => 'required|max:255',
                            )
                        );
            
                        if ($validator->fails()){
            
                            $errors = $validator->errors();
            
                            return $errors;
            
                        }else{
        
                            Storage::disk('public')->putFileAs('cases/'.$case_no.'/', $request->file('file'), $filename_with_ext);
        
                            if(Storage::disk('public')->exists('cases/'.$case_no.'/'.$filename_with_ext)){
        
                                // Upload files to directory
                            
                                $check_file_if_exists_on_database = json_encode(CasesUploadedFiles::where('case_no','=',$case_no)->where('file','=',$filename_with_ext)->get());
        
                                if($check_file_if_exists_on_database == '[]'){
        
                                    // Record File Path location to database
        
                                    $file_path_location = 'cases/'.$case_no.'/'.$filename_with_ext;
        
                                    CasesUploadedFiles::create([
                                        'case_no' => $case_no,
                                        'file' => $filename_with_ext,
                                        'file_extension' => $extension,
                                        'file_location' => $file_path_location,
                                    ]);
        
                                    CasesUsersActivityLogs::create([
                                        'subject_case_no' => $case_no,
                                        'accountable_user_activity' => 'Upload',
                                        'accountable_user_email' => Auth::user()->email,
                                        'accountable_user_username' => Auth::user()->username,
                                        'accountable_user_last_name' => Auth::user()->user_last_name,
                                        'accountable_user_first_name' => Auth::user()->user_first_name,
                                        'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                                    ]);
        
        
                                    return 'The file was successfully uploaded';
        
                                }else{
        
                                    return 'The file was successfully overwritten';
        
                               }
        
                            }else{
        
                                return 'The file was successfully overwritten';
                            }
        
                        }
                    }
                    else{
                       
                        return 'No selected file';     
                    }   

                }
            }
        }
    }

    public function getUploadedFilesInCase($case_no){

        // Detect User Role Page Access for Page Restriction, and masterlist rights
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        // Get User Masterlist rights

        $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
        $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
        $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
        $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
        $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            // Get Database data

            $uploaded_files_in_case = CasesUploadedFiles::where('case_no','=',$case_no)->get();

            return compact('uploaded_files_in_case', 'master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved');
          
        }
    }

    public function deleteUploadedFilesInCase(Request $request){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            if(str_contains($get_user_master_list_rights, "Delete") == false){

                return "Sorry you don't have the rights to delete case record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed delete was disabled';
    
                }else{

                    Storage::disk('public')->delete('cases/'.$request->case_no.'/'.$request->file);

                    $cases_uploaded_files_id = CasesUploadedFiles::findOrFail($request->id);

                    CasesUsersActivityLogs::create([
                        'subject_case_no' => $request->case_no,
                        'accountable_user_activity' => 'Delete-Files',
                        'accountable_user_email' => Auth::user()->email,
                        'accountable_user_username' => Auth::user()->username,
                        'accountable_user_last_name' => Auth::user()->user_last_name,
                        'accountable_user_first_name' => Auth::user()->user_first_name,
                        'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                    ]);

                    $cases_uploaded_files_id->delete();

                    return 'The file was successfully deleted';

                }
            }    
            
        }
    }

    public function searchDirectory($service_provider){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $search_directory = Directory::where('dir_directory_type','=',$service_provider)->get();

            return $search_directory;

        }

    }

    public function searchDirectoryDetails($id){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $search_directory_details = Directory::findOrFail($id);

            return $search_directory_details;

        }

    }

    public function getRelationshipToVictimSurvivorsList(){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $get_relationship_to_victim_survivors_list = RelationshipToVictimSurvivors::all();

            return $get_relationship_to_victim_survivors_list;

        }

    }

    public function getPlaceOfIncidencesList(){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $get_place_of_incidences_list = PlaceOfIncidences::all();

            return $get_place_of_incidences_list;

        }

    }

    public function getReligionsList(){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $get_religions_list = Religions::all();

            return $get_religions_list;

        }

    }

    public function getDirectoryTypeList(){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $get_service_provider_list = DirectoryType::all();

            return $get_service_provider_list;

        }

    }

    public function getCaseFormStatus($case_no){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $get_case_form_status = Cases::where('case_no','=',$case_no)->get();

            if($get_case_form_status == '[]'){

                return "Doesn't Exist";
            }
            else{

                $status = $get_case_form_status[0]->form_status;

                return $status;
            }
            

        }

    }

    public function getCaseStatus($case_no){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            $get_case_status = CaseModules::where('case_no','=',$case_no)->get();

            if($get_case_status == '[]'){

                return "Doesn't Exist";
            }
            else{

                $status = $get_case_status[0]->cm_case_status;

                return $status;
            }
            

        }

    }

    public function getUserMasterListRights(){

        // Detect User Role Page Access for Page Restriction
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            abort(401);
        }
        else{

            // Detect User Role masterlist rights
        
            $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
            $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

            // Get User Masterlist rights

            $master_list_rights_add = str_contains($get_user_master_list_rights, "Add");
            $master_list_rights_revise = str_contains($get_user_master_list_rights, "Revise");
            $master_list_rights_delete = str_contains($get_user_master_list_rights, "Delete");
            $master_list_rights_upload = str_contains($get_user_master_list_rights, "Upload");
            $master_list_rights_approved_disapproved = str_contains($get_user_master_list_rights, "Approved/Disapproved");

            return compact('master_list_rights_add', 'master_list_rights_revise', 'master_list_rights_delete', 'master_list_rights_upload', 'master_list_rights_approved_disapproved');
         
        }

    }

    public function updateFamilyBackgroundInfos(Request $request, $id){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if((str_contains($get_user_page_access, "Master List") == false)){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Revise") == false){

                return "Sorry you don't have the rights to update this case please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed editing was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [
   
                        'name_par_guar_modal' => 'required',
                        'job_vict_sur_modal' => 'required',
                        'age_vict_sur_modal' => 'required',
                        'rel_vict_sur_modal' => 'required',
                        'rttvs_if_oth_pls_spec_modal' => '',
                        'fam_back_house_no_modal' => '',
                        'fam_back_street_modal' => '',
                        'fam_back_region_modal' => 'required',
                        'fam_back_province_modal' => 'required',
                        'fam_back_city_modal' => 'required',
                        'fam_back_barangay_modal' => 'required',
                        'fam_back_cont_num_modal' => 'required',
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{

                        FamilyBackgroundInfos::where('id','=',$id)->update(
    
                            array(
                
                                'name_par_guar_modal' => $request->name_par_guar_modal,
                                'age_vict_sur_modal' => $request->age_vict_sur_modal,
                                'job_vict_sur_modal' => $request->job_vict_sur_modal,
                                'rel_vict_sur_modal' => $request->rel_vict_sur_modal,
                                'rttvs_if_oth_pls_spec_modal' => $request->rttvs_if_oth_pls_spec_modal,
                                'fam_back_region_modal' => $request->fam_back_region_modal,
                                'fam_back_province_modal' => $request->fam_back_province_modal,
                                'fam_back_city_modal' => $request->fam_back_city_modal,
                                'fam_back_barangay_modal' => $request->fam_back_barangay_modal,
                                'fam_back_house_no_modal' => $request->fam_back_house_no_modal,
                                'fam_back_street_modal' => $request->fam_back_street_modal,
                                'fam_back_cont_num_modal' => $request->fam_back_cont_num_modal,
                            )
                        );
                
                        $get_case_no_modal  = FamilyBackgroundInfos::where('id','=',$id)->get();
                
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $get_case_no_modal[0]->case_no_modal,
                            'accountable_user_activity' => 'Update-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
            
                        return 'Updating Family Background Info Success';
    
                    }
    
                }
            }
        }
    }

    public function deleteFamilyBackgroundInfos(Request $request, $id){

        // Get Case No.

        $get_case_no_modal  = FamilyBackgroundInfos::where('id','=',$id)->get();
        $case_no = $get_case_no_modal[0]->case_no_modal;

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($case_no) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$case_no];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Delete") == false){

                return "Sorry you don't have the rights to delete case record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed delete was disabled';
    
                }else{
    
                    CasesUsersActivityLogs::create([
                        'subject_case_no' => $case_no,
                        'accountable_user_activity' => 'Delete-Additional-Record',
                        'accountable_user_email' => Auth::user()->email,
                        'accountable_user_username' => Auth::user()->username,
                        'accountable_user_last_name' => Auth::user()->user_last_name,
                        'accountable_user_first_name' => Auth::user()->user_first_name,
                        'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                    ]);

                    FamilyBackgroundInfos::where('id','=',$id)->delete();

                    return 'The Family Background Info was successfully deleted';

                }
            }
        }
    }

    public function updateIncidenceDetailInfos(Request $request, $id){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Revise") == false){

                return "Sorry you don't have the rights to update this case please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed editing was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [

                        'id_date_int_modal' => 'required',
                        'id_name_intervi_modal' => 'required',
                        'id_pos_desi_int_modal' => 'required',
                        'id_int_part_vio_modal' => 'required_without_all:id_rape_modal,id_traf_per_modal,id_sex_hara_modal,id_chi_abu_modal',
                        'id_ipv_phys_modal' => '',
                        'id_ipv_sexual_modal' => '',
                        'id_ipv_psycho_modal' => '',
                        'id_ipv_econo_modal' => '',
                        'id_rape_modal' => 'required_without_all:id_int_part_vio_modal,id_traf_per_modal,id_sex_hara_modal,id_chi_abu_modal',
                        'id_rape_incest_modal' => '',
                        'id_rape_sta_rape_modal' => '',
                        'id_rape_sex_int_modal' => '',
                        'id_rape_sex_assa_modal' => '',
                        'id_rape_mar_rape_modal' => '',
                        'id_traf_per_modal' => 'required_without_all:id_int_part_vio_modal,id_rape_modal,id_sex_hara_modal,id_chi_abu_modal',
                        'id_traf_per_sex_exp_modal' => '',
                        'id_traf_per_onl_exp_modal' => '',
                        'id_traf_per_others_modal' => '',
                        'id_traf_per_others_spec_modal' => 'required_if:id_traf_per_others_modal,Others',
                        'id_traf_per_forc_lab_modal' => '',
                        'id_traf_per_srem_org_modal' => '',
                        'id_traf_per_prost_modal' => '',
                        'id_sex_hara_modal' => 'required_without_all:id_int_part_vio_modal,id_rape_modal,id_traf_per_modal,id_chi_abu_modal',
                        'id_sex_hara_ver_modal' => '',
                        'id_sex_hara_others_modal' => '',
                        'id_sex_hara_others_spec_modal' => 'required_if:id_sex_hara_others_modal,Others',
                        'id_sex_hara_phys_modal' => '',
                        'id_sex_hara_use_obj_modal' => '',
                        'id_chi_abu_modal' => 'required_without_all:id_int_part_vio_modal,id_rape_modal,id_traf_per_modal,id_sex_hara_modal',
                        'id_chi_abu_efpaccp_modal' => '',
                        'id_chi_abu_lasc_cond_modal' => '',
                        'id_chi_abu_others_modal' => '',
                        'id_chi_abu_others_spec_modal' => 'required_if:id_chi_abu_others_modal,Others',
                        'id_chi_abu_sex_int_modal' => '',
                        'id_chi_abu_phys_abu_modal' => '',
                        'id_descr_inci_modal' => 'required',
                        'id_date_of_inci_modal' => 'required',
                        'id_time_of_inci_modal' => '',
                        'inci_det_house_no_modal' => '',
                        'inci_det_street_modal' => '',
                        'inci_det_region_modal' => 'required',
                        'inci_det_province_modal' => 'required',
                        'inci_det_city_modal' => 'required',
                        'inci_det_barangay_modal' => 'required',
                        'id_pla_of_inci_modal' => 'required',
                        'id_pi_oth_pls_spec_modal' => '',
                        'id_was_inc_perp_onl_modal' => 'required',                
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{

                        IncidenceDetailInfos::where('id','=',$id)->update(

                            array(
                
                                'id_date_int_modal' => $request->id_date_int_modal,
                                'id_name_intervi_modal' => $request->id_name_intervi_modal,
                                'id_pos_desi_int_modal' => $request->id_pos_desi_int_modal,
                                'id_int_part_vio_modal' => $request->id_int_part_vio_modal,
                                'id_ipv_phys_modal' => $request->id_ipv_phys_modal,
                                'id_ipv_sexual_modal' => $request->id_ipv_sexual_modal,
                                'id_ipv_psycho_modal' => $request->id_ipv_psycho_modal,
                                'id_ipv_econo_modal' => $request->id_ipv_econo_modal,
                                'id_rape_modal' => $request->id_rape_modal,
                                'id_rape_incest_modal' => $request->id_rape_incest_modal,
                                'id_rape_sta_rape_modal' => $request->id_rape_sta_rape_modal,
                                'id_rape_sex_int_modal' => $request->id_rape_sex_int_modal,
                                'id_rape_sex_assa_modal' => $request->id_rape_sex_assa_modal,
                                'id_rape_mar_rape_modal' => $request->id_rape_mar_rape_modal,
                                'id_traf_per_modal' => $request->id_traf_per_modal,
                                'id_traf_per_sex_exp_modal' => $request->id_traf_per_sex_exp_modal,
                                'id_traf_per_onl_exp_modal' => $request->id_traf_per_onl_exp_modal,
                                'id_traf_per_others_modal' => $request->id_traf_per_others_modal,
                                'id_traf_per_others_spec_modal' => $request->id_traf_per_others_spec_modal,
                                'id_traf_per_forc_lab_modal' => $request->id_traf_per_forc_lab_modal,
                                'id_traf_per_srem_org_modal' => $request->id_traf_per_srem_org_modal,
                                'id_traf_per_prost_modal' => $request->id_traf_per_prost_modal,
                                'id_sex_hara_modal' => $request->id_sex_hara_modal,
                                'id_sex_hara_ver_modal' => $request->id_sex_hara_ver_modal,
                                'id_sex_hara_others_modal' => $request->id_sex_hara_others_modal,
                                'id_sex_hara_others_spec_modal' => $request->id_sex_hara_others_spec_modal,
                                'id_sex_hara_phys_modal' => $request->id_sex_hara_phys_modal,
                                'id_sex_hara_use_obj_modal' => $request->id_sex_hara_use_obj_modal,
                                'id_chi_abu_modal' => $request->id_chi_abu_modal,
                                'id_chi_abu_efpaccp_modal' => $request->id_chi_abu_efpaccp_modal,
                                'id_chi_abu_lasc_cond_modal' => $request->id_chi_abu_lasc_cond_modal,
                                'id_chi_abu_others_modal' => $request->id_chi_abu_others_modal,
                                'id_chi_abu_others_spec_modal' => $request->id_chi_abu_others_spec_modal,
                                'id_chi_abu_sex_int_modal' => $request->id_chi_abu_sex_int_modal,
                                'id_chi_abu_phys_abu_modal' => $request->id_chi_abu_phys_abu_modal,
                                'id_descr_inci_modal' => $request->id_descr_inci_modal,
                                'id_date_of_inci_modal' => $request->id_date_of_inci_modal,
                                'id_time_of_inci_modal' => $request->id_time_of_inci_modal,
                                'inci_det_house_no_modal' => $request->inci_det_house_no_modal,
                                'inci_det_street_modal' => $request->inci_det_street_modal,
                                'inci_det_region_modal' => $request->inci_det_region_modal,
                                'inci_det_province_modal' => $request->inci_det_province_modal,
                                'inci_det_city_modal' => $request->inci_det_city_modal,
                                'inci_det_barangay_modal' => $request->inci_det_barangay_modal,
                                'id_pla_of_inci_modal' => $request->id_pla_of_inci_modal,
                                'id_pi_oth_pls_spec_modal' => $request->id_pi_oth_pls_spec_modal,
                                'id_was_inc_perp_onl_modal' => $request->id_was_inc_perp_onl_modal,
                            )
                        );
                
                        $get_case_no_modal  = IncidenceDetailInfos::where('id','=',$id)->get();
                
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $get_case_no_modal[0]->case_no_modal,
                            'accountable_user_activity' => 'Update-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
            
                        return 'Updating Incidence Details Info Success';

                    }

                }
            }    
        }
    }

    public function deleteIncidenceDetailInfos(Request $request, $id){

        // Get Case No.

        $get_case_no_modal  = IncidenceDetailInfos::where('id','=',$id)->get();
        $case_no = $get_case_no_modal[0]->case_no_modal;

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($case_no) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$case_no];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Delete") == false){

                return "Sorry you don't have the rights to delete case record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed delete was disabled';
    
                }else{

                    CasesUsersActivityLogs::create([
                        'subject_case_no' => $case_no,
                        'accountable_user_activity' => 'Delete-Additional-Record',
                        'accountable_user_email' => Auth::user()->email,
                        'accountable_user_username' => Auth::user()->username,
                        'accountable_user_last_name' => Auth::user()->user_last_name,
                        'accountable_user_first_name' => Auth::user()->user_first_name,
                        'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                    ]);

                    IncidenceDetailInfos::where('id','=',$id)->delete();

                    return 'The Incidence Details Info was successfully deleted';

                }
            }
        }
    }

    public function updatePerpetratorDetailInfos(Request $request, $id){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Revise") == false){

                return "Sorry you don't have the rights to update this case please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed editing was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [
    
                        'perp_d_last_name_modal' => 'required',
                        'perp_d_first_name_modal' => 'required',
                        'perp_d_middle_name_modal' => 'required',
                        'perp_d_extension_name_modal' => '',
                        'perp_d_alias_name_modal' => '',
                        'perp_d_sex_radio_modal' => 'required',
                        'perp_d_birthdate_modal' => 'required',
                        'perp_d_age_modal' => 'required',
                        'perp_d_rel_victim_modal' => 'required',
                        'perp_d_rel_vic_pls_spec_modal' => '',
                        'perp_d_occup_modal' => 'required',
                        'perp_d_educ_att_modal' => 'required',
                        'perp_d_nationality_modal' => 'required',
                        'perp_d_nat_if_oth_pls_spec_modal' => '',
                        'perp_d_religion_modal' => 'required',
                        'perp_d_rel_if_oth_pls_spec_modal' => '',
                        'perp_d_house_no_modal' => '',
                        'perp_d_street_modal' => '',
                        'perp_d_region_modal' => 'required',
                        'perp_d_province_modal' => 'required',
                        'perp_d_city_modal' => 'required',
                        'perp_d_barangay_modal' => 'required',
                        'perp_d_curr_loc_modal' => 'required',
                        'perp_d_is_perp_minor_modal' => 'required',
                        'perp_d_if_yes_pls_ind_modal' => '',
                        'perp_d_addr_par_gua_modal' => 'required',
                        'perp_d_cont_par_gua_modal' => 'required',
                        'perp_d_rel_guar_perp_modal' => 'required',
                        'perp_d_rel_rgp_pls_spec_modal' => '',
                        'perp_d_oth_info_perp_modal' => '',                
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{

                        PerpetratorDetailInfos::where('id','=',$id)->update(

                            array(
                
                                'perp_d_last_name_modal' => $request->perp_d_last_name_modal,
                                'perp_d_first_name_modal' => $request->perp_d_first_name_modal,
                                'perp_d_middle_name_modal' => $request->perp_d_middle_name_modal,
                                'perp_d_extension_name_modal' => $request->perp_d_extension_name_modal,
                                'perp_d_alias_name_modal' => $request->perp_d_alias_name_modal,
                                'perp_d_sex_radio_modal' => $request->perp_d_sex_radio_modal,
                                'perp_d_birthdate_modal' => $request->perp_d_birthdate_modal,
                                'perp_d_age_modal' => $request->perp_d_age_modal,
                                'perp_d_rel_victim_modal' => $request->perp_d_rel_victim_modal,
                                'perp_d_rel_vic_pls_spec_modal' => $request->perp_d_rel_vic_pls_spec_modal,
                                'perp_d_occup_modal' => $request->perp_d_occup_modal,
                                'perp_d_educ_att_modal' => $request->perp_d_educ_att_modal,
                                'perp_d_nationality_modal' => $request->perp_d_nationality_modal,
                                'perp_d_nat_if_oth_pls_spec_modal' => $request->perp_d_nat_if_oth_pls_spec_modal,
                                'perp_d_religion_modal' => $request->perp_d_religion_modal,
                                'perp_d_rel_if_oth_pls_spec_modal' => $request->perp_d_rel_if_oth_pls_spec_modal,
                                'perp_d_house_no_modal' => $request->perp_d_house_no_modal,
                                'perp_d_street_modal' => $request->perp_d_street_modal,
                                'perp_d_region_modal' => $request->perp_d_region_modal,
                                'perp_d_province_modal' => $request->perp_d_province_modal,
                                'perp_d_city_modal' => $request->perp_d_city_modal,
                                'perp_d_barangay_modal' => $request->perp_d_barangay_modal,
                                'perp_d_curr_loc_modal' => $request->perp_d_curr_loc_modal,
                                'perp_d_is_perp_minor_modal' => $request->perp_d_is_perp_minor_modal,
                                'perp_d_if_yes_pls_ind_modal' => $request->perp_d_if_yes_pls_ind_modal,
                                'perp_d_addr_par_gua_modal' => $request->perp_d_addr_par_gua_modal,
                                'perp_d_cont_par_gua_modal' => $request->perp_d_cont_par_gua_modal,
                                'perp_d_rel_guar_perp_modal' => $request->perp_d_rel_guar_perp_modal,
                                'perp_d_rel_rgp_pls_spec_modal' => $request->perp_d_rel_rgp_pls_spec_modal,
                                'perp_d_oth_info_perp_modal' => $request->perp_d_oth_info_perp_modal,
                            )
                        );
                
                        $get_case_no_modal  = PerpetratorDetailInfos::where('id','=',$id)->get();
                
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $get_case_no_modal[0]->case_no_modal,
                            'accountable_user_activity' => 'Update-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
            
                        return 'Updating Perpetrator Details Info Success';

                    }

                }
            }
        }
    }

    public function deletePerpetratorDetailInfos(Request $request, $id){
        
        // Get Case No.

        $get_case_no_modal  = PerpetratorDetailInfos::where('id','=',$id)->get();
        $case_no = $get_case_no_modal[0]->case_no_modal;

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($case_no) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$case_no];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Delete") == false){

                return "Sorry you don't have the rights to delete case record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed delete was disabled';
    
                }else{
    
                    CasesUsersActivityLogs::create([
                        'subject_case_no' => $case_no,
                        'accountable_user_activity' => 'Delete-Additional-Record',
                        'accountable_user_email' => Auth::user()->email,
                        'accountable_user_username' => Auth::user()->username,
                        'accountable_user_last_name' => Auth::user()->user_last_name,
                        'accountable_user_first_name' => Auth::user()->user_first_name,
                        'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                    ]);

                    PerpetratorDetailInfos::where('id','=',$id)->delete();

                    return 'The Perpetrator Details Info was successfully deleted';

                }
            }
        }
    }

    public function updateInterventionModuleInfos(Request $request, $id){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($request->case_no_modal) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$request->case_no_modal];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Revise") == false){

                return "Sorry you don't have the rights to update this case please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed editing was disabled';
    
                }else{

                    $validator = Validator::make($request->all(), [
    
                        'im_type_of_service_modal' => 'required',
                        'im_typ_serv_if_oth_spec_modal' => '',
                        'im_speci_interv_modal' => 'required',
                        'im_spe_int_if_oth_spec_modal' => '',
                        'im_serv_prov_modal' => 'required',
                        'im_ser_pro_if_oth_spec_modal' => '',
                        'im_speci_obje_modal' => 'required',
                        'im_target_date_modal' => 'required',
                        'im_status_modal' => 'required',
                        'im_if_status_com_pd_modal' => 'required_if:im_status_modal,Provided',
                        'im_dsp_full_name_modal' => 'required',
                        'im_dsp_post_desi_modal' => 'required',
                        'im_dsp_email_modal' => 'required|email',
                        'im_dsp_contact_no_1_modal' => 'required',
                        'im_dsp_contact_no_2_modal' => '',
                        'im_dsp_contact_no_3_modal' => '',
                        'im_dasp_full_name_modal' => '',
                        'im_dasp_post_desi_modal' => '',
                        'im_dasp_email_modal' => '',
                        'im_dasp_contact_no_1_modal' => '',
                        'im_dasp_contact_no_2_modal' => '',
                        'im_dasp_contact_no_3_modal' => '',
                        'im_summary_modal' => 'required',                
        
                    ]);
        
                    if ($validator->fails()){
        
                        $errors = $validator->errors();
        
                        return $errors;
        
                    }else{

                        InterventionModuleInfos::where('id','=',$id)->update(

                            array(
                
                                'im_type_of_service_modal' => $request->im_type_of_service_modal,
                                'im_typ_serv_if_oth_spec_modal' => $request->im_typ_serv_if_oth_spec_modal,
                                'im_speci_interv_modal' => $request->im_speci_interv_modal,
                                'im_spe_int_if_oth_spec_modal' => $request->im_spe_int_if_oth_spec_modal,
                                'im_serv_prov_modal' => $request->im_serv_prov_modal,
                                'im_ser_pro_if_oth_spec_modal' => $request->im_ser_pro_if_oth_spec_modal,
                                'im_speci_obje_modal' => $request->im_speci_obje_modal,
                                'im_target_date_modal' => $request->im_target_date_modal,
                                'im_status_modal' => $request->im_status_modal,
                                'im_if_status_com_pd_modal' => $request->im_if_status_com_pd_modal,
                                'im_dsp_full_name_modal' => $request->im_dsp_full_name_modal,
                                'im_dsp_post_desi_modal' => $request->im_dsp_post_desi_modal,
                                'im_dsp_email_modal' => $request->im_dsp_email_modal,
                                'im_dsp_contact_no_1_modal' => $request->im_dsp_contact_no_1_modal,
                                'im_dsp_contact_no_2_modal' => $request->im_dsp_contact_no_2_modal,
                                'im_dsp_contact_no_3_modal' => $request->im_dsp_contact_no_3_modal,
                                'im_dasp_full_name_modal' => $request->im_dasp_full_name_modal,
                                'im_dasp_post_desi_modal' => $request->im_dasp_post_desi_modal,
                                'im_dasp_email_modal' => $request->im_dasp_email_modal,
                                'im_dasp_contact_no_1_modal' => $request->im_dasp_contact_no_1_modal,
                                'im_dasp_contact_no_2_modal' => $request->im_dasp_contact_no_2_modal,
                                'im_dasp_contact_no_3_modal' => $request->im_dasp_contact_no_3_modal,
                                'im_summary_modal' => $request->im_summary_modal,
                            )
                        );
                
                        $get_case_no_modal  = InterventionModuleInfos::where('id','=',$id)->get();
                
                        CasesUsersActivityLogs::create([
                            'subject_case_no' => $get_case_no_modal[0]->case_no_modal,
                            'accountable_user_activity' => 'Update-Additional-Record',
                            'accountable_user_email' => Auth::user()->email,
                            'accountable_user_username' => Auth::user()->username,
                            'accountable_user_last_name' => Auth::user()->user_last_name,
                            'accountable_user_first_name' => Auth::user()->user_first_name,
                            'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                        ]);
            
                        return 'Updating Intervention Module Info Success';

                    }

                }
            }
        }
    }

    public function deleteInterventionModuleInfos(Request $request, $id){
        
        // Get Case No.

        $get_case_no_modal  = InterventionModuleInfos::where('id','=',$id)->get();
        $case_no = $get_case_no_modal[0]->case_no_modal;

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];
        
        // Validate Case No.

        if(CaseController::validateCaseNo($case_no) == 'Case No. can be added'){
            $get_case_no_cm_case_status = 'New Case';
        }else{
            $get_case_no_cm_case_status = $list_case_no_cm_case_status[$case_no];
        }

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            if(str_contains($get_user_master_list_rights, "Delete") == false){

                return "Sorry you don't have the rights to delete case record please contact the administrator";
                
            }else{

                if(str_contains($get_case_no_cm_case_status, "Closed") == true){

                    return 'Case already closed delete was disabled';
    
                }else{
    
                    CasesUsersActivityLogs::create([
                        'subject_case_no' => $case_no,
                        'accountable_user_activity' => 'Delete-Additional-Record',
                        'accountable_user_email' => Auth::user()->email,
                        'accountable_user_username' => Auth::user()->username,
                        'accountable_user_last_name' => Auth::user()->user_last_name,
                        'accountable_user_first_name' => Auth::user()->user_first_name,
                        'accountable_user_middle_name' => Auth::user()->user_middle_name,  
                    ]);

                    InterventionModuleInfos::where('id','=',$id)->delete();

                    return 'The Intervention Module Info was successfully deleted';

                }
            }
        }
    }

    public function migateDataInNewColumnForCasesTable(Request $request){

        // Detect User Role Page Access for Page Restriction, masterlist rights and case status
        
        $list_roles_page_access = UserRole::pluck('page_access','role_name');
        $list_roles_master_list_rights = UserRole::pluck('master_list_rights','role_name');
        $list_case_no_cm_case_status = CaseModules::pluck('cm_case_status','case_no');
        $get_user_page_access = $list_roles_page_access[Auth::user()->role];
        $get_user_master_list_rights = $list_roles_master_list_rights[Auth::user()->role];

        if(str_contains($get_user_page_access, "Master List") == false){

            return view('restricted');
        }
        else{

            $case_list = Cases::get();

            foreach($case_list as $case){

                $migate_personal_details = PersonalDetails::where('case_no','=',$case->case_no)->get();
                $migate_family_backgrounds = FamilyBackgrounds::where('case_no','=',$case->case_no)->get();
                $migate_incidence_details = IncidenceDetails::where('case_no','=',$case->case_no)->get();
                $migate_perpetrator_details = PerpetratorDetails::where('case_no','=',$case->case_no)->get();
                $migate_intervention_modules = InterventionModules::where('case_no','=',$case->case_no)->get();
                $migate_referral_modules = ReferralModules::where('case_no','=',$case->case_no)->get();
                $migate_case_modules = CaseModules::where('case_no','=',$case->case_no)->get();

                Cases::where('case_no','=',$case->case_no)->update(
            
                    array(

                        'region' => $migate_personal_details[0]->region,
                        'province' => $migate_personal_details[0]->province,
                        'city' => $migate_personal_details[0]->city,
                        'barangay' => $migate_personal_details[0]->barangay,
                        'client_made_a_report_before' => $migate_personal_details[0]->client_made_a_report_before,
                        'age' => $migate_personal_details[0]->age,
                        'sex' => $migate_personal_details[0]->sex,
                        'civil_status' => $migate_personal_details[0]->civil_status,
                        'client_diverse_sogie' => $migate_personal_details[0]->client_diverse_sogie,
                        'education' => $migate_personal_details[0]->education,
                        'religion' => $migate_personal_details[0]->religion,
                        'ethnicity' => $migate_personal_details[0]->ethnicity,
                        'nationality' => $migate_personal_details[0]->nationality,
                        'is_idp' => $migate_personal_details[0]->is_idp,
                        'is_pwd' => $migate_personal_details[0]->is_pwd,
                        'age_vict_sur' => $migate_family_backgrounds[0]->age_vict_sur,
                        'nature_of_incidence' => CaseController::putSeparator($migate_incidence_details[0]->id_int_part_vio).CaseController::putSeparator($migate_incidence_details[0]->id_rape).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per).CaseController::putSeparator($migate_incidence_details[0]->id_sex_hara).CaseController::putSeparator($migate_incidence_details[0]->id_chi_abu),
                        'sub_option_of_nature_of_incidence' => CaseController::putSeparator($migate_incidence_details[0]->id_ipv_phys).CaseController::putSeparator($migate_incidence_details[0]->id_ipv_sexual).CaseController::putSeparator($migate_incidence_details[0]->id_ipv_psycho).CaseController::putSeparator($migate_incidence_details[0]->id_ipv_econo).CaseController::putSeparator($migate_incidence_details[0]->id_rape_incest).CaseController::putSeparator($migate_incidence_details[0]->id_rape_sta_rape).CaseController::putSeparator($migate_incidence_details[0]->id_rape_sex_int).CaseController::putSeparator($migate_incidence_details[0]->id_rape_sex_assa).CaseController::putSeparator($migate_incidence_details[0]->id_rape_mar_rape).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per_sex_exp).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per_onl_exp).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per_others).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per_others_spec).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per_forc_lab).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per_srem_org).CaseController::putSeparator($migate_incidence_details[0]->id_traf_per_prost).CaseController::putSeparator($migate_incidence_details[0]->id_sex_hara_ver).CaseController::putSeparator($migate_incidence_details[0]->id_sex_hara_others).CaseController::putSeparator($migate_incidence_details[0]->id_sex_hara_others_spec).CaseController::putSeparator($migate_incidence_details[0]->id_sex_hara_phys).CaseController::putSeparator($migate_incidence_details[0]->id_sex_hara_use_obj).CaseController::putSeparator($migate_incidence_details[0]->id_chi_abu_efpaccp).CaseController::putSeparator($migate_incidence_details[0]->id_chi_abu_lasc_cond).CaseController::putSeparator($migate_incidence_details[0]->id_chi_abu_others).CaseController::putSeparator($migate_incidence_details[0]->id_chi_abu_others_spec).CaseController::putSeparator($migate_incidence_details[0]->id_chi_abu_sex_int).CaseController::putSeparator($migate_incidence_details[0]->id_chi_abu_phys_abu),
                        'id_pla_of_inci' => $migate_incidence_details[0]->id_pla_of_inci,
                        'id_was_inc_perp_onl' => $migate_incidence_details[0]->id_was_inc_perp_onl,
                        'perp_d_age' => $migate_perpetrator_details[0]->perp_d_age,
                        'perp_d_sex_radio' => $migate_perpetrator_details[0]->perp_d_sex_radio,
                        'perp_d_rel_victim' => $migate_perpetrator_details[0]->perp_d_rel_victim,
                        'perp_d_occup' => $migate_perpetrator_details[0]->perp_d_occup,
                        'perp_d_nationality' => $migate_perpetrator_details[0]->perp_d_nationality,
                        'perp_d_is_perp_minor' => $migate_perpetrator_details[0]->perp_d_is_perp_minor,
                        'im_type_of_service' => $migate_intervention_modules[0]->im_type_of_service,
                        'rm_was_cli_ref_by_org' => $migate_referral_modules[0]->rm_was_cli_ref_by_org,
                        'type_of_client' => $migate_personal_details[0]->type_of_client,
                        'ethnicity_if_oth_pls_spec' => $migate_personal_details[0]->ethnicity_if_oth_pls_spec,

                    )
                );

            }

            return 'Migrated Successfully';

        }
    }

}

@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-gray-800">View Case</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/case-folder/master-list">Master List</a></li>
            <li class="breadcrumb-item active">View Case</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form class="user row" id="msform" method="POST" action="javascript:void(0);">
        @csrf 
        @method('PUT')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2">
                        <ul id="progressbar">
                            <li class="active progressbar-label" id="personalDetails"><strong>Personal Details</strong></li>
                            <li class="progressbar-label" id="familyBackground"><strong>Family Background</strong></li>
                            <li class="progressbar-label" id="incidenceDetails"><strong>Incidence Details</strong></li>
                            <li class="progressbar-label" id="perpetratorDetails"><strong>Perpetrator Details</strong></li>
                            <li class="progressbar-label" id="interventionModule"><strong>Intervention Module</strong></li>
                            <li class="progressbar-label" id="referralModule"><strong>Referral Module</strong></li>
                            <li class="progressbar-label" id="caseModule"><strong>Case Module</strong></li>
                        </ul>
                    </div>
                    <div class="col-10">
                        <fieldset>
                            <div class="card border-light shadow-lg">
                                <div class="p-3">Personal Details</div>
                                <hr class="bg-dark my-3 px-5" />
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <input type="checkbox" name="client_made_a_report_before" value="Yes" {{($viewcaseformPerso[0]->client_made_a_report_before === 'Yes') ? 'Checked' : ''}} disabled/>
                                            <span class="card-text">Has the client made a report before?</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Date of Intake<span class="asterisk">*</span></p></span>
                                            <input type="date" name="date_of_intake" class="w-100 date text-box form-control" value="{{$viewcaseformPerso[0]->date_of_intake}}" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Case No.<span class="asterisk">*</span></p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->case_no }}" id="case_no" name="case_no" placeholder="" class="w-100 form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Type of Client<span class="asterisk">*</span></p></span>
                                            <select name="type_of_client" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Walk-In" {{($viewcaseformPerso[0]->type_of_client === 'Walk-In') ? 'Selected' : ''}}>Walk-In</option>
                                                <option value="Referral" {{($viewcaseformPerso[0]->type_of_client === 'Referral') ? 'Selected' : ''}}>Referral</option>
                                                <option value="Reach out" {{($viewcaseformPerso[0]->type_of_client === 'Reach out') ? 'Selected' : ''}}>Reach out</option>
                                                <option value="Text / Call" {{($viewcaseformPerso[0]->type_of_client === 'Text / Call') ? 'Selected' : ''}}>Text / Call</option>
                                                <option value="Online Platforms" {{($viewcaseformPerso[0]->type_of_client === 'Online Platforms') ? 'Selected' : ''}}>Online Platforms</option>
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="row mb-3">    
                                        <div class="col"><span><p class="card-text">Last Name<span class="asterisk">*</span></p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->last_name }}" name="last_name" placeholder="Last name" class="w-100 form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">First Name<span class="asterisk">*</span></p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->first_name }}" name="first_name" placeholder="First name" class="w-100 form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Middle Name<span class="asterisk">*</span></p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->middle_name }}" name="middle_name" placeholder="Middle name" class="w-100 form-control" disabled/>
                                        </div>
                                    </div>  
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Extension</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->extension_name }}" name="extension_name" placeholder="" class="w-100 form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Nickname/Alias</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->alias_name }}" name="alias_name" placeholder="" class="w-100 form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Sex<span class="asterisk">*</span></p></span>
                                            <select name="sex" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Male" {{($viewcaseformPerso[0]->sex === 'Male') ? 'Selected' : ''}}>Male</option>
                                                <option value="Female" {{($viewcaseformPerso[0]->sex === 'Female') ? 'Selected' : ''}}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">    
                                        <div class="col"><span><p class="card-text">Birthdate<span class="asterisk">*</span></p></span>
                                            <input type="date" value="{{ $viewcaseformPerso[0]->birth_date }}" name="birth_date" class="w-100 date text-box form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Age<span class="asterisk">*</span></p></span>
                                            <input type="number" value="{{$viewcaseformPerso[0]->age }}" name="age" placeholder="" class="w-100 form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Civil Status<span class="asterisk">*</span></p></span>
                                            <select name="civil_status" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Single" {{($viewcaseformPerso[0]->civil_status === 'Single') ? 'Selected' : ''}}>Single</option>
                                                <option value="Legally Married" {{($viewcaseformPerso[0]->civil_status === 'Legally Married') ? 'Selected' : ''}}>Legally Married</option>
                                                <option value="Consensual, Common Law, or Live-In Partner" {{($viewcaseformPerso[0]->civil_status === 'Consensual, Common Law, or Live-In Partner') ? 'Selected' : ''}}>Consensual, Common Law, or Live-In Partner</option>
                                                <option value="Legally Separated" {{($viewcaseformPerso[0]->civil_status === 'Legally Separated') ? 'Selected' : ''}}>Legally Separated</option>
                                                <option value="Separated in Fact" {{($viewcaseformPerso[0]->civil_status === 'Separated in Fact') ? 'Selected' : ''}}>Separated in Fact</option>
                                                <option value="Windowed" {{($viewcaseformPerso[0]->civil_status === 'Windowed') ? 'Selected' : ''}}>Windowed</option>
                                                <option value="Anulled" {{($viewcaseformPerso[0]->civil_status === 'Anulled') ? 'Selected' : ''}}>Anulled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Is the client a person with diverse SOGIE:<span class="asterisk">*</span></p></span>
                                            <select name="client_diverse_sogie" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Yes" {{($viewcaseformPerso[0]->client_diverse_sogie === 'Yes') ? 'Selected' : ''}}>Yes</option>
                                                <option value="No" {{($viewcaseformPerso[0]->client_diverse_sogie === 'No') ? 'Selected' : ''}}>No</option>
                                            </select>
                                        </div>
                                        <div class="col"><span><p class="card-text">Educational Attainment:<span class="asterisk">*</span></p></span>
                                            <select name="education" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="No Formal Education" {{($viewcaseformPerso[0]->education === 'No Formal Education') ? 'Selected' : ''}}>No Formal Education</option>
                                                <option value="Elementary Level/Graduate" {{($viewcaseformPerso[0]->education === 'Elementary Level/Graduate') ? 'Selected' : ''}}>Elementary Level/Graduate</option>
                                                <option value="Junior High School Level/Graduate" {{($viewcaseformPerso[0]->education === 'Junior High School Level/Graduate') ? 'Selected' : ''}}>Junior High School Level/Graduate</option>
                                                <option value="Senior High School Level/Graduate" {{($viewcaseformPerso[0]->education === 'Senior High School Level/Graduate') ? 'Selected' : ''}}>Senior High School Level/Graduate</option>
                                                <option value="Technical/Vocational" {{($viewcaseformPerso[0]->education === 'Technical/Vocational') ? 'Selected' : ''}}>Technical/Vocational</option>
                                                <option value="College Level/Graduate" {{($viewcaseformPerso[0]->education === 'College Level/Graduate') ? 'Selected' : ''}}>College Level/Graduate</option>
                                                <option value="Post Graduate" {{($viewcaseformPerso[0]->education === 'Post Graduate') ? 'Selected' : ''}}>Post Graduate</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Religion<span class="asterisk">*</span></p></span>
                                            <select id="religion" name="religion" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                @if($viewcaseformPerso[0]->religion == null)
                                                <option value="">Please Select</option>
                                                @foreach($religions as $religion)
                                                <option value="{{ $religion->item_name }}">{{ $religion->item_name }}</option>
                                                @endforeach
                                                <option value="Others">Others</option>
                                                @else
                                                <option value="{{ $viewcaseformPerso[0]->religion }}" selected>{{ $viewcaseformPerso[0]->religion }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->religion_if_oth_pls_spec }}" name="religion_if_oth_pls_spec" placeholder="" class="w-100 form-control religionInput" id="inputRel" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">    
                                        <div class="col"><span><p class="card-text">Nationality<span class="asterisk">*</span></p></span>
                                            <select id="nationality" name="nationality" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Filipino" {{($viewcaseformPerso[0]->nationality === 'Filipino') ? 'Selected' : ''}}>Filipino</option>
                                                <option value="Others" {{($viewcaseformPerso[0]->nationality === 'Others') ? 'Selected' : ''}}>Others</option>
                                            </select>
                                        </div>
                                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->nationality_if_oth_pls_spec}}" name="nationality_if_oth_pls_spec" placeholder="" class="w-100 form-control nationalityInput" id="inputNa" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3"> 
                                        <div class="col"><span><p class="card-text">Ethnicity<span class="asterisk">*</span></p></span>
                                            <select id="ethnicity" name="ethnicity" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Bisaya" {{($viewcaseformPerso[0]->ethnicity === 'Bisaya') ? 'Selected' : ''}}>Bisaya</option>
                                                <option value="Ilongo" {{($viewcaseformPerso[0]->ethnicity === 'Ilongo') ? 'Selected' : ''}}>Ilongo</option>
                                                <option value="Iranon" {{($viewcaseformPerso[0]->ethnicity === 'Iranon') ? 'Selected' : ''}}>Iranon</option>
                                                <option value="Maguindanaon" {{($viewcaseformPerso[0]->ethnicity === 'Maguindanaon') ? 'Selected' : ''}}>Maguindanaon</option>
                                                <option value="Meranao" {{($viewcaseformPerso[0]->ethnicity === 'Meranao') ? 'Selected' : ''}}>Meranao</option>
                                                <option value="Teduray" {{($viewcaseformPerso[0]->ethnicity === 'Teduray') ? 'Selected' : ''}}>Teduray</option>
                                                <option value="Tausug" {{($viewcaseformPerso[0]->ethnicity === 'Tausug') ? 'Selected' : ''}}>Tausug</option>
                                                <option value="Others" {{($viewcaseformPerso[0]->ethnicity === 'Others') ? 'Selected' : ''}}>Others</option>
                                            </select>
                                        </div>
                                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->ethnicity_if_oth_pls_spec}}" name="ethnicity_if_oth_pls_spec" placeholder="" class="w-100 form-control ethnicityInput" id="inputEth" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3"> 
                                        <div class="col"><span><p class="card-text">Employment Status:<span class="asterisk">*</span></p></span>
                                            <select id="employment_status" name="employment_status" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option>Please Select</option>
                                                <option value="Employed" {{($viewcaseformPerso[0]->employment_status === 'Employed') ? 'Selected' : ''}}>Employed</option>
                                                <option value="Self-Employed" {{($viewcaseformPerso[0]->employment_status === 'Self-Employed') ? 'Selected' : ''}}>Self-Employed</option>
                                                <option value="Unemployed" {{($viewcaseformPerso[0]->employment_status === 'Unemployed') ? 'Selected' : ''}}>Unemployed</option>
                                            </select>
                                        </div>
                                        <div class="col"><span><p class="card-text">If Employed or Self-Employed: Please Indicate</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->if_self_emp_pls_ind}}" id="if_self_emp_pls_ind" name="if_self_emp_pls_ind" placeholder="" class="w-100 form-control selfemployedInput" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><span><p class="card-text">Current Address</p></span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Household No.</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->house_hold_no}}" name="house_hold_no" class="form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Street</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->street}}" name="street" class="w-100 form-control" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                                            <select id="edit_region" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                    <option value="{{$viewcaseformPerso[0]->region}}" selected>{{$viewcaseformPerso[0]->region}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_region_id" name="region" value="{{$viewcaseformPerso[0]->region}}"/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                                            <select id="edit_province" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformPerso[0]->province}}" selected>{{$viewcaseformPerso[0]->province}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_province_id" name="province" value="{{$viewcaseformPerso[0]->province}}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                         <div class="col"><span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                                            <select id="edit_city" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformPerso[0]->city}}" selected>{{$viewcaseformPerso[0]->city}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_city_id" name="city" value="{{$viewcaseformPerso[0]->city}}"/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                                            <select id="edit_barangay" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformPerso[0]->barangay}}" selected>{{$viewcaseformPerso[0]->barangay}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_barangay_id" name="barangay" value="{{$viewcaseformPerso[0]->barangay}}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><span><p class="card-text">Is IDP?<span class="asterisk">*</span></p></span>
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_idp" id="is_idp_yes_radio" value="Yes" {{($viewcaseformPerso[0]->is_idp === 'Yes') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="is_idp_yes_radio">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_idp" id="is_idp_no_radio" value="No" {{($viewcaseformPerso[0]->is_idp === 'No') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="is_idp_no_radio">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3"><span><p class="card-text">Is PWD?<span class="asterisk">*</span></p></span>
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input ispwd" type="radio" name="is_pwd" id="is_pwd_yes_radio" value="Yes" {{($viewcaseformPerso[0]->is_pwd === 'Yes') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="is_pwd_yes_radio">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input ispwd" type="radio" name="is_pwd" id="is_pwd_no_radio" value="No" {{($viewcaseformPerso[0]->is_pwd === 'No') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="is_pwd_no_radio">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col"><span><p class="card-text">If PWD, please specify</p></span>
                                            <input type="text" value="{{$viewcaseformPerso[0]->if_pwd_pls_specify}}" id="if_pwd_pls_specify" name="if_pwd_pls_specify" placeholder="" class="w-100 form-control ifpwdInput" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><span><p class="card-text">Contact Information:</p></span></div>
                                        <div class="col-md-9 form-floating">
                                            <textarea class="form-control" name="per_det_cont_info" id="floatingTextarea2" disabled>{{$viewcaseformPerso[0]->per_det_cont_info}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-dark my-3" />
                            <input type="button" name="next" class="next btn btn-danger btn-md px-5 mx-1 float-end" value="Next" />
                        </fieldset>
{{-- FAMILY BACKGROUND --}}
                        <fieldset>
                            <div class="card border-light shadow-lg">
                                <div class="p-3">Family Background</div>
                                <hr class="bg-dark my-3" />
                                <div class="card-body">
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Name of Parent or Guardian:<span class="asterisk">*</span></p></span>
                                            <input type="text" value="{{$viewcaseformFambac[0]->name_par_guar }}" class="w-50 form-control" name="name_par_guar" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Occupation:<span class="asterisk">*</span></p></span>
                                            <input type="text" value="{{$viewcaseformFambac[0]->job_vict_sur }}" class="w-100 form-control" name="job_vict_sur" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Age:<span class="asterisk">*</span></p></span>
                                            <input type="number" value="{{$viewcaseformFambac[0]->age_vict_sur }}" class="w-50 form-control" name="age_vict_sur" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col"><span><p class="card-text">Relationship to the Victim-Survivor:<span class="asterisk">*</span></p></span>
                                            <select id="relvic" name="rel_vict_sur" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                @if($viewcaseformFambac[0]->rel_vict_sur == null)
                                                <option value="">Please Select</option>
                                                @foreach($relationship_to_victim_survivors as $relationship_to_victim_survivor)
                                                <option value="{{ $relationship_to_victim_survivor->item_name }}">{{ $relationship_to_victim_survivor->item_name }}</option>
                                                @endforeach
                                                <option value="Other Relatives, Specify:">Other Relatives, Specify:</option>
                                                @else
                                                <option value="{{ $viewcaseformFambac[0]->rel_vict_sur }}" selected>{{ $viewcaseformFambac[0]->rel_vict_sur ?? 'Please Select'}}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">If Others, please specify:</p></span>
                                            <input type="text" value="{{$viewcaseformFambac[0]->rttvs_if_oth_pls_spec }}" class="w-100 form-control relvicInput" name="rttvs_if_oth_pls_spec" id="inputRelvic" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><span><p class="card-text">Address</p></span></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Household No.</p></span>
                                            <input type="text" value="{{$viewcaseformFambac[0]->fam_back_house_no }}" name="fam_back_house_no" class="form-control" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Street</p></span>
                                            <input type="text" value="{{$viewcaseformFambac[0]->fam_back_street }}" class="w-100 form-control" name="fam_back_street" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col"><span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                                            <select id="edit_fam_back_region" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformFambac[0]->fam_back_region}}" selected>{{$viewcaseformFambac[0]->fam_back_region}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_fam_back_region_id" name="fam_back_region" value="{{$viewcaseformFambac[0]->fam_back_region}}"/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                                            <select id="edit_fam_back_province" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformFambac[0]->fam_back_province}}" selected>{{$viewcaseformFambac[0]->fam_back_province}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_fam_back_province_id" name="fam_back_province" value="{{$viewcaseformFambac[0]->fam_back_province}}"/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col"><span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                                            <select id="edit_fam_back_city" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformFambac[0]->fam_back_city}}" selected>{{$viewcaseformFambac[0]->fam_back_city}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_fam_back_city_id" name="fam_back_city" value="{{$viewcaseformFambac[0]->fam_back_city}}"/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                                            <select id="edit_fam_back_barangay" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformFambac[0]->fam_back_barangay}}" selected>{{$viewcaseformFambac[0]->fam_back_barangay}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_fam_back_barangay_id" name="fam_back_barangay" value="{{$viewcaseformFambac[0]->fam_back_barangay}}"/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-5"><p class="card-text">Contact Number:<span class="asterisk">*</span></p>
                                            <input type="text" value="{{$viewcaseformFambac[0]->fam_back_cont_num }}" class="w-100 form-control" name="fam_back_cont_num" disabled/>
                                        </div>
                                    </div>
                                    
                                    <hr class="bg-dark my-3" />
                                    <div class="card-header">
                                        <span class="card-title h6 font-weight-bold">Additional Family Background Table</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover no-footer">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Name of Parent or Guardian</th>
                                                    <th scope="col">Relationship to the Victim-Survivor</th>
                                                    <th scope="col">Age</th>
                                                    <th scope="col">Occupation</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Contact Information</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fam_back_table_tbody">
                                                @if(count($family_background_infos) === 0)
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                @else
                                                @foreach($family_background_infos as $family_background_info)
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#fam_back_modal" onclick="getSpecificAdditionalFamilyBackgroundForm({{ $family_background_info->id }}, `View`)"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>{{ $family_background_info->name_par_guar_modal ?? '-' }}</td>
                                                    <td>{{ $family_background_info->rel_vict_sur_modal ?? '-' }}</td>
                                                    <td>{{ $family_background_info->age_vict_sur_modal ?? '-' }}</td>
                                                    <td>{{ $family_background_info->job_vict_sur_modal ?? '-' }}</td>
                                                    <td>{{ $family_background_info->fam_back_house_no_modal }} {{ $family_background_info->fam_back_street_modal }} {{ $family_background_info->fam_back_barangay_modal }} {{ $family_background_info->fam_back_city_modal ?? '-'}}</td>
                                                    <td>{{ $family_background_info->fam_back_cont_num_modal ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-dark my-3" />
                            <input type="button" name="next" class="next btn btn-danger btn-md px-5 mx-1 float-end" value="Next" />
                            <input type="button" name="previous" class="previous btn btn-secondary btn-md px-5 mx-1 float-end" value="Back" />

                        </fieldset>
{{-- INCIDENCE DETAILS --}}
                        <fieldset>
                            <div class="card border-light shadow-lg">
                                <div class="p-3">Incidence Details</div>
                                <hr class="bg-dark my-3" />
                                <div class="card-body">  
                            
                                    <div class="row">
                                        <div class="col-md-4"><p class="card-text">Date of Intake:<span class="asterisk">*</span></p></div>
                                        <div class="col-md-8"><input type="date" class="w-100 form-control" name="id_date_int" value="{{ $viewcaseformInci[0]->id_date_int }}" disabled/></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-4"><p class="card-text">Name of Interviewer:<span class="asterisk">*</span></p></div>
                                        <div class="col-md-8"><input type="text" value="{{ $viewcaseformInci[0]->id_name_intervi }}" class="w-100 form-control" name="id_name_intervi" disabled/></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-4"><p class="card-text">Position/Designation of Interviewer:<span class="asterisk">*</span></p></div>
                                        <div class="col-md-8"><input type="text" value="{{ $viewcaseformInci[0]->id_pos_desi_int }}" class="w-100 form-control" name="id_pos_desi_int" disabled/></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><span><p class="card-text">Nature of Incidence:<span class="asterisk">*</span></p></span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><input type="checkbox" name="id_int_part_vio" value="Intimate partner violence" {{($viewcaseformInci[0]->id_int_part_vio === 'Intimate partner violence') ? 'Checked' : ''}} disabled/>
                                            <span class="card-text">Intimate partner violence</span>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col"></div>
                                        <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_ipv_phys" value="Physical" {{($viewcaseformInci[0]->id_ipv_phys === 'Physical') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Physical
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_ipv_sexual" value="Sexual" {{($viewcaseformInci[0]->id_ipv_sexual  === 'Sexual') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Sexual
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_ipv_psycho" value="Psychological" {{($viewcaseformInci[0]->id_ipv_psycho  === 'Psychological') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Psychological
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_ipv_econo" value="Economic" {{($viewcaseformInci[0]->id_ipv_econo  === 'Economic') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Economic
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><input type="checkbox" name="id_rape" value="Rape" {{($viewcaseformInci[0]->id_rape  === 'Rape') ? 'Checked' : ''}} disabled/>
                                            <span class="card-text">Rape</span></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col"></div>
                                        <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_rape_incest" value="Incest" {{($viewcaseformInci[0]->id_rape_incest  === 'Incest') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Incest
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_rape_sta_rape" value="Statutory Rape" {{($viewcaseformInci[0]->id_rape_sta_rape  === 'Statutory Rape') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Statutory Rape
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_rape_sex_int" value="Rape by Sexual Intercourse" {{($viewcaseformInci[0]->id_rape_sex_int  === 'Rape by Sexual Intercourse') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Rape by Sexual Intercourse
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_rape_sex_assa" value="Rape by Sexual Assault" {{($viewcaseformInci[0]->id_rape_sex_assa  === 'Rape by Sexual Assault') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Rape by Sexual Assault
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_rape_mar_rape" value="Marital Rape" {{($viewcaseformInci[0]->id_rape_mar_rape  === 'Marital Rape') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Marital Rape
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><input type="checkbox" name="id_traf_per" value="Trafficking in Person" {{($viewcaseformInci[0]->id_traf_per  === 'Trafficking in Person') ? 'Checked' : ''}} disabled/>
                                            <span class="card-text">Trafficking in Person</span></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_traf_per_sex_exp" value="Sexual Exploitation" {{($viewcaseformInci[0]->id_traf_per_sex_exp  === 'Sexual Exploitation') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Sexual Exploitation
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_traf_per_onl_exp" value="Online Exploitation"  {{($viewcaseformInci[0]->id_traf_per_onl_exp  === 'Online Exploitation') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Online Exploitation
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_traf_per_others" value="Others" {{($viewcaseformInci[0]->id_traf_per_others  === 'Others') ? 'Checked' : ''}} id="trafPer" onchange="trafPers()" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Others
                                                </label>
                                                <span><input type="text" value="{{$viewcaseformInci[0]->id_traf_per_others_spec }}" class="w-100 form-control" placeholder="Please specify" name="id_traf_per_others_spec" id="inputTrafper" disabled/></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_traf_per_forc_lab" value="Forced Labor" {{($viewcaseformInci[0]->id_traf_per_forc_lab === 'Forced Labor') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Forced Labor
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_traf_per_srem_org" value="Sale or Removal of Organs" {{($viewcaseformInci[0]->id_traf_per_srem_org === 'Sale or Removal of Organs') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Sale or Removal of Organs
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_traf_per_prost" value="Prostitution" {{($viewcaseformInci[0]->id_traf_per_prost === 'Prostitution') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Prostitution
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><input type="checkbox" name="id_sex_hara" value="Sexual Harassment" {{($viewcaseformInci[0]->id_sex_hara === 'Sexual Harassment') ? 'Checked' : ''}} disabled/>
                                            <span class="card-text">Sexual Harassment</span>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_sex_hara_ver" value="Verbal" {{($viewcaseformInci[0]->id_sex_hara_ver === 'Verbal') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Verbal
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_sex_hara_others" value="Others" {{($viewcaseformInci[0]->id_sex_hara_others === 'Others') ? 'Checked' : ''}} id="sexHa" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Others
                                                </label>
                                                <span><input type="text" value="{{$viewcaseformInci[0]->id_sex_hara_others_spec }}" class="w-100 form-control" placeholder="Please specify" name="id_sex_hara_others_spec" id="inputSexHa" disabled/></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_sex_hara_phys" value="Physical" {{($viewcaseformInci[0]->id_sex_hara_phys === 'Physical') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Physical
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_sex_hara_use_obj" value="Use of Object, Letters, or Notes with Sexual Undeskpinning" {{($viewcaseformInci[0]->id_sex_hara_use_obj === 'Use of Object, Letters, or Notes with Sexual Undeskpinning') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Use of Object, Letters, or Notes with Sexual Undeskpinning
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><input type="checkbox" name="id_chi_abu" value="Child Abuse, Exploitation and Discrimination" {{($viewcaseformInci[0]->id_chi_abu === 'Child Abuse, Exploitation and Discrimination') ? 'Checked' : ''}} disabled/>
                                            <span class="card-text">Child Abuse, Exploitation and Discrimination</span></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_chi_abu_efpaccp" value="Engage, Facilitate, Promote, or Attempt to Commit Child Prostitution" {{($viewcaseformInci[0]->id_chi_abu_efpaccp === 'Engage, Facilitate, Promote, or Attempt to Commit Child Prostitution') ? 'Checked' : ''}} id="flexCheckDefault" disabled/>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Engage, Facilitate, Promote, or Attempt to Commit Child Prostitution
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_chi_abu_lasc_cond" value="Lascivious Conduct" {{($viewcaseformInci[0]->id_chi_abu_lasc_cond === 'Lascivious Conduct') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Lascivious Conduct
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_chi_abu_others" value="Others" {{($viewcaseformInci[0]->id_chi_abu_others === 'Others') ? 'Checked' : ''}} id="chiAed" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Others
                                                </label>
                                                <span><input type="text" class="w-100 form-control" placeholder="Please specify" name="id_chi_abu_others_spec"  id="inputchiAed" value="{{$viewcaseformInci[0]->id_chi_abu_others_spec}}" disabled/></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_chi_abu_sex_int" value="Sexual Intercourse" {{($viewcaseformInci[0]->id_chi_abu_sex_int === 'Sexual Intercourse') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Sexual Intercourse
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="id_chi_abu_phys_abu" value="Physical Abuse" {{($viewcaseformInci[0]->id_chi_abu_phys_abu === 'Physical Abuse') ? 'Checked' : ''}} id="flexCheckChecked" disabled/>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Physical Abuse
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><p class="card-text">Description of the Incident<span class="asterisk">*</span></p></div>
                                        <div class="col-md-9 form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here" name="id_descr_inci" id="floatingTextarea2" rows="14" disabled>{{$viewcaseformInci[0]->id_descr_inci}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Date of Incidence:<span class="asterisk">*</span></p></span>
                                            <input type="date" class="w-100 form-control" name="id_date_of_inci" value="{{$viewcaseformInci[0]->id_date_of_inci }}" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Time of Incident:</p></span>
                                            <input type="time" class="w-100 form-control" name="id_time_of_inci" value="{{$viewcaseformInci[0]->id_time_of_inci }}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><span><p class="card-text">Location of Incidence:</p></span></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col"><span><p class="card-text">Household No.</p></span>
                                            <input type="text" value="{{$viewcaseformInci[0]->inci_det_house_no }}" name="inci_det_house_no" class="form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Street</p></span>
                                            <input type="text" class="w-100 form-control" value="{{$viewcaseformInci[0]->inci_det_street }}" name="inci_det_street" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                                            <select id="edit_inci_det_region" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformInci[0]->inci_det_region}}" selected>{{$viewcaseformInci[0]->inci_det_region}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_inci_det_region_id" name="inci_det_region" value="{{$viewcaseformInci[0]->inci_det_region}}"/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                                            <select id="edit_inci_det_province" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformInci[0]->inci_det_province}}" selected>{{$viewcaseformInci[0]->inci_det_province}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_inci_det_province_id" name="inci_det_province" value="{{$viewcaseformInci[0]->inci_det_province}}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                                            <select id="edit_inci_det_city" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformInci[0]->inci_det_city}}" selected>{{$viewcaseformInci[0]->inci_det_city}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_inci_det_city_id" name="inci_det_city" value="{{$viewcaseformInci[0]->inci_det_city}}"/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                                            <select id="edit_inci_det_barangay" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformInci[0]->inci_det_barangay}}" selected>{{$viewcaseformInci[0]->inci_det_barangay}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_inci_det_barangay_id" name="inci_det_barangay" value="{{$viewcaseformInci[0]->inci_det_barangay}}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Place of Incidence:<span class="asterisk">*</span></p></span>
                                            <select id="placeinci" name="id_pla_of_inci" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                @if($viewcaseformInci[0]->id_pla_of_inci == null)
                                                <option value="">Please Select</option>
                                                @foreach($place_of_incidences as $place_of_incidence)
                                                <option value="{{ $place_of_incidence->item_name }}">{{ $place_of_incidence->item_name }}</option>
                                                @endforeach
                                                <option value="Others">Others</option>
                                                @else
                                                <option value="{{ $viewcaseformInci[0]->id_pla_of_inci }}" selected>{{ $viewcaseformInci[0]->id_pla_of_inci }}</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                                            <input type="text" value="{{$viewcaseformInci[0]->id_pi_oth_pls_spec }}" name="id_pi_oth_pls_spec" placeholder="" class="w-100 form-control placeInci" id="inputplaceInci" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><p class="card-text">Was the incident Perpetuated Online?:<span class="asterisk">*</span></p></div>
                                        <div class="col-md-3">
                                            <select name="id_was_inc_perp_onl" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Yes" {{($viewcaseformInci[0]->id_was_inc_perp_onl === 'Yes') ? 'Selected' : '' }}>Yes</option>
                                                <option value="No" {{($viewcaseformInci[0]->id_was_inc_perp_onl === 'No') ? 'Selected' : '' }}>No</option>
                                            </select>   
                                        </div>
                                    </div>

                                    <hr class="bg-dark my-3" />
                                    <div class="card-header">
                                        <span class="card-title h6 font-weight-bold">Additional Incidence Details Table</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover no-footer">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Place</th>
                                                    <th scope="col">Nature of Incident</th>
                                                    <th scope="col">Description of the Incident</th>
                                                </tr>
                                            </thead>
                                            <tbody id="inci_det_table_tbody">
                                                @if(count($incidence_detail_infos) === 0)
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                @else
                                                @foreach($incidence_detail_infos as $incidence_detail_info)
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalIncidenceDetails" onclick="getSpecificAdditionalIncidenceDetailsForm({{ $incidence_detail_info->id }}, `View`)"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>{{ $incidence_detail_info->id_date_of_inci_modal ?? '-' }}</td>
                                                    <td>{{ $incidence_detail_info->id_pla_of_inci_modal ?? '-' }}</td>
                                                    <td>{{ $incidence_detail_info->id_int_part_vio_modal ?? ''}} {{ $incidence_detail_info->id_rape_modal ?? ''}} {{ $incidence_detail_info->id_traf_per_modal ?? ''}} {{ $incidence_detail_info->id_sex_hara_modal ?? ''}} {{ $incidence_detail_info->id_chi_abu_modal ?? ''}}</td>
                                                    <td>{{ $incidence_detail_info->id_descr_inci_modal ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                {{-- Results on this part is manipulated in "public/js/scripts.js" file --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-dark my-3" />
                            <input type="button" name="next" class="next btn btn-danger btn-md px-5 mx-1 float-end" value="Next" />
                            <input type="button" name="previous" class="previous btn btn-secondary btn-md px-5 mx-1 float-end" value="Back" />

                        </fieldset>
{{-- PERPETRATOR DETAILS --}}
                        <fieldset>
                            <div class="card border-light shadow-lg">
                                <div class="p-3">Perpetrator Details</div>
                                <hr class="bg-dark mb-3" />
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <span><p class="card-text">Last Name<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" value="{{$viewcaseformPerpet[0]->perp_d_last_name }}" name="perp_d_last_name" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">First Name<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" value="{{$viewcaseformPerpet[0]->perp_d_first_name }}" name="perp_d_first_name" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Middle Name<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" value="{{$viewcaseformPerpet[0]->perp_d_middle_name }}" name="perp_d_middle_name" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <span><p class="card-text">Extension</p></span>
                                            <input type="text" class="w-50 form-control" value="{{$viewcaseformPerpet[0]->perp_d_extension_name }}" name="perp_d_extension_name" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Nickname/Alias</p></span>
                                            <input type="text" class="w-50 form-control" value="{{$viewcaseformPerpet[0]->perp_d_alias_name }}" name="perp_d_alias_name" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-1">
                                            <p class="card-text">Sex:<span class="asterisk">*</span></p>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="perp_d_sex_radio" id="perp_d_sex_male_radio" value="Male" {{($viewcaseformPerpet[0]->perp_d_sex_radio === 'Male') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="perp_d_sex_male_radio">Male</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="perp_d_sex_radio" id="perp_d_sex_female_radio" value="Female" {{($viewcaseformPerpet[0]->perp_d_sex_radio === 'Female') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="perp_d_sex_female_radio">Female</label>
                                                </div>
                                                @if($cases_details[0]->form_status == 'Submitted')
                                                <input type="hidden" name="perp_d_sex_radio" value="{{$viewcaseformPerpet[0]->perp_d_sex_radio}}" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <span><p class="card-text">Birthdate:<span class="asterisk">*</span></p></span>
                                            <input type="date" class="w-100 form-control" name="perp_d_birthdate" value="{{$viewcaseformPerpet[0]->perp_d_birthdate}}" disabled/>
                                        </div>
                                        <div class="col-md-3">
                                            <span><p class="card-text">Age:<span class="asterisk">*</span></p></span>
                                            <input type="number" class="w-100 form-control" name="perp_d_age" value="{{$viewcaseformPerpet[0]->perp_d_age }}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <span><p class="card-text">Relationship to the Victim-Survivor:<span class="asterisk">*</span></p></span>
                                            <select id="relvicsur" name="perp_d_rel_victim" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                @if($viewcaseformPerpet[0]->perp_d_rel_victim == null)
                                                <option value="">Please Select</option>
                                                @foreach($relationship_to_victim_survivors as $relationship_to_victim_survivor)
                                                <option value="{{ $relationship_to_victim_survivor->item_name }}">{{ $relationship_to_victim_survivor->item_name }}</option>
                                                @endforeach
                                                <option value="Other Relatives, Specify:">Other Relatives, Specify:</option>
                                                @else    
                                                <option value="{{ $viewcaseformPerpet[0]->perp_d_rel_victim }}" selected>{{ $viewcaseformPerpet[0]->perp_d_rel_victim }}</option>
                                                @endif
                                            </select>
                                            @if($cases_details[0]->form_status == 'Submitted')
                                            <input type="hidden" name="perp_d_rel_victim" value="{{$viewcaseformPerpet[0]->perp_d_rel_victim}}" disabled/>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">If Other, please specify:</p></span>
                                            <input type="text" class="w-100 form-control relVicsur" value="{{$viewcaseformPerpet[0]->perp_d_rel_vic_pls_spec }}" id="inputrelvicsur" name="perp_d_rel_vic_pls_spec" disabled />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span><p class="card-text">Occupation:<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" value="{{$viewcaseformPerpet[0]->perp_d_occup }}" name="perp_d_occup" disabled/>
                                        </div>
                                        <div class="col-md-6">
                                            <span><p class="card-text">Educational Attainment:<span class="asterisk">*</span></p></span>
                                            <select name="perp_d_educ_att" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="No Formal Education" {{($viewcaseformPerpet[0]->perp_d_educ_att === 'No Formal Education') ? 'Selected' : ''}}>No Formal Education</option>
                                                <option value="Elementary Level/Graduate" {{($viewcaseformPerpet[0]->perp_d_educ_att === 'Elementary Level/Graduate') ? 'Selected' : ''}}>Elementary Level/Graduate</option>
                                                <option value="Junior High School Level/Graduate" {{($viewcaseformPerpet[0]->perp_d_educ_att === 'Junior High School Level/Graduate') ? 'Selected' : ''}}>Junior High School Level/Graduate</option>
                                                <option value="Senior High School Level/Graduate" {{($viewcaseformPerpet[0]->perp_d_educ_att === 'Senior High School Level/Graduate') ? 'Selected' : ''}}>Senior High School Level/Graduate</option>
                                                <option value="Technical/Vocational" {{($viewcaseformPerpet[0]->perp_d_educ_att === 'Technical/Vocational') ? 'Selected' : ''}}>Technical/Vocational</option>
                                                <option value="College Level/Graduate" {{($viewcaseformPerpet[0]->perp_d_educ_att === 'College Level/Graduate') ? 'Selected' : ''}}>College Level/Graduate</option>
                                                <option value="Post Graduate" {{($viewcaseformPerpet[0]->perp_d_educ_att === 'Post Graduate') ? 'Selected' : ''}}>Post Graduate</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Nationality<span class="asterisk">*</span></p></span>
                                            <select id="narelvicsur" name="perp_d_nationality" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Filipino" {{($viewcaseformPerpet[0]->perp_d_nationality === 'Filipino') ? 'Selected' : ''}}>Filipino</option>
                                                <option value="Others" {{($viewcaseformPerpet[0]->perp_d_nationality === 'Others') ? 'Selected' : ''}}>Others</option>
                                            </select>
                                            @if($cases_details[0]->form_status == 'Submitted')
                                            <input type="hidden" name="perp_d_nationality" value="{{$viewcaseformPerpet[0]->perp_d_nationality}}" />
                                            @endif
                                        </div>
                                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                                            <input type="text" value="{{$viewcaseformPerpet[0]->perp_d_nat_if_oth_pls_spec }}" name="perp_d_nat_if_oth_pls_spec" placeholder="" class="w-100 form-control narelVicsur" id="nainputrelvicsur" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Religion<span class="asterisk">*</span></p></span>
                                            <select id="rerelvicsur" name="perp_d_religion" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                @if($viewcaseformPerpet[0]->perp_d_religion == null)
                                                <option value="">Please Select</option>
                                                @foreach($religions as $religion)
                                                <option value="{{ $religion->item_name }}">{{ $religion->item_name }}</option>
                                                @endforeach
                                                <option value="Others">Others</option>
                                                @else
                                                <option value="{{ $viewcaseformPerpet[0]->perp_d_religion }}" selected>{{ $viewcaseformPerpet[0]->perp_d_religion }}</option>
                                                @endif
                                            </select>
                                            @if($cases_details[0]->form_status == 'Submitted')
                                            <input type="hidden" name="perp_d_religion" value="{{$viewcaseformPerpet[0]->perp_d_religion}}" />
                                            @endif
                                        </div>
                                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                                            <input type="text" value="{{$viewcaseformPerpet[0]->perp_d_rel_if_oth_pls_spec }}" name="perp_d_rel_if_oth_pls_spec" placeholder="" class="w-100 form-control rerelVicsur" id="reinputrelvicsur" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><span><p class="card-text">Address</p></span></div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><span><p class="card-text">Household No.</p></span>
                                            <input type="text" value="{{$viewcaseformPerpet[0]->perp_d_house_no }}" name="perp_d_house_no" class="form-control" disabled/>
                                        </div>
                                        <div class="col"><span><p class="card-text">Street</p></span>
                                            <input type="text" value="{{$viewcaseformPerpet[0]->perp_d_street }}" name="perp_d_street" class="w-100 form-control" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                                            <select id="edit_perp_d_region" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformPerpet[0]->perp_d_region}}" selected>{{$viewcaseformPerpet[0]->perp_d_region}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_perp_d_region_id" name="perp_d_region" value="{{$viewcaseformPerpet[0]->perp_d_region}}"/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                                            <select id="edit_perp_d_province" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformPerpet[0]->perp_d_province}}" selected>{{$viewcaseformPerpet[0]->perp_d_province}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_perp_d_province_id" name="perp_d_province" value="{{$viewcaseformPerpet[0]->perp_d_province}}"/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                                            <select id="edit_perp_d_city" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformPerpet[0]->perp_d_city}}" selected>{{$viewcaseformPerpet[0]->perp_d_city}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_perp_d_city_id" name="perp_d_city" value="{{$viewcaseformPerpet[0]->perp_d_city}}"/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                                            <select id="edit_perp_d_barangay" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformPerpet[0]->perp_d_barangay}}" selected>{{$viewcaseformPerpet[0]->perp_d_barangay}}</option>
                                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                                            </select>
                                            <input type="hidden" id="edit_perp_d_barangay_id" name="perp_d_barangay" value="{{$viewcaseformPerpet[0]->perp_d_barangay}}"/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Current Location<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" name="perp_d_curr_loc" value="{{$viewcaseformPerpet[0]->perp_d_curr_loc}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <p class="card-text">Is Perpetrator Minor?:<span class="asterisk">*</span></p>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input perp_d_is_perp_minor" type="radio" name="perp_d_is_perp_minor" id="perp_d_is_pm_yes_radio" value="Yes" {{($viewcaseformPerpet[0]->perp_d_is_perp_minor === 'Yes') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="perp_d_is_pm_yes_radio">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input perp_d_is_perp_minor" type="radio" name="perp_d_is_perp_minor" id="perp_d_is_pm_no" value="No" {{($viewcaseformPerpet[0]->perp_d_is_perp_minor === 'No') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="perp_d_is_pm_no">No</label>
                                                </div>
                                                @if($cases_details[0]->form_status == 'Submitted')
                                                <input type="hidden" name="perp_d_is_perp_minor" value="{{$viewcaseformPerpet[0]->perp_d_is_perp_minor}}" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <span><p class="card-text">If Yes, please indicate the name of parent/guardian:</p></span>
                                            <input type="text" value="{{$viewcaseformPerpet[0]->perp_d_if_yes_pls_ind }}" class="w-100 form-control" name="perp_d_if_yes_pls_ind" id="perp_d_if_yes_pls_ind" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Address of parent/guardian:<span class="asterisk">*</span></p></span>
                                            <input type="text" value="{{$viewcaseformPerpet[0]->perp_d_addr_par_gua }}" class="w-100 form-control" name="perp_d_addr_par_gua" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-5">
                                            <span><p class="card-text">Contact number of parent/guardian:<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" value="{{$viewcaseformPerpet[0]->perp_d_cont_par_gua }}" name="perp_d_cont_par_gua" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Relationship of guardian to Perpetrator:<span class="asterisk">*</span></p></span>
                                            <select id="garrelvicsur" name="perp_d_rel_guar_perp" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Father" {{($viewcaseformPerpet[0]->perp_d_rel_guar_perp === 'Father') ? 'Selected' : ''}}>Father</option>
                                                <option value="Mother" {{($viewcaseformPerpet[0]->perp_d_rel_guar_perp === 'Mother') ? 'Selected' : ''}}>Mother</option>
                                                <option value="Others" {{($viewcaseformPerpet[0]->perp_d_rel_guar_perp === 'Others') ? 'Selected' : ''}}>Others</option>
                                            </select>
                                            @if($cases_details[0]->form_status == 'Submitted')
                                            <input type="hidden" name="perp_d_rel_guar_perp" value="{{$viewcaseformPerpet[0]->perp_d_rel_guar_perp}}" />
                                            @endif
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">If Others, please specify:</p></span>
                                            <input type="text" class="w-100 form-control garrelVicsur" value="{{$viewcaseformPerpet[0]->perp_d_rel_rgp_pls_spec }}" id="garinputrelvicsur" name="perp_d_rel_rgp_pls_spec" disabled/>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3"><p class="card-text">Other Information about the Perpetrator:</p></div>
                                        <div class="col-md-9 form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="perp_d_oth_info_perp" rows="6" disabled>{{$viewcaseformPerpet[0]->perp_d_oth_info_perp }}</textarea>
                                        </div>
                                    </div>

                                    <hr class="bg-dark my-3" />
                                    <div class="card-header">
                                        <span class="card-title h6 font-weight-bold">Additional Perpetrator Details Table</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover no-footer">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Lastname</th>
                                                    <th scope="col">Middle</th>
                                                    <th scope="col">Firstname</th>
                                                    <th scope="col">Age</th>
                                                    <th scope="col">Relationship to Victim</th>
                                                </tr>
                                            </thead>
                                            <tbody id="perp_det_table_tbody">
                                                @if(count($perpetrator_detail_infos) === 0)
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                @else
                                                @foreach($perpetrator_detail_infos as $perpetrator_detail_info)
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalPerpetratorDetailInfos" onclick="getSpecificAdditionalPerpetratorDetailsForm({{ $perpetrator_detail_info->id }}, `View`)"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>{{ $perpetrator_detail_info->perp_d_last_name_modal ?? '-' }}</td>
                                                    <td>{{ $perpetrator_detail_info->perp_d_middle_name_modal ?? '-' }}</td>
                                                    <td>{{ $perpetrator_detail_info->perp_d_first_name_modal ?? '-'}}</td>
                                                    <td>{{ $perpetrator_detail_info->perp_d_age_modal ?? '-' }}</td>
                                                    <td>{{ $perpetrator_detail_info->perp_d_rel_victim_modal ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                {{-- Results on this part is manipulated in "public/js/scripts.js" file --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-dark my-3" />
                            <input type="button" name="next" class="next btn btn-danger btn-md px-5 mx-1 float-end" value="Next" />
                            <input type="button" name="previous" class="previous btn btn-secondary btn-md px-5 mx-1 float-end" value="Back" />

                            
                        </fieldset>
{{-- INTERVENTION MODULE --}}
                        <fieldset>
                            <div class="card border-light shadow-lg">
                                <div class="p-3">Intervention Module</div>
                                <hr class="bg-dark my-3" />
                                <div class="card-body">
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Type of Service<span class="asterisk">*</span></p></span>
                                            <select id="edit_im_type_of_service" name="im_type_of_service" aria-aria-controls='example' class="date-picker w-100 form-control typeofservice" disabled>
                                                @if($viewcaseformInter[0]->im_type_of_service == null)
                                                <option value="">Please Select</option>
                                                @else
                                                <option value="{{$viewcaseformInter[0]->im_type_of_service}}" selected>{{$viewcaseformInter[0]->im_type_of_service}}</option>
                                                @endif
                                                {{-- Drop-down list on this select option is in the "public/js/scripts.js" file --}}
                                            </select>
                                            @if($cases_details[0]->form_status == 'Submitted')
                                            <input type="hidden" class="w-100 form-control" name="im_type_of_service" id="im_type_of_service_id" value="{{$viewcaseformInter[0]->im_type_of_service}}"/>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">If Others, please specify:</p></span>
                                            <input type="text" class="w-100 form-control typeofService" name="im_typ_serv_if_oth_spec" id="inputtypeofService" value="{{$viewcaseformInter[0]->im_typ_serv_if_oth_spec}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Specific Interventions: (Select Type of Service first)<span class="asterisk">*</span></p></span>
                                            <select id="edit_im_speci_interv" name="im_speci_interv" aria-aria-controls='example' class="date-picker w-100 form-control speInt" disabled>
                                                @if($viewcaseformInter[0]->im_speci_interv == null)
                                                <option value="">Please Select</option>
                                                @else
                                                <option value="{{$viewcaseformInter[0]->im_speci_interv}}" selected>{{$viewcaseformInter[0]->im_speci_interv}}</option>
                                                @endif
                                                {{-- Drop-down list on this select option is in the "public/js/scripts.js" file --}}
                                            </select>
                                            @if($cases_details[0]->form_status == 'Submitted')
                                            <input type="hidden" class="w-100 form-control" name="im_speci_interv" id="im_speci_interv_id" value="{{$viewcaseformInter[0]->im_speci_interv}}"/>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">If Others, please specify:</p></span>
                                            <input type="text" class="w-100 form-control speInts" name="im_spe_int_if_oth_spec" id="inputspeInt" value="{{$viewcaseformInter[0]->im_spe_int_if_oth_spec}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Service Provider:<span class="asterisk">*</span></p></span>
                                            <select id="serviceprovider" name="im_serv_prov" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                @if($viewcaseformInter[0]->im_serv_prov == null)
                                                <option value="">Please Select</option>
                                                @foreach($service_providers as $service_provider)
                                                <option value="{{ $service_provider->name }}">{{ $service_provider->name }}</option>
                                                @endforeach
                                                <option value="Others">Others</option>
                                                @else
                                                <option value="{{ $viewcaseformInter[0]->im_serv_prov }}" selected>{{ $viewcaseformInter[0]->im_serv_prov }}</option>
                                                @endif
                                            </select>
                                            @if($cases_details[0]->form_status == 'Submitted')
                                            <input type="hidden" class="w-100 form-control" name="im_serv_prov" id="im_serv_prov_id" value="{{$viewcaseformInter[0]->im_serv_prov}}"/>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">If Others, please specify:</p></span>
                                            <input type="text" id="inputserviceprovider" class="w-100 form-control serviceproviders" name="im_ser_pro_if_oth_spec" value="{{$viewcaseformInter[0]->im_ser_pro_if_oth_spec}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Specific Objective<span class="asterisk">*</span></p></span>
                                            <textarea type="text" class="w-100 form-control" name="im_speci_obje" rows="4" disabled>{{$viewcaseformInter[0]->im_speci_obje}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Target Date<span class="asterisk">*</span></p></span>
                                            <input type="date" class="w-100 form-control" name="im_target_date" value="{{$viewcaseformInter[0]->im_target_date}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Status<span class="asterisk">*</span></p></span>
                                            <select name="im_status" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Provided" {{($viewcaseformInter[0]->im_status === 'Provided') ? 'Selected' : ''}}>Provided</option>
                                                <option value="Not Provided" {{($viewcaseformInter[0]->im_status === 'Not Provided') ? 'Selected' : ''}}>Not Provided</option>
                                                <option value="Ongoing" {{($viewcaseformInter[0]->im_status === 'Ongoing') ? 'Selected' : ''}}>Ongoing</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">If Status is Provided, Provide Date:</p></span>
                                            <input type="date" class="w-100 form-control" name="im_if_status_com_pd" value="{{$viewcaseformInter[0]->im_if_status_com_pd}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Details of Service Provider:</p></span>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Full Name<span class="asterisk">*</span></p></span>
                                            @if($viewcaseformInter[0]->im_dsp_full_name == null)
                                            <input id="im_dsp_full_name" name="im_dsp_full_name" class="w-100 form-control" disabled/>
                                            @else
                                            <select id="im_dsp_full_name" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformInter[0]->im_dsp_full_name}}" selected>{{$viewcaseformInter[0]->im_dsp_full_name}}</option>
                                            </select>
                                            <input type="hidden" class="w-100 form-control" name="im_dsp_full_name" id="im_dsp_full_name_id" value="{{$viewcaseformInter[0]->im_dsp_full_name}}"/>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Position/Designation<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" name="im_dsp_post_desi" id="im_dsp_post_desi" value="{{$viewcaseformInter[0]->im_dsp_post_desi}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Email<span class="asterisk">*</span></p></span>
                                            <input type="email" class="w-100 form-control" name="im_dsp_email" id="im_dsp_email" value="{{$viewcaseformInter[0]->im_dsp_email}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">1st Contact No. (Mobile)<span class="asterisk">*</span></p></span>
                                            <input type="text" class="w-100 form-control" name="im_dsp_contact_no_1" id="im_dsp_contact_no_1" value="{{$viewcaseformInter[0]->im_dsp_contact_no_1}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">2nd Contact No. (Mobile)</p></span>
                                            <input type="text" class="w-100 form-control" name="im_dsp_contact_no_2" id="im_dsp_contact_no_2" value="{{$viewcaseformInter[0]->im_dsp_contact_no_2}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">3rd Contact No. (Landline)</p></span>
                                            <input type="text" class="w-100 form-control" name="im_dsp_contact_no_3" id="im_dsp_contact_no_3" value="{{$viewcaseformInter[0]->im_dsp_contact_no_3}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Details of Alternate Service Provider:</p></span>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Full Name</p></span>
                                            @if($viewcaseformInter[0]->im_dasp_full_name == null)
                                            <input id="im_dasp_full_name" name="im_dasp_full_name" class="w-100 form-control" disabled/>
                                            @else
                                            <select id="im_dasp_full_name" aria-aria-controls='example' class="date-picker w-100 form-control" disabled>
                                                <option value="{{$viewcaseformInter[0]->im_dasp_full_name}}" selected>{{$viewcaseformInter[0]->im_dasp_full_name}}</option>
                                            </select>
                                            <input type="hidden" class="w-100 form-control" name="im_dasp_full_name" id="im_dasp_full_name_id" value="{{$viewcaseformInter[0]->im_dasp_full_name}}"/>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Position/Designation</p></span>
                                            <input type="text" class="w-100 form-control" name="im_dasp_post_desi" id="im_dasp_post_desi" value="{{$viewcaseformInter[0]->im_dasp_post_desi}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Email</p></span>
                                            <input type="email" class="w-100 form-control" name="im_dasp_email" id="im_dasp_email" value="{{$viewcaseformInter[0]->im_dasp_email}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">1st Contact No. (Mobile)</p></span>
                                            <input type="text" class="w-100 form-control" name="im_dasp_contact_no_1" id="im_dasp_contact_no_1" value="{{$viewcaseformInter[0]->im_dasp_contact_no_1}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">2nd Contact No. (Mobile)</p></span>
                                            <input type="text" class="w-100 form-control" name="im_dasp_contact_no_2" id="im_dasp_contact_no_2" value="{{$viewcaseformInter[0]->im_dasp_contact_no_2}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">3rd Contact No. (Landline)</p></span>
                                            <input type="text" class="w-100 form-control" name="im_dasp_contact_no_3" id="im_dasp_contact_no_3" value="{{$viewcaseformInter[0]->im_dasp_contact_no_3}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><h5 class="card-text mt-4">Summary<span class="asterisk">*</span></h5></span>
                                            <textarea id="im_summary" name="im_summary" rows="14" class="w-100 form-control mb-4" disabled>{{$viewcaseformInter[0]->im_summary}}</textarea>
                                        </div>
                                    </div>
                                    
                                    <hr class="bg-dark my-3" />
                                    <div class="card-header">
                                        <span class="card-title h6 font-weight-bold">Recommendation Intervention Program Plan Table</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover no-footer">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Specific Objective</th>
                                                    <th scope="col">Type of Service</th>
                                                    <th scope="col">Intervention Name</th>
                                                    <th scope="col">Target Date</th>
                                                    <th scope="col">Date Status Completed</th>
                                                    <th scope="col">Name of Service Provider</th>
                                                </tr>
                                            </thead>
                                            <tbody id="inter_mod_table_tbody">
                                                @if(count($intervention_module_infos) === 0)
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                                @else
                                                @foreach($intervention_module_infos as $intervention_module_info)
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0)" class="text-orange-icon" data-bs-toggle="modal" data-bs-target="#modalInterventionModuleInfos" onclick="getSpecificAdditionalInterventionModuleForm({{ $intervention_module_info->id }}, `View`)"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>{{ $intervention_module_info->im_speci_obje_modal ?? '-' }}</td>
                                                    <td>{{ $intervention_module_info->im_type_of_service_modal ?? '-' }}</td>
                                                    <td>{{ $intervention_module_info->im_speci_interv_modal ?? '-'}}</td>
                                                    <td>{{ $intervention_module_info->im_target_date_modal ?? '-' }}</td>
                                                    <td>{{ $intervention_module_info->im_if_status_com_pd_modal ?? '-' }}</td>
                                                    <td>{{ $intervention_module_info->im_serv_prov_modal ?? '-' }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                {{-- Results on this part is manipulated in "public/js/scripts.js" file --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <hr class="bg-dark my-3" />
                            <input type="button" name="next" class="next btn btn-danger btn-md px-5 mx-1 float-end" value="Next" />
                            <input type="button" name="previous" class="previous btn btn-secondary btn-md px-5 mx-1 float-end" value="Back" />
                        </fieldset>
{{-- REFERRAL MODULE --}}
                        <fieldset>
                            <div class="card text-bg-light mb-3 shadow-lg">
                                <div class="p-3">Referral Module</div>
                                <hr class="bg-dark my-3" />
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <p class="card-text">Was the client referred by other organization?:<span class="asterisk">*</span></p>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input rm_was_cli_ref_by_org" type="radio" name="rm_was_cli_ref_by_org" id="rm_was_cli_ref_org_yes_radio" value="Yes" {{($viewcaseformRefer[0]->rm_was_cli_ref_by_org === 'Yes') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="rm_was_cli_ref_org_yes_radio">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input rm_was_cli_ref_by_org" type="radio" name="rm_was_cli_ref_by_org" id="rm_was_cli_ref_org_no_radio" value="No" {{($viewcaseformRefer[0]->rm_was_cli_ref_by_org === 'No') ? 'Checked' : ''}} disabled/>
                                                    <label class="form-check-label" for="rm_was_cli_ref_org_no_radio">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md"><p class="card-text">If Yes, Please indicate the details of referring organization:</p>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Name of Referring organization:</p></span>
                                            <input type="text" class="w-100 form-control" name="rm_name_ref_org" id="rm_name_ref_org" value="{{$viewcaseformRefer[0]->rm_name_ref_org}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Referral/Case No. from the referring organization:</p></span>
                                            <input type="text" class="w-100 form-control" name="rm_ref_fro_ref_org" id="rm_ref_fro_ref_org" value="{{$viewcaseformRefer[0]->rm_ref_fro_ref_org}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Address of Referring organization:</p></span>
                                            <input type="text" class="w-100 form-control" name="rm_addr_ref_org" id="rm_addr_ref_org" value="{{$viewcaseformRefer[0]->rm_addr_ref_org}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Referred by:</p></span>
                                            <input type="text" class="w-100 form-control" name="rm_referred_by" id="rm_referred_by" value="{{$viewcaseformRefer[0]->rm_referred_by}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Position title:</p></span>
                                            <input type="text" class="w-100 form-control" name="rm_position_title" id="rm_position_title" value="{{$viewcaseformRefer[0]->rm_position_title}}" disabled/>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col">
                                            <span><p class="card-text">Contact No.:</p></span>
                                            <input type="text" class="w-100 form-control" name="rm_contact_no" id="rm_contact_no" value="{{$viewcaseformRefer[0]->rm_contact_no}}" disabled/>
                                        </div>
                                        <div class="col">
                                            <span><p class="card-text">Email Address:</p></span>
                                            <input type="email" class="w-100 form-control" name="rm_email_add" id="rm_email_add" value="{{$viewcaseformRefer[0]->rm_email_add}}" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-dark my-3" />
                            <input type="button" name="next" class="next btn btn-danger btn-md px-5 mx-1 float-end" value="Next" />
                            <input type="button" name="previous" class="previous btn btn-secondary btn-md px-5 mx-1 float-end" value="Back" />
                        </fieldset>
{{-- CASE MODULE --}}
                        <fieldset>
                            <div class="card border-light shadow-lg">
                                <div class="card-header">Case Module</div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-3"><p class="card-text">Case Status<span class="asterisk">*</span></p>
                                        </div>
                                        <div class="col">
                                            <select name="cm_case_status" aria-aria-controls='example' class="date-picker text-box w-50 form-control" disabled>
                                                <option value="">Please Select</option>
                                                <option value="Ongoing" {{($viewcaseformCaseMod[0]->cm_case_status === 'Ongoing') ? 'Selected' : ''}}>Ongoing</option>
                                                <option value="Completed" {{($viewcaseformCaseMod[0]->cm_case_status === 'Completed') ? 'Selected' : ''}}>Completed</option>
                                                <option value="Closed" {{($viewcaseformCaseMod[0]->cm_case_status === 'Closed') ? 'Selected' : ''}}>Closed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <p class="card-text">Assessment<span class="asterisk">*</span></p>
                                        </div>
                                        <div class="col">
                                            <textarea id="cm_assessment" name="cm_assessment" rows="14" class="w-100 form-control" disabled>{{ $viewcaseformCaseMod[0]->cm_assessment }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <p class="card-text">Recommendation<span class="asterisk">*</span></p>
                                        </div>
                                        <div class="col">
                                            <textarea id="cm_recommendation" name="cm_recommendation" rows="14" class="w-100 form-control" disabled>{{ $viewcaseformCaseMod[0]->cm_recommendation }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <p class="card-text">Remarks<span class="asterisk">*</span></p>
                                        </div>
                                        <div class="col">
                                            <textarea id="cm_remarks" name="cm_remarks" rows="14" class="w-100 form-control" disabled>{{ $viewcaseformCaseMod[0]->cm_remarks }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md">
                                            <div class="card-header mb-3">
                                                <span class="card-title h6 font-weight-bold">Case Responsible Person History</span>
                                            </div>
                                            @foreach($cases_users_activity_logs_accountable_user_usernames as $accountable_user_username)
                                            <li>
                                                @foreach(App\Models\User::where('username','=',$accountable_user_username->accountable_user_username)->get() as $username)
                                                    {{ $username->user_first_name }} {{ $username->user_last_name }} ({{ $username->username }})
                                                @endforeach
                                            </li>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr class="bg-dark my-3" />
                                    <div class="row mb-3">
                                        <div class="col-md">
                                        <div class="card-header">
                                            <span class="card-title h6 font-weight-bold">Uploaded files</span>
                                        </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover no-footer">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                            <th>File Name</th>
                                                            <th>Date Uploaded</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="case_uploaded_files_table_data">
                                                        @if(count(App\Models\CasesUploadedFiles::where('case_no','=',$viewcaseformPerso[0]->case_no)->get()) === 0)
                                                        <tr>
                                                            <td>-</td>
                                                            <td>-</td>
                                                        <tr>
                                                        @else
                                                        @foreach(App\Models\CasesUploadedFiles::where('case_no','=',$viewcaseformPerso[0]->case_no)->get() as $uploaded_files)
                                                        <tr>
                                                            <td><a href="{{ env('APP_URL').$uploaded_files->file_location }}">{{ $uploaded_files->file ?? '-' }}</a></td>
                                                            <td>{{ date_format($uploaded_files->created_at, "Y-m-d") ?? '-' }}</td>
                                                        <tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="bg-dark my-3" />
                            <input type="button" name="previous" class="previous btn btn-secondary btn-md px-5 mx-1 float-end" value="Back" />
                        </fieldset>
                        <center id="error-form">
                            {{-- Result portion for Errors on Form --}}
                        </center>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Start of Modal Forms -->

{{-- ADDITIONAL FAMILY BACKGROUND INFOS --}}

<div class="modal fade" tabindex="-1" id="fam_back_modal" role="dialog" aria-labelledby='myLargeModalLabel' aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <form class="user row" id="fam_back_infos"  method="POST" action="javascript:void(0);" onsubmit="submitAdditionalFamilyBackgroundForm()">
        @csrf
        <div class="modal-dialog modal-xl" style="width:100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Family Member Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row my-3"> 
                        <div class="col"><span><p class="card-text">Name of Parent or Guardian:<span class="asterisk">*</span></p></span>
                        <input type="text" class="w-50 form-control" name="name_par_guar_modal" id="name_par_guar_modal" required/>
                        <input type="hidden" class="w-100 form-control" name="case_no_modal" id="fam_back_case_no_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col"><span><p class="card-text">Occupation:<span class="asterisk">*</span></p></span>
                        <input type="text" class="w-100 form-control" name="job_vict_sur_modal" id="job_vict_sur_modal" required/>
                        </div>
                        <div class="col"><span><p class="card-text">Age:<span class="asterisk">*</span></p></span>
                        <input type="number" class="w-50 form-control" name="age_vict_sur_modal" id="age_vict_sur_modal" required/>
                    </div>
                    </div>
                    <div class="row my-3">
                        <div class="col"><span><p class="card-text">Relationship to the Victim-Survivor:<span class="asterisk">*</span></p></span>
                            <select name="rel_vict_sur_modal" id="rel_vict_sur_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                @foreach($relationship_to_victim_survivors as $relationship_to_victim_survivor)
                                <option value="{{ $relationship_to_victim_survivor->item_name }}">{{ $relationship_to_victim_survivor->item_name }}</option>
                                @endforeach
                                <option value="Other Relatives, Specify:">Other Relatives, Specify:</option>
                            </select>
                        </div>
                        <div class="col"><span><p class="card-text">If Others, please specify:</p></span>
                            <input type="text" class="w-100 form-control relvicInputModal" name="rttvs_if_oth_pls_spec_modal" id="rttvs_if_oth_pls_spec_modal"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3"><span><p class="card-text">Address</p></span></div>
                    </div>
                    <div class="row my-3">
                        <div class="col"><span><p class="card-text">Household No.</p></span>
                            <input type="text" name="fam_back_house_no_modal" id="fam_back_house_no_modal" class="form-control" required/>
                        </div>
                        <div class="col"><span><p class="card-text">Street</p></span>
                            <input type="text" class="w-100 form-control" name="fam_back_street_modal" id="fam_back_street_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col"><span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                            <select id="fam_back_region_modal"  aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" id="fam_back_region_modal_id" name="fam_back_region_modal"/>
                        </div>
                        <div class="col"><span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                            <select id="fam_back_province_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                        </div>
                        <input type="hidden" id="fam_back_province_modal_id" name="fam_back_province_modal"/>
                    </div>
                    <div class="row my-3">
                        <div class="col"><span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                            <select id="fam_back_city_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" id="fam_back_city_modal_id" name="fam_back_city_modal"/>
                        </div>
                        <div class="col"><span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                            <select id="fam_back_barangay_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" id="fam_back_barangay_modal_id" name="fam_back_barangay_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-5"><p class="card-text">Contact Number:<span class="asterisk">*</span></p>
                            <input type="text" class="w-100 form-control" name="fam_back_cont_num_modal" id="fam_back_cont_num_modal" required/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <center id="add-family-background-error-form">
                    {{-- Result portion for Errors on Form --}}
                </center>
            </div>
        </div>
    </form>
</div>

{{-- END ADDITIONAL FAMILY BACKGROUND INFOS --}}

{{-- ADDITIONAL INCEDENCE DETAILS --}}

<div class="modal fade" tabindex="-1" id="modalIncidenceDetails" aria-labelledby='myLargeModalLabel' aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <form class="user row" id="addIncidenceDetailInfos" method="POST" action="javascript:void(0);" onsubmit="submitAdditionalIncidenceDetailsForm()">
    @csrf
        <div class="modal-dialog modal-xl" style="width:100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Incidence Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4"><p class="card-text">Date of Intake:<span class="asterisk">*</span></p></div>
                    <div class="col-md-8"><input type="date" class="w-100 form-control" name="id_date_int_modal" id="id_date_int_modal" required/></div>
                    <input type="hidden" class="w-100 form-control" name="case_no_modal" id="inci_det_case_no_modal"/>
                </div>
                <div class="row my-3">
                    <div class="col-md-4"><p class="card-text">Name of Interviewer:<span class="asterisk">*</span></p></div>
                    <div class="col-md-8"><input type="text" class="w-100 form-control" name="id_name_intervi_modal" id="id_name_intervi_modal" required/></div>
                </div>
                <div class="row my-3">
                    <div class="col-md-4"><p class="card-text">Position/Designation of Interviewer:<span class="asterisk">*</span></p></div>
                    <div class="col-md-8"><input type="text" class="w-100 form-control" name="id_pos_desi_int_modal" id="id_pos_desi_int_modal" required/></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><span><p class="card-text">Nature of Incidence:<span class="asterisk">*</span></p></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col"><input type="checkbox" name="id_int_part_vio_modal"  id="id_int_part_vio_modal" value="Intimate partner violence"/>
                        <span class="card-text">Intimate partner violence</span>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col"></div>
                    <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_ipv_phys_modal" value="Physical" id="id_ipv_phys_modal" />
                            <label class="form-check-label" for="id_ipv_phys_modal">
                                Physical
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_ipv_sexual_modal" value="Sexual"  id="id_ipv_sexual_modal" />
                            <label class="form-check-label" for="id_ipv_sexual_modal">
                                Sexual
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_ipv_psycho_modal" value="Psychological" id="id_ipv_psycho_modal" />
                            <label class="form-check-label" for="id_ipv_psycho_modal">
                                Psychological
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_ipv_econo_modal" value="Economic" id="id_ipv_econo_modal" />
                            <label class="form-check-label" for="id_ipv_econo_modal">
                                Economic
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><input type="checkbox" name="id_rape_modal" id="id_rape_modal" value="Rape" />
                        <span class="card-text">Rape</span></div>
                </div>
                <div class="row my-3">
                    <div class="col"></div>
                    <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_rape_incest_modal" value="Incest" id="id_rape_incest_modal" />
                            <label class="form-check-label" for="id_rape_incest_modal">
                                Incest
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_rape_sta_rape_modal" value="Statutory Rape" id="id_rape_sta_rape_modal" />
                            <label class="form-check-label" for="id_rape_sta_rape_modal">
                                Statutory Rape
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_rape_sex_int_modal" value="Rape by Sexual Intercourse" id="id_rape_sex_int_modal" />
                            <label class="form-check-label" for="id_rape_sex_int_modal">
                                Rape by Sexual Intercourse
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_rape_sex_assa_modal" value="Rape by Sexual Assault" id="id_rape_sex_assa_modal" />
                            <label class="form-check-label" for="id_rape_sex_assa_modal">
                                Rape by Sexual Assault
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_rape_mar_rape_modal" value="Marital Rape" id="id_rape_mar_rape_modal" />
                            <label class="form-check-label" for="id_rape_mar_rape_modal">
                                Marital Rape
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><input type="checkbox" name="id_traf_per_modal" id="id_traf_per_modal" value="Trafficking in Person" />
                        <span class="card-text">Trafficking in Person</span></div>
                </div>
                <div class="row my-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_traf_per_sex_exp_modal" value="Sexual Exploitation" id="id_traf_per_sex_exp_modal" />
                            <label class="form-check-label" for="id_traf_per_sex_exp_modal">
                                Sexual Exploitation
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_traf_per_onl_exp_modal" value="Online Exploitation"  id="id_traf_per_onl_exp_modal" />
                            <label class="form-check-label" for="id_traf_per_onl_exp_modal">
                                Online Exploitation
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_traf_per_others_modal" id="trafPerModal" value="Others"/>
                            <label class="form-check-label" for="trafPerModal">
                                Others
                            </label>
                            <span><input type="text" class="w-100 form-control" placeholder="Please specify" name="id_traf_per_others_spec_modal" id="inputTrafperModal"/></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_traf_per_forc_lab_modal" value="Forced Labor" id="id_traf_per_forc_lab_modal" />
                            <label class="form-check-label" for="id_traf_per_forc_lab_modal">
                                Forced Labor
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_traf_per_srem_org_modal" value="Sale or Removal of Organs" id="id_traf_per_srem_org_modal" />
                            <label class="form-check-label" for="id_traf_per_srem_org_modal">
                                Sale or Removal of Organs
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_traf_per_prost_modal" value="Prostitution" id="id_traf_per_prost_modal" />
                            <label class="form-check-label" for="id_traf_per_prost_modal">
                                Prostitution
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><input type="checkbox" name="id_sex_hara_modal" id="id_sex_hara_modal" value="Sexual Harassment" />
                        <span class="card-text">Sexual Harassment</span>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_sex_hara_ver_modal" value="Verbal" id="id_sex_hara_ver_modal" />
                            <label class="form-check-label" for="id_sex_hara_ver_modal">
                                Verbal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_sex_hara_others_modal" value="Others" id="sexHaModal" />
                            <label class="form-check-label" for="sexHaModal">
                                Others
                            </label>
                            <span><input type="text" class="w-100 form-control" placeholder="Please specify" name="id_sex_hara_others_spec_modal" id="inputSexHaModal"/></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_sex_hara_phys_modal" value="Physical" id="id_sex_hara_phys_modal" />
                            <label class="form-check-label" for="id_sex_hara_phys_modal">
                                Physical
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_sex_hara_use_obj_modal" value="Use of Object, Letters, or Notes with Sexual Undeskpinning" id="id_sex_hara_use_obj_modal" />
                            <label class="form-check-label" for="id_sex_hara_use_obj_modal">
                                Use of Object, Letters, or Notes with Sexual Undeskpinning
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><input type="checkbox" name="id_chi_abu_modal" id="id_chi_abu_modal" value="Child Abuse, Exploitation and Discrimination" />
                        <span class="card-text">Child Abuse, Exploitation and Discrimination</span></div>
                </div>
                <div class="row my-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-2"><p class="card-text">Sub Option:</p></div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_chi_abu_efpaccp_modal" value="Engage, Facilitate, Promote, or Attempt to Commit Child Prostitution" id="id_chi_abu_efpaccp_modal" />
                            <label class="form-check-label" for="id_chi_abu_efpaccp_modal">
                                Engage, Facilitate, Promote, or Attempt to Commit Child Prostitution
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_chi_abu_lasc_cond_modal" value="Lascivious Conduct" id="id_chi_abu_lasc_cond_modal" />
                            <label class="form-check-label" for="id_chi_abu_lasc_cond_modal">
                                Lascivious Conduct
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_chi_abu_others_modal" value="Others" id="chiAedModal" />
                            <label class="form-check-label" for="chiAedModal">
                                Others
                            </label>
                            <span><input type="text" class="w-100 form-control" placeholder="Please specify" name="id_chi_abu_others_spec_modal" id="inputchiAedModal"/></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_chi_abu_sex_int_modal" value="Sexual Intercourse" id="id_chi_abu_sex_int_modal" />
                            <label class="form-check-label" for="id_chi_abu_sex_int_modal">
                                Sexual Intercourse
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="id_chi_abu_phys_abu_modal" value="Physical Abuse" id="id_chi_abu_phys_abu_modal" />
                            <label class="form-check-label" for="id_chi_abu_phys_abu_modal">
                                Physical Abuse
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><p class="card-text">Description of the Incident<span class="asterisk">*</span></p></div>
                    <div class="col-md-9 form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" name="id_descr_inci_modal" id="id_descr_inci_modal" rows="14" required></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><span><p class="card-text">Date of Incidence:<span class="asterisk">*</span></p></span>
                        <input type="date" class="w-100 form-control" name="id_date_of_inci_modal" id="id_date_of_inci_modal" required/>
                    </div>
                    <div class="col"><span><p class="card-text">Time of Incident:</p></span>
                        <input type="time" class="w-100 form-control" name="id_time_of_inci_modal" id="id_time_of_inci_modal"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><span><p class="card-text">Location of Incidence:</p></span></div>
                </div>
                <div class="row my-3">
                    <div class="col"><span><p class="card-text">Household No.</p></span>
                        <input type="text" name="inci_det_house_no_modal" id="inci_det_house_no_modal" class="form-control" required/>
                    </div>
                    <div class="col"><span><p class="card-text">Street</p></span>
                        <input type="text" class="w-100 form-control" name="inci_det_street_modal" id="inci_det_street_modal"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                        <select id="inci_det_region_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                            <option value="">Please Select</option>
                            {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                        </select>
                        <input type="hidden" id="inci_det_region_modal_id" name="inci_det_region_modal"/>
                    </div>
                    <div class="col"><span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                        <select id="inci_det_province_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                            {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                        </select>
                        <input type="hidden" id="inci_det_province_modal_id" name="inci_det_province_modal"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                        <select id="inci_det_city_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                            {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                        </select>
                        <input type="hidden" id="inci_det_city_modal_id" name="inci_det_city_modal"/>
                    </div>
                    <div class="col"><span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                        <select id="inci_det_barangay_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                            {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                        </select>
                        <input type="hidden" id="inci_det_barangay_modal_id" name="inci_det_barangay_modal"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><span><p class="card-text">Place of Incidence:<span class="asterisk">*</span></p></span>
                        <select name="id_pla_of_inci_modal" id="placeinciModal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                            <option value="">Please Select</option>
                            @foreach($place_of_incidences as $place_of_incidence)
                            <option value="{{ $place_of_incidence->item_name }}">{{ $place_of_incidence->item_name }}</option>
                            @endforeach
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                        <input type="text" name="id_pi_oth_pls_spec_modal" placeholder="" class="w-100 form-control placeInciModal" id="inputplaceInciModal"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><p class="card-text">Was the incident Perpetuated Online?:<span class="asterisk">*</span></p></div>
                    <div class="col-md-3">
                        <select name="id_was_inc_perp_onl_modal" id="id_was_inc_perp_onl_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                            <option value="">Please Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <center id="add-incidence-details-error-form">
                    {{-- Result portion for Errors on Form --}}
                </center>
            </div>
        </div>
    </form>
</div>

{{-- END INCEDENCE DETAILS --}}

{{-- PERPETRATOR DETAILS INFOS --}}

<div class="modal fade" tabindex="-1" id="modalPerpetratorDetailInfos" aria-labelledby='myLargeModalLabel' aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <form class="user row" id="addPerpetratorDetailInfos" method="POST" action="javascript:void(0);" onsubmit="submitAdditionalPerpetratorDetailsForm()">
    @csrf    
        <div class="modal-dialog modal-xl" style="width:100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Perpetrator Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <span><p class="card-text">Last Name<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_last_name_modal" id="perp_d_last_name_modal" required/>
                            <input type="hidden" class="w-100 form-control" name="case_no_modal" id="perp_det_case_no_modal" />
                        </div>
                        <div class="col">
                            <span><p class="card-text">First Name<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_first_name_modal" id="perp_d_first_name_modal" required/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Middle Name<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_middle_name_modal" id="perp_d_middle_name_modal" required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <span><p class="card-text">Extension</p></span>
                            <input type="text" class="w-50 form-control" name="perp_d_extension_name_modal" id="perp_d_extension_name_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Nickname/Alias</p></span>
                            <input type="text" class="w-50 form-control" name="perp_d_alias_name_modal" id="perp_d_alias_name_modal"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-1">
                            <p class="card-text">Sex:<span class="asterisk">*</span></p>
                        </div>
                        <div class="col">
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="perp_d_sex_radio_modal" id="perp_d_sex_male_radio_modal" value="Male" required/>
                                    <label class="form-check-label" for="perp_d_sex_male_radio_modal">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="perp_d_sex_radio_modal" id="perp_d_sex_female_radio_modal" value="Female" required/>
                                    <label class="form-check-label" for="perp_d_sex_female_radio_modal">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <span><p class="card-text">Birthdate:<span class="asterisk">*</span></p></span>
                            <input type="date" class="w-100 form-control" name="perp_d_birthdate_modal" id="perp_d_birthdate_modal" required/>
                        </div>
                        <div class="col-md-3">
                            <span><p class="card-text">Age:<span class="asterisk">*</span></p></span>
                            <input type="number" class="w-100 form-control" name="perp_d_age_modal" id="perp_d_age_modal" required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <span><p class="card-text">Relationship to the Victim-Survivor:<span class="asterisk">*</span></p></span>
                            <select name="perp_d_rel_victim_modal" id="relvicsurModal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                @foreach($relationship_to_victim_survivors as $relationship_to_victim_survivor)
                                <option value="{{ $relationship_to_victim_survivor->item_name }}">{{ $relationship_to_victim_survivor->item_name }}</option>
                                @endforeach
                                <option value="Other Relatives, Specify:">Other Relatives, Specify:</option>
                            </select>
                        </div>
                        <div class="col">
                            <span><p class="card-text">If Other, please specify:</p></span>
                            <input type="text" class="w-100 form-control relVicsurModal" name="perp_d_rel_vic_pls_spec_modal" id="inputrelvicsurModal"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span><p class="card-text">Occupation:<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_occup_modal" id="perp_d_occup_modal" required/>
                        </div>
                        <div class="col-md-6">
                            <span><p class="card-text">Educational Attainment:<span class="asterisk">*</span></p></span>
                            <select id="perp_d_educ_att_modal" name="perp_d_educ_att_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                <option value="No Formal Education">No Formal Education</option>
                                <option value="Elementary Level/Graduate">Elementary Level/Graduate</option>
                                <option value="Junior High School Level/Graduate">Junior High School Level/Graduate</option>
                                <option value="Senior High School Level/Graduate">Senior High School Level/Graduate</option>
                                <option value="Technical/Vocational">Technical/Vocational</option>
                                <option value="College Level/Graduate">College Level/Graduate</option>
                                <option value="Post Graduate">Post Graduate</option>
                            </select>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Nationality<span class="asterisk">*</span></p></span>
                            <select name="perp_d_nationality_modal" id="narelvicsurModal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                <option value="Filipino">Filipino</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                            <input type="text" name="perp_d_nat_if_oth_pls_spec_modal" placeholder="" class="w-100 form-control narelVicsurModal" id="nainputrelvicsurModal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Religion<span class="asterisk">*</span></p></span>
                            <select name="perp_d_religion_modal" id="rerelvicsurModal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                @foreach($religions as $religion)
                                <option value="{{ $religion->item_name }}">{{ $religion->item_name }}</option>
                                @endforeach
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col"><span><p class="card-text">If Others, please specify</p></span>
                            <input type="text" name="perp_d_rel_if_oth_pls_spec_modal" placeholder="" class="w-100 form-control rerelVicsurModal" id="reinputrelvicsurModal"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3"><span><p class="card-text">Address</p></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col"><span><p class="card-text">Household No.</p></span>
                            <input type="text" name="perp_d_house_no_modal" id="perp_d_house_no_modal" class="form-control" required/>
                        </div>
                        <div class="col"><span><p class="card-text">Street</p></span>
                            <input type="text" name="perp_d_street_modal" id="perp_d_street_modal" class="w-100 form-control"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                            <select id="perp_d_region_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" id="perp_d_region_modal_id" name="perp_d_region_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                            <select id="perp_d_province_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" id="perp_d_province_modal_id" name="perp_d_province_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                            <select id="perp_d_city_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" id="perp_d_city_modal_id" name="perp_d_city_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                            <select id="perp_d_barangay_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" id="perp_d_barangay_modal_id" name="perp_d_barangay_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Current Location<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_curr_loc_modal" id="perp_d_curr_loc_modal" required/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <p class="card-text">Is Perpetrator Minor?:<span class="asterisk">*</span></p>
                        </div>
                        <div class="col">
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input perp_d_is_perp_minor_modal" type="radio" name="perp_d_is_perp_minor_modal" id="perp_d_is_pm_yes_radio_modal" value="Yes" required/>
                                    <label class="form-check-label" for="perp_d_is_pm_yes_radio_modal">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input perp_d_is_perp_minor_modal" type="radio" name="perp_d_is_perp_minor_modal" id="perp_d_is_pm_no_radio_modal" value="No" required/>
                                    <label class="form-check-label" for="perp_d_is_pm_no_radio_modal">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <span><p class="card-text">If Yes, please indicate the name of parent/guardian:</p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_if_yes_pls_ind_modal" id="perp_d_if_yes_pls_ind_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Address of parent/guardian:<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_addr_par_gua_modal" id="perp_d_addr_par_gua_modal" required/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-5">
                            <span><p class="card-text">Contact number of parent/guardian:<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="perp_d_cont_par_gua_modal" id="perp_d_cont_par_gua_modal" required/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Relationship of guardian to Perpetrator:<span class="asterisk">*</span></p></span>
                            <select name="perp_d_rel_guar_perp_modal" id="garrelvicsurModal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col">
                            <span><p class="card-text">If Others, please specify:</p></span>
                            <input type="text" class="w-100 form-control garrelVicsurModal" name="perp_d_rel_rgp_pls_spec_modal" id="garinputrelvicsurModal"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3"><p class="card-text">Other Information about the Perpetrator:</p></div>
                        <div class="col-md-9 form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="perp_d_oth_info_perp_modal" name="perp_d_oth_info_perp_modal" rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <center id="add-perpetrator-details-error-form">
                    {{-- Result portion for Errors on Form --}}
                </center>
            </div>
        </div>
    </form>
</div>

{{-- END PERPETRATOR DETAILS INFOS --}}

{{-- INTERVENTION MODULE INFOS --}}

<div class="modal fade" tabindex="-1" id="modalInterventionModuleInfos" aria-labelledby='modal-title' aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <form class="user row" id="addInterventionModulenfos" method="POST" action="javascript:void(0);" onsubmit="submitAdditionalInterventionModuleForm()">
    @csrf    
        <div class="modal-dialog modal-xl" style="width: 100%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Intervention Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Type of Service<span class="asterisk">*</span></p></span>
                            <select id="im_type_of_service_modal" name="im_type_of_service_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                {{-- Drop-down list on this select option is in the "public/js/scripts.js" file --}}
                            </select>
                            <input type="hidden" class="w-100 form-control" name="case_no_modal" id="inter_mod_case_no_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">If Others, please specify:</p></span>
                            <input type="text" class="w-100 form-control typeofServiceModal" name="im_typ_serv_if_oth_spec_modal" id="inputtypeofServiceModal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Specific Interventions: (Select Type of Service first)<span class="asterisk">*</span></p></span>
                            <select id="im_speci_interv_modal" name="im_speci_interv_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                {{-- Drop-down list on this select option is in the "public/js/scripts.js" file --}}
                            </select>
                        </div>
                        <div class="col">
                            <span><p class="card-text">If Others, please specify:</p></span>
                            <input type="text" class="w-100 form-control speIntsModal" name="im_spe_int_if_oth_spec_modal" id="inputspeIntModal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Service Provider:<span class="asterisk">*</span></p></span>
                            <select name="im_serv_prov_modal" id="serviceproviderModal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                @foreach($service_providers as $service_provider)
                                <option value="{{ $service_provider->name }}">{{ $service_provider->name }}</option>
                                @endforeach
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col">
                            <span><p class="card-text">If Others, please specify:</p></span>
                            <input type="text" class="w-100 form-control serviceprovidersModal" name="im_ser_pro_if_oth_spec_modal" id="inputserviceproviderModal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Specific Objective<span class="asterisk">*</span></p></span>
                            <textarea type="text" class="w-100 form-control" name="im_speci_obje_modal" id="im_speci_obje_modal" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Target Date<span class="asterisk">*</span></p></span>
                            <input type="date" class="w-100 form-control" name="im_target_date_modal" id="im_target_date_modal" required/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Status<span class="asterisk">*</span></p></span>
                            <select name="im_status_modal" id="im_status_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                <option value="">Please Select</option>
                                <option value="Provided">Provided</option>
                                <option value="Not Provided">Not Provided</option>
                                <option value="Ongoing">Ongoing</option>
                            </select>
                        </div>
                        <div class="col">
                            <span><p class="card-text">If Status is Provided, Provide Date:</p></span>
                            <input type="date" class="w-100 form-control" name="im_if_status_com_pd_modal" id="im_if_status_com_pd_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Details of Service Provider:</p></span>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Full Name<span class="asterisk">*</span></p></span>
                            <select id="im_dsp_full_name_modal" aria-aria-controls='example' class="date-picker w-100 form-control" required>
                                {{-- Data on this part are manipulated by js/scripts.js --}}
                            </select>
                            <input type="hidden" class="w-100 form-control" name="im_dsp_full_name_modal" id="im_dsp_full_name_modal_id"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Position/Designation<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="im_dsp_post_desi_modal" id="im_dsp_post_desi_modal" required/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Email<span class="asterisk">*</span></p></span>
                            <input type="email" class="w-100 form-control" name="im_dsp_email_modal" id="im_dsp_email_modal" required/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">1st Contact No. (Mobile)<span class="asterisk">*</span></p></span>
                            <input type="text" class="w-100 form-control" name="im_dsp_contact_no_1_modal" id="im_dsp_contact_no_1_modal" required/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">2nd Contact No. (Mobile)</p></span>
                            <input type="text" class="w-100 form-control" name="im_dsp_contact_no_2_modal" id="im_dsp_contact_no_2_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">3rd Contact No. (Landline)</p></span>
                            <input type="text" class="w-100 form-control" name="im_dsp_contact_no_3_modal" id="im_dsp_contact_no_3_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Details of Alternate Service Provider:</p></span>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">Full Name</p></span>
                            <select id="im_dasp_full_name_modal" aria-aria-controls='example' class="date-picker w-100 form-control">
                                {{-- Data on this part are manipulated by js/scripts.js --}}
                            </select>
                            <input type="hidden" class="w-100 form-control" name="im_dasp_full_name_modal" id="im_dasp_full_name_modal_id"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Position/Designation</p></span>
                            <input type="text" class="w-100 form-control" name="im_dasp_post_desi_modal" id="im_dasp_post_desi_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">Email</p></span>
                            <input type="email" class="w-100 form-control" name="im_dasp_email_modal" id="im_dasp_email_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><p class="card-text">1st Contact No. (Mobile)</p></span>
                            <input type="text" class="w-100 form-control" name="im_dasp_contact_no_1_modal" id="im_dasp_contact_no_1_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">2nd Contact No. (Mobile)</p></span>
                            <input type="text" class="w-100 form-control" name="im_dasp_contact_no_2_modal" id="im_dasp_contact_no_2_modal"/>
                        </div>
                        <div class="col">
                            <span><p class="card-text">3rd Contact No. (Landline)</p></span>
                            <input type="text" class="w-100 form-control" name="im_dasp_contact_no_3_modal" id="im_dasp_contact_no_3_modal"/>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <span><h5 class="card-text mt-4">Summary<span class="asterisk">*</span></h5></span>
                            <textarea id="im_summary_modal" name="im_summary_modal" rows="14" class="w-100 form-control mb-4" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <center id="add-intervention-module-error-form">
                    {{-- Result portion for Errors on Form --}}
                </center>
            </div>
        </div>
    </form>
</div>

{{-- END OF INTERVENTION MODULE INFOS --}}

{{-- START OF UPLOAD FILES MODAL --}}

<div class="modal fade" tabindex="-1" id="modalUploadFilesToCase" aria-labelledby='modal-title' aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg" style="display: flex; align-items: center; justify-content: center;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeUploadFileModalForm()"></button>
            </div>
            <div class="modal-body" style="display: flex; align-items: center; justify-content: center;">
                <div class="wrapper" style="width: 430px; padding: 30px; background: #fff; border-radius: 5px; align-items: center; justify-content: center;">
                    <header style="color: #eb6c60; font-size: 27px; font-weight: 600; text-align: center;">Upload Files</header>
                    <!-- <center >    -->
                    <form id="upload_file_form" action="#" style="display: flex; margin: 30px 0; align-items: center; flex-direction: column; border-radius: 5px; border-style: dashed; border-width: 2px; border-color: #eb6c60;"> 
                        @csrf    
                        <input type="file" class="file-input" id="file" name="file" hidden/>
                        <i class="fa fa-cloud-upload-alt" style="color: #eb6c60; font-size: 50px; margin-top: 15px;"></i>
                        <p style="color: #eb6c60; font-size: 16px; margin-top: 15px;">Browse File to upload</p>
                    </form>
                    <!-- </center> -->
                    <section class="progress-area">
                        {{-- Data on this field are manipulated by javascript with uploadFile() function --}}
                    </section>
                    <section class="uploaded-area">
                        {{-- Data on this field are manipulated by javascript with uploadFile() function --}}
                    </section>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeUploadFileModalForm()">Done</button>
            </div>
        </div>
    </div>
</div>

{{-- END OF UPLOAD FILES MODAL --}}

<!-- End of Modal Forms -->

@endsection

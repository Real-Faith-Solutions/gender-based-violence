@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">Master List</h1>
            @if($master_list_rights_add == true)
            <a href="{{ env('APP_URL') }}admin/case-folder/create-case">
              <button type="button" class="btn-orange rounded p-2 m-3">
                Add new
              </button>
            </a>
            @endif
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Master List</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Search option -->
<section class="content-header">
  <div class="container-fluid">
    <div class="card shadow mb-3">
      <div class="card-header">
        <span class="card-title h6 font-weight-bold text-primary">Search Case</span>
      </div>
      <div class="card-body table-responsive">
        <form action="javascript:void(0);" id="search_case_no_or_last_name_form" onsubmit="searchCase()">
          <div class="input-group">
            <input type="text" name="case_no_or_last_name_search" id="case_no_or_last_name_search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <select class="form-control bg-light border-0 small" name="case_search_option" id="case_search_option">
                <option value="case-no">Case No.</option>
                <option value="last-name">Last Name</option>
              </select>
            </div>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit" id="search_case"><i class="fas fa-search fa-sm"></i></button>
            </div>
          <div>
        </form>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header">
                <span class="card-title h6 font-weight-bold text-primary">Cases Table</span>
                <!-- <button class="btn btn-success btn-xs" style="margin-left: 77%" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</button> -->
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
              <table class="table table-hover table-striped mt-3 no-footer" @if($case_manager == true) id="generalTable" @endif>
                  <thead class="thead-dark">
                      <tr>
                        <th></th>
                        <th>Case No</th>
                        <th style="display:none;"><i class="bi bi-arrow-up"></i> Name</th>
                        <th><i class="bi bi-arrow-up"></i> Date Of Intake</th>
                        <th><i class="bi bi-arrow-up"></i> Has the client made a report before?</th>
                        <th><i class="bi bi-arrow-up"></i> Age</th>
                        <th><i class="bi bi-arrow-up"></i> Sex</th>
                        <th><i class="bi bi-arrow-up"></i> Civil Status</th>
                        <th><i class="bi bi-arrow-up"></i> SOGIE</th>
                        <th><i class="bi bi-arrow-up"></i> Educational Attainment</th>
                        <th><i class="bi bi-arrow-up"></i> Religion</th>
                        <th><i class="bi bi-arrow-up"></i> Ethnicity</th>
                        <th><i class="bi bi-arrow-up"></i> Nationality</th>
                        <th><i class="bi bi-arrow-up"></i> Province</th>
                        <th><i class="bi bi-arrow-up"></i> Municipality</th>
                        <th><i class="bi bi-arrow-up"></i> Barangay</th>
                        <th><i class="bi bi-arrow-up"></i> IDP</th>
                        <th><i class="bi bi-arrow-up"></i> PWD</th>
                        <th><i class="bi bi-arrow-up"></i> Age of Guardian</th>
                        <th><i class="bi bi-arrow-up"></i> Nature of Incidence</th>
                        <th><i class="bi bi-arrow-up"></i> Sub-option of Nature of Incidence</th>
                        <th><i class="bi bi-arrow-up"></i> Place of Incidence</th>
                        <th><i class="bi bi-arrow-up"></i> Incidence Perpetuated Online?</th>
                        <th><i class="bi bi-arrow-up"></i> Age of Perpetrator</th>
                        <th><i class="bi bi-arrow-up"></i> Sex of Perpetrator</th>
                        <th><i class="bi bi-arrow-up"></i> Relationship of Perpetrator to Victim-Survivor</th>
                        <th><i class="bi bi-arrow-up"></i> Occupation of Perpetrator</th>
                        <th><i class="bi bi-arrow-up"></i> Nationality of Perpetrator</th>
                        <th><i class="bi bi-arrow-up"></i> Is perpetrator Minor</th>
                        <th><i class="bi bi-arrow-up"></i> Type of Service provided to victim</th>
                        <th><i class="bi bi-arrow-up"></i> Service Provider</th>
                        <th><i class="bi bi-arrow-up"></i> Was Referred by Other Organization?</th>
                        <th><i class="bi bi-arrow-up"></i> Form Status</th>
                        <th><i class="bi bi-arrow-up"></i> Case Status</th>
                        <th><i class="bi bi-arrow-up"></i> Last Updated By<i class="bi bi-arrow-up"></i></th>
                        <th><i class="bi bi-arrow-up"></i> Last Update Date<i class="bi bi-arrow-up"></i></th>
                      </tr>
                  </thead>
                  <tbody class="font-weight-light">
                    @if(count($cases_paginator) === 0)
                        <tr>
                          <td></td>
                          <td>-</td>
                          <td style="display:none;">-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                        </tr>
                    @else
                      @foreach($cases_paginator as $casesdetails)
                        <tr>
                          <td>
                            @if($casesdetails->cm_case_status == 'Closed')
                            <i class="fa fa-edit ml-3"></i>
                            @endif
                            @if($casesdetails->cm_case_status != 'Closed')
                            <a href="{{ env('APP_URL') }}admin/case-folder/edit-created-case/{{ $casesdetails->case_no }}" class="text-orange-icon"><i class="fa fa-edit"></i></a>
                            @endif
                            <a href="{{ env('APP_URL') }}admin/case-folder/view-created-case/{{ $casesdetails->case_no }}" class="text-orange-icon"><i class="fa fa-eye"></i></a>
                          </td>
                          <td>{{$casesdetails->case_no ?? '-'}}</td>
                          <td style="display:none;">{{$casesdetails->last_name ?? '-'}}, {{$casesdetails->first_name ?? '-'}}</td>
                          <td>{{$casesdetails->date_of_intake ?? '-'}}</td>
                          <td>{{$casesdetails->client_made_a_report_before ?? '-'}}</td>
                          <td>{{$casesdetails->age ?? '-'}}</td>
                          <td>{{$casesdetails->sex ?? '-'}}</td>
                          <td>{{$casesdetails->civil_status ?? '-'}}</td>
                          <td>{{$casesdetails->client_diverse_sogie ?? '-'}}</td>
                          <td>{{$casesdetails->education ?? '-'}}</td>
                          <td>{{$casesdetails->religion ?? '-'}}</td>
                          <td>{{$casesdetails->ethnicity ?? '-'}}</td>
                          <td>{{$casesdetails->nationality ?? '-'}}</td>
                          <td>{{$casesdetails->province ?? '-'}}</td>
                          <td>{{$casesdetails->city ?? '-'}}</td>
                          <td>{{$casesdetails->barangay ?? '-'}}</td>
                          <td>{{$casesdetails->is_idp ?? '-'}}</td>
                          <td>{{$casesdetails->is_pwd ?? '-'}}</td>
                          <td>{{$casesdetails->age_vict_sur ?? '-'}}</td>
                          <td>{{$casesdetails->nature_of_incidence ?? '-'}}</td>
                          <td>{{$casesdetails->sub_option_of_nature_of_incidence ?? '-'}}</td>
                          <td>{{$casesdetails->id_pla_of_inci ?? '-'}}</td>
                          <td>{{$casesdetails->id_was_inc_perp_onl ?? '-'}}</td>
                          <td>{{$casesdetails->perp_d_age ?? '-'}}</td>
                          <td>{{$casesdetails->perp_d_sex_radio ?? '-'}}</td>
                          <td>{{$casesdetails->perp_d_rel_victim ?? '-'}}</td>
                          <td>{{$casesdetails->perp_d_occup ?? '-'}}</td>
                          <td>{{$casesdetails->perp_d_nationality ?? '-'}}</td>
                          <td>{{$casesdetails->perp_d_is_perp_minor ?? '-'}}</td>
                          <td>{{$casesdetails->im_type_of_service ?? '-'}}</td>
                          <td>{{$casesdetails->im_serv_prov ?? '-'}}</td>
                          <td>{{$casesdetails->rm_was_cli_ref_by_org ?? '-'}}</td>
                          {{-- Check form_status and set badge color --}}
                          <td><span class="badge {{ ($casesdetails->form_status === 'Draft') ? 'bg-danger' : '' }} {{ ($casesdetails->form_status === 'Submitted') ? 'bg-success' : '' }} text-white">{{$casesdetails->form_status ?? '-'}}</span></td>
                          {{-- Check cm_case_status and set badge color --}}
                          <td><span class="badge {{ ($casesdetails->cm_case_status === 'Ongoing') ? 'bg-warning' : '' }} {{ ($casesdetails->cm_case_status === 'Completed') ? 'bg-primary' : '' }} {{ ($casesdetails->cm_case_status === 'Closed') ? 'bg-success' : '' }} text-white">{{ $casesdetails->cm_case_status }}</span></td>
                          <td>
                          @php
                          foreach(array(App\Models\CasesUsersActivityLogs::where('subject_case_no','=',$casesdetails->case_no)->get()->last()) as $names){

                            echo $names->accountable_user_last_name.', '.$names->accountable_user_first_name;
                          }
                          @endphp
                          </td>
                          <td>
                          @php
                          foreach(array(App\Models\CasesUsersActivityLogs::where('subject_case_no','=',$casesdetails->case_no)->get()->last()) as $update_date){

                            echo $update_date->updated_at;
                          }
                          @endphp  
                          </td>
                        </tr>
                      @endforeach
                    @endif  
                  </tbody>
              </table>
            </div>
            @if(count($cases_paginator) != 0)
              {{ $cases_paginator->links() }}
            @endif
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection

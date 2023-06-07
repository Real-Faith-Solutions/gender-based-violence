@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6" style="display: flex; align-items: center;">
        <h1 class="text-gray-800">User</h1>
        <button type="button" class="btn-orange rounded p-2 m-3" data-bs-toggle="modal" data-bs-target="#addUser">Add new</button>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/rights-management/user-role">User Role</a></li>
        <li class="breadcrumb-item active">User</li>
        </ol>
      </div>
    </div>
  </div>
<!-- /.container-fluid -->
</section>

<!-- Search option -->
<section class="content-header">
  <div class="container-fluid">
    <div class="card shadow mb-3">
      <div class="card-header">
        <span class="card-title h6 font-weight-bold text-primary">Search User</span>
      </div>
      <div class="card-body table-responsive">
        <form action="javascript:void(0);" id="search_user_by_last_name_form" onsubmit="searchUser()">
        @csrf
          <div class="input-group">
            <input type="text" name="user_last_name_search" id="user_last_name_search" class="form-control bg-light border-0 small" placeholder="Enter Last Name" aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit" id="search_user"><i class="fas fa-search fa-sm"></i></button>
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
                <span class="card-title h6 font-weight-bold text-primary" id="user_div_data_header_title">Users Table</span>
            </div>
            <div class="card-body table-responsive" id="user_div_data">
                <table class="table table-hover mt-3 no-footer">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col"></th>
                        <th scope="col"><i class="bi bi-arrow-up"></i>Email</th>
                        <th scope="col"><i class="bi bi-arrow-up"></i>Name</th>
                        <th scope="col"><i class="bi bi-arrow-up"></i>Role</th>
                        <th scope="col"><i class="bi bi-arrow-up"></i>Service Provider Name</th>
                        <th scope="col"><i class="bi bi-arrow-up"></i>Is Active</th>
                        </tr>
                    </thead>
                    <tbody id="users_table_data">
                        @if(count($user_paginator) === 0)
                        <tr>
                            <td></td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        @else
                            @foreach($user_paginator as $user_details)
                            <tr>
                            <td>
                                <a href="{{ env('APP_URL') }}admin/rights-management/user/edit-created-user/{{ $user_details->id }}" class="text-orange-icon"><i class="fa fa-edit"></i></a>
                                <a href="javascript:viod(0)" class="text-orange-icon" onclick="deleteUserModal({{ $user_details->id }})"><i class="fa fa-trash"></i></a>
                            </td>
                            <td>{{$user_details->email ?? '-'}}</td>
                            <td>{{$user_details->user_first_name." ".$user_details->user_last_name ?? '-'}} </td>
                            <td>{{$user_details->role ?? '-'}}</td>
                            <td>{{$user_details->user_service_provider ?? '-'}}</td>
                            <td><span class="badge bg-primary text-light">{{$user_details->is_active ?? '-'}}</span></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            @if(count($user_paginator) != 0)
                {{ $user_paginator->links() }}
            @endif
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

<!-- Start of Modal Form -->

<!-- Start of Modal Add User   -->

<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
    <form class="modal-dialog modal-xl" style="width:100%;" id="addUserSubmit" method="POST" action="javascript:void(0);" onsubmit="submitForm()">
    @csrf    
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Add User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h6 class="mb-3 fw-bold">Personal Details<span class="asterisk">*</span></h6>
          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Last Name<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="text" name="user_last_name" required/>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">First Name<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="text" name="user_first_name" required/>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Middle Name<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="text" name="user_middle_name" required/>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Mobile Number<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="text" name="user_contact_no" required />
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">E-mail<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="email" name="email" required />
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Employee ID<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="text" name="user_employee_id" required/>
                  </div>
              </div>
          </div>
          <hr></hr>
          <h6 class="mb-3 fw-bold">Account Details</h6>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Username<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="text" name="username" required />
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Role<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                    <div class="col-xs-2">
                      <select class="form-control" style="width:auto" name="role" id="role" required>
                          <option value="">Please Select</option>
                          @foreach($userrole as $roles)
                          <option value="{{$roles->role_name}}">{{$roles->role_name}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Service Provider<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                    <div class="col-xs-2">
                      <select class="form-control" style="width:auto" name="user_service_provider" id="user_service_provider">
                          <option selected>Please Select</option>
                          @foreach($service_providers as $service_provider)
                          <option value="{{$service_provider->name}}">{{$service_provider->name}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Password<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="password" name="password" required />
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Confirm Password<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                  <div class="input-group mb-3">
                      <input class="form-control" type="password" name="password_confirmation" required />
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-sm-3">
                  <h6 class="mb-0">Is Active?<span class="asterisk">*</span></h6>
              </div>
              <div class="col-sm-9 text-secondary">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active" id="is_active_yes_radio" value="Yes" required/>
                    <label class="form-check-label" for="is_active_yes_radio">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_active" id="is_active_no_radio" value="No" required/>
                    <label class="form-check-label" for="is_active_no_radio">No</label>
                </div>
              </div>
          </div>
          <hr></hr>
          <h6 class="mb-3 fw-bold">Scoping</h6>

            <div class="row mb-3">
                <div class="col"><span><p class="card-text">Region</p></span>
                    <select id="user_region" aria-aria-controls='example' class="date-picker w-100 form-control" >
                        <option value="">Please Select</option>
                        {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                    </select>
                    <input type="hidden" id="user_region_id" name="user_region"/>
                </div>
                <div class="col"><span><p class="card-text">Province</p></span>
                    <select id="user_province" aria-aria-controls='example' class="date-picker w-100 form-control" >
                        {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                    </select>
                    <input type="hidden" id="user_province_id" name="user_province"/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col"><span><p class="card-text">City/Municipality</p></span>
                    <select id="user_municipality" aria-aria-controls='example' class="date-picker w-100 form-control" >
                        {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                    </select>
                    <input type="hidden" id="user_municipality_id" name="user_municipality"/>
                </div>
                <div class="col"><span><p class="card-text">Barangay</p></span>
                    <select id="user_barangay" aria-aria-controls='example' class="date-picker w-100 form-control" >
                        {{-- Drop-down list on this field are manipulated on "public/js/scripts.js" file --}}
                    </select>
                    <input type="hidden" id="user_barangay_id" name="user_barangay"/>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-orange rounded">Save Changes</button>
        </div> 
        <center id="error-form">
        {{-- Result portion for Errors on Form --}}
        </center> 
      </div>
    </form>
</div>

<!-- End of Modal Add User   -->

<!-- End of Modal Form -->

<!-- Start of Javascript -->

<!-- Start of delete User Sweet Alert modal -->

<script>
    function deleteUserModal($id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '{{ env('APP_URL') }}api/v1/user/delete/' + $id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The user account was successfully deleted'){
                            Swal.fire('Deleted!', 'The user account was successfully deleted.', 'success');
                            location.reload();
                        }else{
                            Swal.fire('The user account was not deleted!', '', 'error');
                        }
                    }
                });

            }else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    }
</script>

<!-- End of delete User Sweet Alert modal  -->

<!-- Start of submit form using Sweet Alert -->

<script>
function submitForm(){

    Swal.fire({
        title: 'Do you want to save the changes?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Save',
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: '{{ env('APP_URL') }}api/v1/user/add',
                data: $("#addUserSubmit").serialize(),
                success: function(response) {

                    if (response === 'The user was successfully added'){
                        Swal.fire('Saved!', 'The user was successfully added.', 'success');
                        location.reload();
                    }else{
                        Swal.fire('The user was not added!', '', 'error');

                        html = "";
                        $.each(response, function( index, value ) {
                            html += '<p class="d-flex justify-content-center text-danger">'+ value +'</p>';
                        });
                        html += '<hr>';

                        $('#error-form').empty().prepend(html);
                    }
                }
            });
        } else if (result.isDenied) {

            Swal.fire('Changes are not saved', '', 'info')
        }
    });

}
</script>

<!-- End of submit form using Sweet Alert -->

<!-- End of Javascript -->


@endsection

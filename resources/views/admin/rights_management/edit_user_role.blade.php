@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6" style="display: flex; align-items: center;">
        <h1 class="text-gray-800">Edit User Role</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/rights-management/user-role">User Role</a></li>
        <li class="breadcrumb-item active">Edit User Role</li>
        </ol>
      </div>
    </div>
  </div>
<!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card border-light shadow-lg">
        <div class="container">
            <center id="error-form" class="col mt-3 mb-3">
            {{-- Result portion for Errors in Form from submit form using Sweet Alert script below --}}
            </center>
            <form id="updateUserRoleSubmit" method="POST" action="{{ env('APP_URL') }}api/v1/user-role/update/{{ $user_role_id->id }}">
            @method('PUT')
            @csrf 
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Role</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="role_name" type="text" value="{{ $user_role_id->role_name }}" required disabled/>
                            <input class="form-control" name="role_name" type="hidden" value="{{ $user_role_id->role_name }}"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Rights</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="dashboard" value="Dashboard" id="flexCheckChecked" {{(str_contains($user_role_id->page_access, 'Dashboard')) ? 'Checked' : ''}}/>
                            <label class="form-check-label" for="flexCheckChecked">Dashboard</label>
                            <br/>
                            <input class="form-check-input" type="checkbox" name="rights_management" value="Rights Management" id="flexCheckChecked1" {{(str_contains($user_role_id->page_access, 'Rights Management')) ? 'Checked' : ''}}/>
                            <label class="form-check-label" for="flexCheckChecked1">Rights Management</label>
                            <br/>
                            <input class="form-check-input" type="checkbox" name="master_list" value="Master List" id="flexCheckChecked2" {{(str_contains($user_role_id->page_access, 'Master List')) ? 'Checked' : ''}}/>
                            <label class="form-check-label" for="flexCheckChecked2">Master List</label>

                            <ol>
                                <ul>
                                    <input class="form-check-input" type="checkbox" name="master_list_rights_add" value="Add" id="flexCheckChecked2.1" {{(str_contains($user_role_id->master_list_rights, 'Add')) ? 'Checked' : ''}}/>
                                    <label class="form-check-label" for="flexCheckChecked2.1">Add</label>
                                </ul>

                                <ul>
                                    <input class="form-check-input" type="checkbox" name="master_list_rights_revise" value="Revise" id="flexCheckChecked2.2" {{(str_contains($user_role_id->master_list_rights, 'Revise')) ? 'Checked' : ''}}/>
                                    <label class="form-check-label" for="flexCheckChecked2.2">Revise</label>
                                </ul>

                                <ul>
                                    <input class="form-check-input" type="checkbox" name="master_list_rights_delete" value="Delete" id="flexCheckChecked2.3" {{(str_contains($user_role_id->master_list_rights, 'Delete')) ? 'Checked' : ''}}/>
                                    <label class="form-check-label" for="flexCheckChecked2.3">Delete</label>
                                </ul>

                                <ul>
                                    <input class="form-check-input" type="checkbox" name="master_list_rights_upload" value="Upload" id="flexCheckChecked2.4" {{(str_contains($user_role_id->master_list_rights, 'Upload')) ? 'Checked' : ''}}/>
                                    <label class="form-check-label" for="flexCheckChecked2.4">Upload</label>
                                </ul>

                                <ul>
                                    <input class="form-check-input" type="checkbox" name="master_list_rights_appr_disappr" value="Approved/Disapproved" id="flexCheckChecked2.5" {{(str_contains($user_role_id->master_list_rights, 'Approved/Disapproved')) ? 'Checked' : ''}}/>
                                    <label class="form-check-label" for="flexCheckChecked2.5">Approved/Disapproved</label>
                                </ul>
                            </ol>

                            <input class="form-check-input" type="checkbox" name="reports"value="Reports" id="flexCheckChecked3" {{(str_contains($user_role_id->page_access, 'Reports')) ? 'Checked' : ''}}/>
                            <label class="form-check-label" for="flexCheckChecked3">Reports</label>
                            <br/>

                            <input class="form-check-input" type="checkbox" name="maintenance" value="Maintenance" id="flexCheckChecked4" {{(str_contains($user_role_id->page_access, 'Maintenance')) ? 'Checked' : ''}}/>
                            <label class="form-check-label" for="flexCheckChecked4">Maintenance</label>
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-3 mb-3">
                        <a href="{{ env('APP_URL') }}admin/rights-management/user-role"><button type="button" class="btn btn-secondary me-2">Cancel</button></a>
                        <button type="button" class="btn btn-orange rounded" onclick="submitForm()">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Start of Javascript -->

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
                url: '{{ env('APP_URL') }}api/v1/user-role/update/{{ $user_role_id->id }}',
                data: $("#updateUserRoleSubmit").serialize(),
                success: function(response) {

                    if (response === 'The user role name was successfully modified'){
                        Swal.fire('Saved!', 'The user role name was successfully modified', 'success');
                        location.assign('{{ env('APP_URL') }}admin/rights-management/user-role');
                    }else{
                        Swal.fire('The user account was not modified!', '', 'error');

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

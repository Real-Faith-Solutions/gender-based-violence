@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6" style="display: flex; align-items: center;">
            <h1 class="text-gray-800">User Role</h1>
            <button type="button" class="btn-orange rounded p-2 m-3" data-bs-toggle="modal" data-bs-target="#modalRole">
              Add new
            </button>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/rights-management/user">User</a></li>
            <li class="breadcrumb-item active">User Role</li>
          </ol>
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
                <span class="card-title h6 font-weight-bold text-primary">Roles Table</span>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover mt-3 no-footer">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col"></th>
                        <th scope="col">Role Name</th>
                        <th scope="col">Page Access</th>
                        <th scope="col">Master list Rights</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userrole as $userrights)
                        <tr>
                            <td>
                                <a href="{{ env('APP_URL') }}admin/rights-management/user-role/edit-created-user-role/{{ $userrights->id }}" class="text-orange-icon"><i class="fa fa-edit"></i></a>
                                <a href="javascript:viod(0)" class="text-orange-icon" onclick="deleteUserRoleModal({{ $userrights->id }})"><i class="fa fa-trash"></i></a>
                            </td>
                            <td>{{$userrights->role_name ?? '-'}}</td>
                            <td>
                                @foreach(explode(',',$userrights->page_access) as $pageaccess)

                                    @if(!empty($pageaccess))
                                    <li>{{$pageaccess}}</li>
                                    @endif

                                @endforeach
                            </td>
                            <td>
                                @foreach(explode(',',$userrights->master_list_rights) as $masterlistrights)

                                    @if(!empty($masterlistrights))
                                    <li>{{$masterlistrights}}</li>
                                    @endif

                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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

<!--  Start of Modal Role   -->

<div class="modal fade" id="modalRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form class="modal-dialog modal-xl" style="width:100%;" method="POST" id="modalRoleForm" action="javascript:void(0);" onsubmit="submitDataForms('{{ env('APP_URL') }}api/v1/user-role/add', 'modalRoleForm', 'modalRole');">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Add User Role</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="height:10px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
            </button>
        </div>
        <div class="modal-body">
            <center id="error-form">
            {{-- Result portion for Errors on Form --}}
            </center>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Role</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <div class="input-group mb-3">
                        <input class="form-control" name="role_name" type="text" required />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Rights</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dashboard" value="Dashboard" id="flexCheckChecked"/>
                        <label class="form-check-label" for="flexCheckChecked">Dashboard</label>
                        <br/>
                        <input class="form-check-input" type="checkbox" name="rights_management" value="Rights Management" id="flexCheckChecked1"/>
                        <label class="form-check-label" for="flexCheckChecked1">Rights Management</label>
                        <br/>
                        <input class="form-check-input" type="checkbox" name="master_list" value="Master List" id="flexCheckChecked2"/>
                        <label class="form-check-label" for="flexCheckChecked2">Master List</label>

                        <ol>
                            <ul>
                                <input class="form-check-input" type="checkbox" name="master_list_rights_add" value="Add" id="flexCheckChecked2.1"/>
                                <label class="form-check-label" for="flexCheckChecked2.1">Add</label>
                            </ul>

                            <ul>
                                <input class="form-check-input" type="checkbox" name="master_list_rights_revise" value="Revise" id="flexCheckChecked2.2"/>
                                <label class="form-check-label" for="flexCheckChecked2.2">Revise</label>
                            </ul>

                            <ul>
                                <input class="form-check-input" type="checkbox" name="master_list_rights_delete" value="Delete" id="flexCheckChecked2.3"/>
                                <label class="form-check-label" for="flexCheckChecked2.3">Delete</label>
                            </ul>

                            <ul>
                                <input class="form-check-input" type="checkbox" name="master_list_rights_upload" value="Upload" id="flexCheckChecked2.4"/>
                                <label class="form-check-label" for="flexCheckChecked2.4">Upload</label>
                            </ul>

                            <ul>
                                <input class="form-check-input" type="checkbox" name="master_list_rights_appr_disappr" value="Approved/Disapproved" id="flexCheckChecked2.5"/>
                                <label class="form-check-label" for="flexCheckChecked2.5">Approved/Disapproved</label>
                            </ul>
                        </ol>

                        <input class="form-check-input" type="checkbox" name="reports"value="Reports" id="flexCheckChecked3"/>
                        <label class="form-check-label" for="flexCheckChecked3">Reports</label>
                        <br/>

                        <input class="form-check-input" type="checkbox" name="maintenance" value="Maintenance" id="flexCheckChecked4"/>
                        <label class="form-check-label" for="flexCheckChecked4">Maintenance</label>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-orange rounded" onclick="submitForm()">Save Changes</button>
        </div>
      </div>
    </form>
</div>

<!--  End of Modal Role   -->

<!-- Start of Javascript -->

<!-- Start of delete User Role Sweet Alert modal -->

<script>
    function deleteUserRoleModal($id){
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
                    url: '{{ env('APP_URL') }}api/v1/user-role/delete/' + $id,
                    data: {
                        _method: 'delete',
                    },
                    success: function(response) {

                        if (response === 'The user role name was successfully deleted'){
                            Swal.fire('Deleted!', 'The user role name was successfully deleted.', 'success');
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

<!-- End of delete User Role Sweet Alert modal  -->

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
                url: '{{ env('APP_URL') }}api/v1/user-role/add',
                data: $("#modalRoleForm").serialize(),
                success: function(response) {

                    if (response === 'Role name successfully added'){
                        Swal.fire('Saved!', 'Role name successfully added', 'success');
                        location.reload();
                    }else{
                        Swal.fire('Role name was not added!', '', 'error');

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

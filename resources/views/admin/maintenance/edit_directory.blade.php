@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6" style="display: flex; align-items: center;">
        <h1 class="text-gray-800">Edit Directory</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/maintenance/directory">Directories</a></li>
        <li class="breadcrumb-item active">Edit Directory</li>
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
        <div class="container mt-3">
            <form id="updateDirectorySubmit" method="POST" action="javascript:void(0);" onsubmit="submitForm()">
            @method('PUT')
            @csrf 
                <div class="row">
                    <div class="col-sm-3">First Name<span class="asterisk">*</span></div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_first_name" type="text" value="{{ $directory_id->dir_first_name }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">Middle Name<span class="asterisk">*</span></div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_middle_name" type="text" value="{{ $directory_id->dir_middle_name }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">Last Name<span class="asterisk">*</span></div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_last_name" type="text" value="{{ $directory_id->dir_last_name }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">Position/Designation<span class="asterisk">*</span></div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_post_desi" type="text" value="{{ $directory_id->dir_post_desi }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">Directory Type<span class="asterisk">*</span></div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <div class="col-xs-2">
                                <select class="form-control" style="width:auto" name="dir_directory_type" id="dir_directory_type" onclick="changeDirectoryType()" required>
                                    <option value="{{ $directory_id->dir_directory_type }}" selected>{{ $directory_id->dir_directory_type }}</option>
                                    {{-- Drop-down list on this field are manipulated on changeDirectoryType() method below --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">1st Contact No. (Mobile)<span class="asterisk">*</span></div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_contact_no_1" type="text" value="{{ $directory_id->dir_contact_no_1 }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">2nd Contact No. (Mobile)</div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_contact_no_2" type="text" value="{{ $directory_id->dir_contact_no_2 }}"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">3rd Contact No. (Landline)</div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_contact_no_3" type="text" value="{{ $directory_id->dir_contact_no_3 }}"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">Email<span class="asterisk">*</span></div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_email" type="email" value="{{ $directory_id->dir_email }}" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">Facebook</div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" name="dir_facebook" value="{{ $directory_id->dir_facebook }}" type="text"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col mt-3 mb-3">
                        <a href="{{ env('APP_URL') }}admin/maintenance/directory"><button type="button" class="btn btn-secondary me-2">Cancel</button></a>
                        <button type="submit" class="btn btn-orange rounded">Save Changes</button>
                    </div>
                </div>
                <center id="error-form" class="col mt-3 mb-3">
                {{-- Result portion for Errors in Form from submit form using Sweet Alert script below --}}
                </center>
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
                url: '{{ env('APP_URL') }}api/v1/directory/update/{{ $directory_id->id }}',
                data: $("#updateDirectorySubmit").serialize(),
                success: function(response) {

                    if (response === 'The Directory details was successfully modified'){
                        Swal.fire('Saved!', 'The Directory details was successfully modified', 'success');
                        location.assign('{{ env('APP_URL') }}admin/maintenance/directory');
                    }else{
                        Swal.fire('The Directory details was not modified!', '', 'error');

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

<!-- Start of change Directory Type confirmation using Sweet Alert -->

<script>
function changeDirectoryType(){

    Swal.fire({
        title: 'Do you want to change the Directory Type?',
        html: "<center>Existing Directory Type will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ env('APP_URL') }}api/v1/directory-type/record',
                success: function(response) {
                
                    $('#dir_directory_type').attr('onclick','');

                    $('#dir_directory_type').empty();

                    html = "";
                    html = '<option value="">Please Select</option>';
                    response.forEach(element => {
                        html += '<option value="'+ element['name'] +'">'+ element['name'] +'</option>';
                    });

                    $('#dir_directory_type').prepend(html); 
                }
            }); 
        }
    });
}
</script>

<!-- End of change Directory Type confirmation using Sweet Alert -->

<!-- End of Javascript -->

@endsection

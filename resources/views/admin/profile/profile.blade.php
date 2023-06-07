@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <img class="rounded-circle" width="180" height="180" src="{{ asset('profile/default_profile_photo.png') }}">
        </div>
        <div class="row justify-content-center">
            <h3 class="text-gray-800">{{ $user_details[0]->user_first_name }} {{ $user_details[0]->user_last_name }}</h3>
        </div>
        <div class="row justify-content-center">
            <h5 class="text-primary">({{ $user_details[0]->username }})</h5>
        </div>
    </div>
<!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card border-light shadow-lg">
        <div class="container">

            <div class="card m-3">
                <div class="card-header">
                    <h5 class="text-dark">Active Status</h5>
                </div>
                <ul class="list-group list-group-flush">
                @if($user_details[0]->is_active == 'Yes')

                <li class="list-group-item"><i class="fa fa-check"></i> {{ $user_details[0]->is_active }}</li>
                @elseif($user_details[0]->is_active == 'NO')

                <li class="list-group-item"><i class="fa fa-exclamation-triangle"></i> {{ $user_details[0]->is_active }}</li>
                @endif
                </ul>
            </div>

            <div class="card m-3">
                <div class="card-header">
                    <h5 class="text-dark">Personal Details</h5>
                </div>
                <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="fa fa-id-card"></i> {{ $user_details[0]->user_employee_id }}</li>
                <li class="list-group-item"><i class="fa fa-address-card"></i> {{ $user_details[0]->user_first_name }} {{ $user_details[0]->user_last_name }}</li>
                <li class="list-group-item"><i class="fa fa-sim-card"></i> {{ $user_details[0]->user_contact_no }}</li>
                <li class="list-group-item"><i class="fa fa-at"></i> {{ $user_details[0]->email }}</li>
                </ul>
            </div>

            <div class="card m-3">
                <div class="card-header">
                    <h5 class="text-dark">Role <span class="text-primary small">({{ $user_details[0]->role }}@if($service_provider_role == true) - [{{ $user_details[0]->user_service_provider }}]@endif)</span></h5>
                </div>
                <div class="card-body">
                    <h6 class="card-title"><b>Page Access</b></h6>
                    <p class="card-text"><li>Below are the pages which you have an access.</li></p>
                </div>
                <ul class="list-group list-group-flush">
                @foreach(explode(',',$user_role_details[0]->page_access) as $page_access_item)
                                
                    @if(!empty($page_access_item))
                    <li class="list-group-item"><i class="fa fa-key"></i> {{$page_access_item}}</li>
                    @endif
                
                @endforeach
                </ul>
                @if($masterlist_page_access == true)

                <div class="card-body">
                    <h6 class="card-title"><b>Master list Rights</b></h6>
                    <p class="card-text"><li>Below are your rights to Master list page</li></p>
                </div>
                <ul class="list-group list-group-flush">
                @foreach(explode(',',$user_role_details[0]->master_list_rights) as $master_list_rights_item)
                                
                    @if(!empty($master_list_rights_item))
                    <li class="list-group-item"><i class="fa fa-check"></i> {{$master_list_rights_item}}</li>
                    @endif
                
                @endforeach
                </ul>
                @endif
            </div>

            <div class="card m-3">
                <div class="card-header">
                    <h5 class="text-dark">Scoping <span class="text-primary small">({{ $user_scoping }})</span></h5>
                </div>
                <ul class="list-group list-group-flush">
                <li class="list-group-item"><i class="fa fa-map-marker"></i> <b class="text-primary">Region</b> - {{ $user_details[0]->user_region }}</li>
                <li class="list-group-item"><i class="fa fa-map-marker"></i> <b class="text-primary">Province</b> - {{ $user_details[0]->user_province }}</li>
                <li class="list-group-item"><i class="fa fa-map-marker"></i> <b class="text-primary">Municipality</b> - {{ $user_details[0]->user_municipality }}</li>
                <li class="list-group-item"><i class="fa fa-map-marker"></i> <b class="text-primary">Barangay</b> - {{ $user_details[0]->user_barangay }}</li>
                </ul>
            </div>

            <div class="card m-3">
                <div class="card-header">
                    <h5 class="text-dark">Reset Password</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <form method="POST" action="javascript:void(0);" id="change_password" onsubmit="submitChangePassword()">
                    @csrf
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Old Password:<span class="asterisk">*</span></span>
                                </div>
                                <input class="form-control" type="password" name="input_old_password" required />
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">New Password:<span class="asterisk">*</span></span>
                                </div>
                                <input class="form-control" type="password" name="new_password" required />
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Confirm New Password:<span class="asterisk">*</span></span>
                                </div>
                                <input class="form-control" type="password" name="new_password_confirmation" required />
                            </div>
                        </li>
                        <li class="list-group-item">
                            <button type="submit" class="btn btn-orange rounded">Reset Password</button>
                        </li>
                    </form>
                </ul>
                <center id="error-form">
                {{-- Result portion for Errors on Form --}}
                </center> 
            </div>
        </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Start of submit form using Sweet Alert -->

<script>
function submitChangePassword(){

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
                url: '{{ env('APP_URL') }}api/v1/profile/change-password',
                data: $("#change_password").serialize(),
                success: function(response) {

                    console.log(response);

                    if (response === 'Password successfully updated'){
                        Swal.fire('Saved!', 'Password successfully updated.', 'success');
                        location.reload();
                    }else{
                        Swal.fire('Password was not updated!', '', 'error');

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

@endsection

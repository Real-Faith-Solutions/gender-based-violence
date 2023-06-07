@extends('layout')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6" style="display: flex; align-items: center;">
        <h1 class="text-gray-800">Edit User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ env('APP_URL') }}admin/rights-management/user">User</a></li>
        <li class="breadcrumb-item active">Edit User</li>
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
            <form id="updateUserSubmit" method="POST" action="javascript:void(0);" onsubmit="submitForm()">
            @method('PUT')
            @csrf    
                <div class="row">
                    <div class="col mt-3 mb-3">
                        <h6 class="mb-3 fw-bold">Personal Details<span class="asterisk">*</span></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Last Name<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="user_last_name" value="{{ $user_id->user_last_name }}" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">First Name<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="user_first_name" value="{{ $user_id->user_first_name }}" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Middle Name<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="user_middle_name" value="{{ $user_id->user_middle_name }}" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Mobile Number<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="user_contact_no" value="{{ $user_id->user_contact_no }}" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">E-mail<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="email" name="email" value="{{ $user_id->email }}" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Employee ID<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="user_employee_id" value="{{ $user_id->user_employee_id }}" required />
                        </div>
                    </div>
                </div>
                <hr></hr>
                <div class="row">
                    <div class="col mt-3 mb-3">
                        <h6 class="mb-3 fw-bold">Account Details</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Username<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="username" value="{{ $user_id->username }}" required />
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
                                <option value="{{$roles->role_name}}" {{ ($user_id->role === $roles->role_name) ? "selected" : '' }}>{{$roles->role_name}}</option>
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
                            <select class="form-control" style="width:auto" name="user_service_provider" id="user_service_provider" onclick="changeDirectoryType()">
                            <option value="" selected>Please Select</option>
                                <option value="{{(!empty($user_id->user_service_provider)) ? $user_id->user_service_provider : ''}}" {{(!empty($user_id->user_service_provider)) ? 'selected' : ''}}>{{ $user_id->user_service_provider }}</option>
                                {{-- Drop-down list on this field are manipulated on changeDirectoryType() method below --}}
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Password Reset<span class="asterisk">*</span></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <div class="input-group mb-3">
                            <input class="form-control" type="password" name="password" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Confirm Password Reset<span class="asterisk">*</span></h6>
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
                            <input class="form-check-input" type="radio" name="is_active" id="is_active_yes_radio" value="Yes" {{ ($user_id->is_active === 'Yes') ? "checked" : '' }} required/>
                            <label class="form-check-label" for="is_active_yes_radio">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="is_active" id="is_active_no_radio" value="No" {{ ($user_id->is_active === 'No') ? "checked" : '' }} required/>
                            <label class="form-check-label" for="is_active_no_radio">No</label>
                        </div>
                    </div>
                </div>
                <hr></hr>
                <div class="row">
                    <div class="col mt-3 mb-3">
                        <h6 class="mb-3 fw-bold">Scoping</h6>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><span><p class="card-text">Region</p></span>
                        <select id="edit_user_region" aria-aria-controls='example' class="date-picker w-100 form-control" onclick="changeUserAddress()" >
                            <option value="{{ $user_id->user_region }}" selected>{{ $user_id->user_region }}</option>
                            {{-- Drop-down list on this field are manipulated on changeUserAddress() method below --}}
                        </select>
                        <input type="hidden" id="edit_user_region_id" name="user_region" value="{{ $user_id->user_region }}"/>
                    </div>
                    <div class="col"><span><p class="card-text">Province</p></span>
                        <select id="edit_user_province" aria-aria-controls='example' class="date-picker w-100 form-control" onclick="changeUserAddress()" >
                            <option value="{{ $user_id->user_province }}" selected>{{ $user_id->user_province }}</option>
                            {{-- Drop-down list on this field are manipulated on changeUserAddress() method below --}}
                        </select>
                        <input type="hidden" id="edit_user_province_id" name="user_province" value="{{ $user_id->user_province }}"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col"><span><p class="card-text">City/Municipality</p></span>
                        <select id="edit_user_municipality" aria-aria-controls='example' class="date-picker w-100 form-control" onclick="changeUserAddress()" >
                            <option value="{{ $user_id->user_municipality }}" selected>{{ $user_id->user_municipality }}</option>
                            {{-- Drop-down list on this field are manipulated on changeUserAddress() method below --}}
                        </select>
                        <input type="hidden" id="edit_user_municipality_id" name="user_municipality" value="{{ $user_id->user_municipality }}"/>
                    </div>
                    <div class="col"><span><p class="card-text">Barangay</p></span>
                        <select id="edit_user_barangay" aria-aria-controls='example' class="date-picker w-100 form-control" onclick="changeUserAddress()" >
                            <option value="{{ $user_id->user_barangay }}" selected>{{ $user_id->user_barangay }}</option>
                            {{-- Drop-down list on this field are manipulated on changeUserAddress() method below --}}
                        </select>
                        <input type="hidden" id="edit_user_barangay_id" name="user_barangay" value="{{ $user_id->user_barangay }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <a href="{{ env('APP_URL') }}admin/rights-management/user"><button type="button" class="btn btn-secondary me-2">Cancel</button></a>
                        <button type="submit" class="btn btn-orange rounded">Save Changes</button>
                    </div>
                </div>
                <center id="error-form" class="col mt-3 mb-3">
                {{-- Result portion for Errors on Form --}}
                </center>
            </form>
        </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Start of Javascript -->

<!-- Start of change address confirmation using Sweet Alert -->

<script>
function changeUserAddress(){

    Swal.fire({
        title: 'Do you want to change the address?',
        html: "<center>Existing address will be reset!</center>",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
    if (result.isConfirmed) {

        // Reset address field

        $('#edit_user_region').empty().attr('onclick', '');
        $('#edit_user_province').empty().attr('onclick', '');
        $('#edit_user_municipality').empty().attr('onclick', '');
        $('#edit_user_barangay').empty().attr('onclick', '');

        $('#edit_user_region').append('<option value="">Please Select</option>');

        // Reset hidden input address field

        $('#edit_user_region_id').val('');
        $('#edit_user_province_id').val('');
        $('#edit_user_municipality_id').val('');
        $('#edit_user_barangay_id').val('');

        // Automated Dropdowns Location

        var my_handlers = {

            // Personal Details
            fill_edit_user_provinces: function () {

                var region_code = $(this).val();
                $('#edit_user_province').ph_locations('fetch_list', [{ "region_code": region_code }]);

            },

            fill_edit_user_cities: function () {

                var province_code = $(this).val();
                $('#edit_user_municipality').ph_locations('fetch_list', [{ "province_code": province_code }]);
            },


            fill_edit_user_barangays: function () {

                var city_code = $(this).val();
                $('#edit_user_barangay').ph_locations('fetch_list', [{ "city_code": city_code }]);
            }

        };

        $(function () {

            // Personal Details
            $('#edit_user_region').on('change', my_handlers.fill_edit_user_provinces);
            $('#edit_user_province').on('change', my_handlers.fill_edit_user_cities);
            $('#edit_user_municipality').on('change', my_handlers.fill_edit_user_barangays);

            $('#edit_user_region').ph_locations({ 'location_type': 'regions' });
            $('#edit_user_province').ph_locations({ 'location_type': 'provinces' });
            $('#edit_user_municipality').ph_locations({ 'location_type': 'cities' });
            $('#edit_user_barangay').ph_locations({ 'location_type': 'barangays' });
            $('#edit_user_region').ph_locations('fetch_list');

            // Change select option to input box if Error fetching PH Location dropdown list
            $('#edit_user_region').on('click',function(){

                if($('#edit_user_region option:selected').val() == ''){

                    $('#edit_user_region').parent().empty().html(`
                        <span><p class="card-text">Region<span class="asterisk">*</span></p></span>
                        <input type="text" id="edit_user_region_id" name="user_region" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
                    `);
                    $('#edit_user_province').parent().empty().html(`
                        <span><p class="card-text">Province<span class="asterisk">*</span></p></span>
                        <input type="text" id="edit_user_province_id" name="user_province" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
                    `);
                    $('#edit_user_municipality').parent().empty().html(`
                        <span><p class="card-text">City/Municipality<span class="asterisk">*</span></p></span>
                        <input type="text" id="edit_user_municipality_id" name="user_municipality" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
                    `);
                    $('#edit_user_barangay').parent().empty().html(`
                        <span><p class="card-text">Barangay<span class="asterisk">*</span></p></span>
                        <input type="text" id="edit_user_barangay_id" name="user_barangay" placeholder="Error Fetching PH Location" class="w-100 form-control" required/>
                    `);
                                                        
                }
            });

        });

        // Personal Details get Address Name

        $('#edit_user_region').change(function(){
        $('#edit_user_region_id').val($("#edit_user_region option:selected").text());
        });
        $('#edit_user_province').change(function(){
        $('#edit_user_province_id').val($("#edit_user_province option:selected").text());
        });
        $('#edit_user_municipality').change(function(){
        $('#edit_user_municipality_id').val($("#edit_user_municipality option:selected").text());
        });
        $('#edit_user_barangay').change(function(){
        $('#edit_user_barangay_id').val($("#edit_user_barangay option:selected").text());
        });
        
    }
    });
}
</script>

<!-- End of change address confirmation using Sweet Alert -->

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
            $("#updateUserSubmit").serialize();
            $.ajax({
                type: "POST",
                url: '{{ env('APP_URL') }}api/v1/user/update/{{ $user_id->id }}',
                data: $("#updateUserSubmit").serialize(),
                success: function(response) {

                    if (response === 'The user account was successfully modified'){
                        Swal.fire('Saved!', 'The user account was successfully modified', 'success');
                        location.assign('{{ env('APP_URL') }}admin/rights-management/user');
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
                
                    $('#user_service_provider').attr('onclick','');

                    $('#user_service_provider').empty();

                    html = "";
                    html = "<option selected>Please Select</option>";
                    response.forEach(element => {
                        html += '<option value="'+ element['name'] +'">'+ element['name'] +'</option>';
                    });

                    $('#user_service_provider').prepend(html);
                }
            }); 
        }
    });
}
</script>

<!-- End of change Directory Type confirmation using Sweet Alert -->

<!-- End of Javascript -->

@endsection

@extends('layout_plain')

@section('content')
<!-- Outer Row -->
<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-password-image bg-black" style="background-image: url('{{ asset('images/gbv_logo_1.png') }}'); background-size: contain; background-repeat: no-repeat;"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-3">Reset Password</h1>
                            </div>
                            <form method="POST" action="javascript:void(0);" id="reset_password" onsubmit="submitResetPassword()">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="row mb-1">
                                    <div class="col">
                                        <span>Email Address</span>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $email }}" required autocomplete="email" autofocus>
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col">
                                        <span>Password</span>
                                        <input id="password" type="password" class="form-control " name="password" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-1">
                                    <div class="col">
                                    <span>Confirm Password</span>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Reset Password</button>
                                    </div>
                                </div> 
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ env('APP_URL') }}login">Go to Login</a>
                            </div>
                            <center id="error-form">
                            {{-- Result portion for Errors on Form --}}
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>

<!-- Start of submit form using Sweet Alert -->

<script>
function submitResetPassword(){

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
                url: '{{ env('APP_URL') }}api/v1/password/reset-password',
                data: $("#reset_password").serialize(),
                success: function(response) {

                    if (response === 'Your password was successfully reset'){
                        Swal.fire('Saved!', '<center>Your password was successfully reset.</center>', 'success');
                        location.assign('{{ env('APP_URL') }}login');
                    }
                    else if (response === 'User not found please check provided email'){
                        Swal.fire('Error!', '<center>User not found please check the provided email.</center>', 'error');
                    }
                    else if (response === 'Token was invalid or expired, try to take another request'){
                        Swal.fire('Error!', '<center>Token was invalid or expired, try to take another request. redirecting you to forgot password page</center>', 'error');
                        location.assign('{{ env('APP_URL') }}forgot-password');
                    }
                    else if (response === 'Throttled reset attempt'){
                        Swal.fire('Error!', '<center>Throttled reset attempt.</center>', 'error');
                        location.assign('{{ env('APP_URL') }}forgot-password');
                    }
                    else{
                        Swal.fire('<center>Your password was not updated!</center>', '', 'error');

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

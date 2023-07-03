@extends('layout_plain')

@section('content')
<!-- Outer Row -->
<div class="row justify-content-center mt-5 pt-5" style="height: 82vh; margin:auto;">
    <div class="col-xl-7 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-password-image bg-black" style="background-image: url('{{ asset('images/gbv_logo_1.png') }}'); background-size: contain; background-repeat: no-repeat;"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            @if($message_status == 'Reset password link successfully sent to your email')

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Reset link sent!</h1>
                                <p class="mb-4">{{ $message_status }}.</p>
                                <p class="mb-4">You may close this window.</p>
                            </div>
                            @elseif($message_status == 'User not found please check the provided email')

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Not found!</h1>
                                <p class="mb-4">{{ $message_status }}.</p>
                            </div>
                            <form class="user" action="{{ env('APP_URL') }}forgot-password">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" value="{{ $email }}" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Reset Password</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ env('APP_URL') }}login">Already have an account? Login!</a>
                            </div>
                            @elseif($message_status == 'Throttled reset attempt')

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Stop!</h1>
                                <p class="mb-4">Multiple request is not allowed please check your previous request first.</p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ env('APP_URL') }}login">Go to login</a>
                            </div>
                           @elseif($message_status == 'Throttled reset attempt')

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Stop!</h1>
                                <p class="mb-4">Multiple request is not allowed please check your previous request first.</p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ env('APP_URL') }}login">Go to login</a>
                            </div>
                            @elseif($message_status == 'The Server encounters an error for your request!')

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-2">Server Error!</h1>
                                <p class="mb-4">The Server encounters an error for your request!</p>
                                <p class="mb-4">Kindly coordinate with your Administrator.</p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ env('APP_URL') }}login">Go to login</a>
                            </div>
                            @else

                            <div class="text-center">
                                <p>{{ $message_status }}</p>
                                <h1 class="h4 text-gray-900 mb-2 text-sm-bold">Forgot your Password?</h1>
                                <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                            </div>
                            <form class="user" action="{{ env('APP_URL') }}forgot-password">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Reset Password</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ env('APP_URL') }}login">Already have an account? Login!</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
@endsection

@extends('layout_plain')

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center mt-5 pt-5" style="height: 82vh; margin:auto;">
        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card o-hidden border-0 shadow-lg my-2">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="p-5 mx-5">
                                <div class="text-center">
                                    <h1 class="h-2 text-gray-900 mb-4 ">Welcome to GBV</h1>
                                </div>
                                <form class="user" method="POST" action="{{ env('APP_URL') }}login">
                                    @csrf
                                    <!-- {{ csrf_field() }} -->
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email"
                                            aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" name="password"
                                            placeholder="Password">
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ env('APP_URL') }}forgot-password">Forgot Password?</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 mx-auto d-block bg-login-image bg-black"
                            style="background-image: url('{{ asset('images/gbv_logos.png') }}'); background-size: contain; background-repeat: no-repeat;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
@endsection

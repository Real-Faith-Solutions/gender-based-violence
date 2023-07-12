@extends('layout_plain')

@section('content')
    <!-- Outer Row -->

    <div class="row justify-content-center mt-5 pt-5" style="height: 82vh; margin:auto;">
        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card o-hidden border-0 shadow-lg my-2">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class=" col-sm-5">
                          <div class="p-5 mx-2">
                            <div class="text-center">
                                <h3 class=" text-gray-900 mb-2 text-sm-bold">Welcome</h3>
                                <P class="text-gray-900 mb-2 text-sm-bold">to</P>
                                <p class="text-gray-900 mb-2 text-sm-bold">Gender Base Violence Information Management System</p>
                            </div>
                            <form class="user" method="POST" action="{{ env('APP_URL') }}login">
                              @csrf
                              <div class="form-group">
                                <input type="email" class="form-control form-control-user" name="email" aria-describedby="emailHelp"
                                  placeholder="Enter Email Address...">
                              </div>
                              <div class="form-group">
                                <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                              </div>
                              <button class="btn btn-primary btn-user btn-block">
                                Login
                              </button>
                            </form>
                            <hr>
                            <div class="text-center">
                              <div class="d-flex flex-column">
                                <div class="p-0"><a class="small" href="{{ env('APP_URL') }}forgot-password">Forgot Password?</a></div>
                                <div class="p-0"><a class="small" href="{{ env('APP_URL') }}user" style="text-decoration: none; color:black">Add New User!</a></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-5 col-sm-7 mx-auto d-block bg-login-image bg-black fixed"
                          style="background-image: url('{{ asset('images/gbv_logos.png') }}'); background-size: contain; background-repeat: no-repeat;">
                        </div>
                      </div>

                </div>
            </div>
        </div>
    </div>
    <br />
@endsection

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function forgotPasswordHomePage(Request $request){

        if(!Auth::user()){

            if(!empty($request->email)){

                $validator = Validator::make(

                    array(
                        'email' => $request->email,
                    ),
    
                    array(
                        'email' => 'required|email',
                    )
    
                );
    
                if ($validator->fails()){
    
                    $errors = $validator->errors();
    
                    return $errors;
    
                }else{

                    // Try and catch error on sending emails

                    try{ 

                        $status = Password::sendResetLink(
                            $request->only('email')
                        );
                    }
                    catch (\Swift_TransportException $e){
                        
                        // Report an exception via the exception handler and set $message_status and $status variable
                        
                        report($e);

                        $message_status = 'The Server encounters an error for your request!';
                        $status = 'Server Error';
                    }
    
                    // Get status response

                    if($status === Password::RESET_LINK_SENT){

                        $message_status = 'Reset password link successfully sent to your email';
                    }
                    elseif($status === Password::PASSWORD_RESET){

                        $message_status = 'Your password was successfully reset';
                    }
                    elseif($status === Password::INVALID_USER){

                        $message_status = 'User not found please check the provided email';
                    }
                    elseif($status === Password::INVALID_TOKEN){

                        $message_status = 'Token was invalid or expired, try to take another request';
                    }
                    elseif($status === Password::RESET_THROTTLED){

                        $message_status = 'Throttled reset attempt';
                    }
    
                    return view('forgot_password', ['message_status' => $message_status, 'email' => $request->email]);
                }
                
            }else{

                return view('forgot_password', ['message_status' => '']);
            }

        }else{

            return Redirect::to('/');
        }

    }

    public function getPasswordResetPage(Request $request, $token){

        if(!Auth::user()){

            return view('reset-password', ['token' => $token, 'message_status' => '', 'email' => $request->email]);

        }else{

            return Redirect::to('/');
        }

    }

    public function getPasswordUpdatePage(Request $request){

        $token = $request->token;

        if(!Auth::user()){

            $validator = Validator::make(

                array(
                    'token' => $request->token,
                    'email' => $request->email,
                    'password' => $request->password,
                    'password_confirmation' => $request->password_confirmation,
                ),

                array(
                    'token' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:5|confirmed',
                )

            );

            if ($validator->fails()){

                $errors = $validator->errors();

                return $errors;

            }else{
         
                    $status = Password::reset(
                        $request->only('email', 'password', 'password_confirmation', 'token'),
                        function ($user, $password) {
                            $user->forceFill([
                                'password' => Hash::make($password)
                            ])->setRememberToken(Str::random(60));
                
                            $user->save();
                
                            event(new PasswordReset($user));
                        }
                    );

                    // Get status response

                    if($status === Password::RESET_LINK_SENT){

                        return 'Reset password link successfully sent to your email';
                    }
                    elseif($status === Password::PASSWORD_RESET){

                        return 'Your password was successfully reset';
                    }
                    elseif($status === Password::INVALID_USER){

                        return 'User not found please check provided email';
                    }
                    elseif($status === Password::INVALID_TOKEN){

                        return 'Token was invalid or expired, try to take another request';
                    }
                    elseif($status === Password::RESET_THROTTLED){

                        return 'Throttled reset attempt';
                    }
            
            }

        }else{

            return Redirect::to('/');
        }

    }
}

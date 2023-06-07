<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function userLogin(Request $request){
       
        // Validate input email and password

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return Redirect::to('/');
        }
        else{
            $response = [];
            $response['message'] = 'Login failed! Info mismatched.';
            $response['link'] = 'login';

            return view('message', compact('response'))->render();
        }
    }

    public function userLogout(Request $request){

        // Logout user, invalidate, and regenerate token session
        
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function userRegister(Request $request){
        User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return "Success Registration!";
    }
}

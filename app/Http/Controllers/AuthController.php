<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginPage(){

        if(Auth::check()) return redirect('/');

        return view('auth/login');
    }

    public function showRegisterPage(){

        if(Auth::check()) return redirect('/');

        return view('auth/register');
    }

    public function login(Request $request){
        
        $username = $request->username;
        $password = $request->password;
        $rememberMe = $request->input('rememberMe');
        $isRemember = false;

        if($rememberMe == "on"){
            $isRemember = true;
        }

        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        // if success
        if(Auth::attempt(['username'=>$username, 'password'=>$password], $isRemember)){
            
            // cookie
            if($isRemember){
                $minutes = 120;
                $key = Auth::getRecallerName();
                $value = Auth::user()->getRememberToken();
                Cookie::queue($key, $value, $minutes);
            }
            
            return redirect()->intended('');
        }
        else{
            return redirect('/auth/login')->withErrors('Invalid User Credentials');
        }
    }

    public function register(Request $request){

        $username = $request->username;
        $fullname = $request->fullname;
        $role = $request->role;
        $password = $request->password;


        $request->validate([
            'username'=>'required|string|unique:users,username|min:6',
            'fullname'=>'required|string',
            'password'=>'required|string|alpha_num|min:6',
            'role'=>'required|string|in:Member,Admin'
        ]);

        $password = Hash::make($request->password);
        if($role == "Member"){
            $roleId = 2;
        }
        else if($role == "Admin"){
            $roleId = 1;
        }

        // if success
        $uc = new UserController();
        $uc->insertUser($username, $fullname, $roleId, $password);
        return redirect('/');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->intended('');
    }

}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'inputname' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

                 //Attempt to login. If login fails, we simply redirect back to startpage. Too lazy to show something like 'wrong passowrd'
            if(!Auth::attempt(['email'=>$request->inputname,'password'=>$request->password,'enabled'=>1]))
                return redirect('/')->with('status', [(object)['status' => 'alert-danger', 'message' => "Invalid user/pw combination."]]);



        return redirect('/');

    }
    public function logout(Request $request){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}

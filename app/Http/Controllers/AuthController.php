<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    protected $loginPath = '/';
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

        if(Auth::attempt(['email'=>$request->inputname,'password'=>$request->password])){

        }
        return redirect('/');

    }
    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}

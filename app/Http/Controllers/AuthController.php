<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    	$request->validate([
    		'email' 	=> 'required',
    		'password' 	=> 'required'
    	]);

    	$email 		= $request->email;
    	$password 	= $request->password;
    	if (Auth::attempt(['email' => $email, 'password' => $password])) {
    		return response()->json([
    			'msg' => 'You are logged in'
    		]);
    	} else {
    		return response()->json([
    			'msg' => 'Invalid caredentials'
    		]);
    	}
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    	$request->validate([
    		'email' 	=> 'bail|required|email',
    		'password' 	=> 'required'
    	]);

    	$email 		= $request->email;
    	$password 	= $request->password;
    	if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $user = Auth::user();
            if ($user->userType == 'User') {
                Auth::logout();
                return response()->json([
                    'msg' => 'You do not have the permission!'
                ], 401);
            }
    		return response()->json([
    			'msg' => 'You are logged in',
                'user' => $user,
    		]);
    	} else {
    		return response()->json([
    			'msg' => 'Invalid caredentials'
    		], 401);
    	}
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

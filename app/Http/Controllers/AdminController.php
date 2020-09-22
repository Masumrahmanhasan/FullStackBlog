<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
 	public function createUser(Request $request)
 	{
 		$request->validate([
 			'fullName' 	=> 'required',
 			'email' 	=> 'bail|required|email',
 			'password' 	=> 'bail|required|min:6',
 			'userType' 	=> 'required',
 		]);

 		$password = bcrypt($request->password);

 		$user = User::create([
 			'fullName' => $request->fullName,
 			'email' => $request->email,
 			'password' => $password,
 			'userType' => $request->userType,
 		]);

 		return $user;
 	}

 	public function getUsers()
 	{
 		return User::where('userType', '!=', 'User')->get();
 	}
}

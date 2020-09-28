<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
	public function index(Request $request)
	{
		// first check if you are loggedin and admin user ...
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }

        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
        // you are already logged in... so check for if you are an admin user..
        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('login');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }
		return view('welcome');
	}
 	public function createUser(Request $request)
 	{
 		$request->validate([
 			'fullName' 	=> 'required',
 			'email' 	=> 'bail|required|email|unique:users',
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

 	public function update(Request $request)
 	{

 		$request->validate([
 			'fullName' 	=> 'required',
 			'email' 	=> "bail|required|email|unique:users,email,$request->id",
 			'password' 	=> 'min:6',
 			'userType' 	=> 'required',
 		]);

 		$data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'userType' => $request->userType,
        ];

 		$user = User::where('id', $request->id)->update($data);

 		return $user;
 	}

}

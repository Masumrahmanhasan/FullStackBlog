<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	public function index()
	{
		return Role::all();
	}
    public function store(Request $request)
    {

    	$request->validate([
    		'name' =>  'required',
    	]);

    	return Role::create([
    		'name' => $request->name,
    	]);
    }

}

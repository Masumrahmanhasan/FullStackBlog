<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function upload(Request $request){

    	$request->validate([
    		'file' => 'required|mimes:jpeg,jpg,png',
    	]);

        $iconImage = time().'.'.$request->file->extension();
        $request->file->move(storage_path('app/public/uploads'), $iconImage);
        return $iconImage;
    }
}

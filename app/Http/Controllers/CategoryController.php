<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller
{
	public function getCategories()
	{
		return Category::get()->all();
	}
	public function addCategory(Request $request){
		
    	$request->validate([
    		'iconImage' => 'required',
    		'categoryName' => 'required',
    	]);

    	return Category::create([
    		'iconImage' => $request->iconImage,
    		'categoryName' => $request->categoryName,
    	]);
	}
    public function upload(Request $request){

    	$request->validate([
    		'file' => 'required|mimes:jpeg,jpg,png',
    	]);

        $iconImage 	= time().'.'.$request->file->extension();
        $request->file->move(storage_path('app/public/uploads'), $iconImage);
        return $iconImage;
    }

    public function updateCategory(Request $request, $id){

        $request->validate([
            'iconImage' => 'required',
            'categoryName' => 'required',
        ]);

        $data['iconImage']      = $request->iconImage;
        $data['categoryName']   = $request->categoryName;

        return Category::findOrFail($id)->update($data);

    }

    public function deleteImage(Request $request){
    	$filename 	= $request->imageName;
    	$this->deleteFileFromServer($filename);
    	return 'success';
    }

    public function deleteFileFromServer($filename)
    {
    	$path 		= storage_path('app/public/').'uploads/'.$filename;
    	if (file_exists($path)) {
    		@unlink($path);
    	}
    	return;
    }
}

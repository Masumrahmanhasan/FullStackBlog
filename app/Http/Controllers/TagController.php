<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function allTag(){
        return Tag::orderBy('id', 'desc')->get();
    }

    public function addTag(Request $request){

        $request->validate(['tagName' => 'required']);
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function updateTag(Request $request, $id){
        $request->validate(['tagName' => 'required']);
        $data['tagName'] = $request->tagName;
        Tag::findOrFail($id)->update($data);
        return $data;
    }
    public function deleteTag($id){
        return Tag::findOrFail($id)->delete();
    }
}

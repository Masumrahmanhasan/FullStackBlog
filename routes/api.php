<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Tag crud
Route::post('add-tag', 'TagController@addTag');
Route::get('get-tag-list', 'TagController@allTag');
Route::put('update-tag/{id}', 'TagController@updateTag');
Route::delete('delete-tag/{id}', "TagController@deleteTag");

// Category
Route::post('upload', 'CategoryController@upload');
Route::post('delete-image', 'CategoryController@deleteImage');
Route::post('add-category', 'CategoryController@addCategory');
Route::get('get-categories', 'CategoryController@getCategories');
Route::put('update-category/{id}', 'CategoryController@updateCategory');
Route::delete('detele-category/{id}', 'CategoryController@delete');

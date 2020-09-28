<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Tag crud
Route::group(['prefix' => 'api'], function() {
    
	Route::post('/add-tag', [TagController::class, 'addTag']);
	Route::get('/get-tag-list', [TagController::class, 'allTag']);
	Route::put('/update-tag/{id}', [TagController::class, 'updateTag']);
	Route::delete('/delete-tag/{id}', [TagController::class, 'deleteTag']);

	// Category
		// image upload
	Route::post('/upload', [CategoryController::class, 'upload']);
	Route::post('/delete-image', [CategoryController::class, 'deleteImage']);

	Route::post('/add-category', [CategoryController::class, 'addCategory']);
	Route::get('/get-categories', [CategoryController::class, 'getCategories']);
	Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory']);
	Route::delete('/detele-category/{id}', [CategoryController::class, 'delete']);

	// Admin user

	Route::post('/create_user', [AdminController::class, 'createUser']);
	Route::get('/get_users', [AdminController::class, 'getUsers']);
	Route::post('/update-user', [AdminController::class, 'update']);


	//Login 
	Route::post('/admin_login',[AuthController::class, 'login']);
	Route::get('/logout', [AuthController::class, 'logout']);
});

Route::get('/', 'AdminController@index');
Route::any('{slug}', 'AdminController@index');
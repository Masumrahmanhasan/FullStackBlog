<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
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
Route::post('add-tag', [TagController::class, 'addTag']);
Route::get('get-tag-list', [TagController::class, 'allTag']);
Route::put('update-tag/{id}', [TagController::class, 'updateTag']);
Route::delete('delete-tag/{id}', [TagController::class, 'deleteTag']);

// Category
	// image upload
Route::post('upload', [CategoryController::class, 'upload']);
Route::post('delete-image', [CategoryController::class, 'deleteImage']);

Route::post('add-category', [CategoryController::class, 'addCategory']);
Route::get('get-categories', [CategoryController::class, 'getCategories']);
Route::put('update-category/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('detele-category/{id}', [CategoryController::class, 'delete']);

// Admin user

Route::post('create_user', [AdminController::class, 'createUser']);
Route::get('get_users', [AdminController::class, 'getUsers']);
Route::post('update-user', [AdminController::class, 'update']);


//Login 

Route::post('admin_login',[AuthController::class, 'login']);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\PostAdminController;
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

Route::post('admin/login',[LoginController::class, 'adminLogin'])->name('clientLogin');
Route::post('admin/register',[LoginController::class, 'registerAdmin'])->name('registerAdmin');
Route::group( ['prefix' => 'admin','middleware' => ['auth:admin-api','scopes:admin'] ],function(){
    // authenticated staff routes here 
    Route::get('dashboard',[LoginController::class, 'adminDashboard']);


    Route::get('user',[ManageUserController::class, 'index']);
    Route::get('user/show/{id}',[ManageUserController::class, 'show']);
    Route::get('user/edit/{id}',[ManageUserController::class, 'edit']);
    Route::post('user/create',[ManageUserController::class, 'create']);
    Route::post('user/update/{id}',[ManageUserController::class, 'update']);
    Route::post('user/delete/{id}',[ManageUserController::class, 'delete']);

    Route::get('post',[PostAdminController::class, 'index']);
    Route::get('post/show/{id}',[PostAdminController::class, 'show']);
    Route::get('post/edit/{id}',[PostAdminController::class, 'edit']);
    Route::post('post/create',[PostAdminController::class, 'create']);
    Route::post('post/update/{id}',[PostAdminController::class, 'update']);
    Route::post('post/delete/{id}',[PostAdminController::class, 'delete']);


});
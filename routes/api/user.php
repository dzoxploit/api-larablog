<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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

Route::post('user/login',[LoginController::class, 'userLogin'])->name('userLogin');
Route::post('user/register',[LoginController::class, 'registerUser'])->name('registerUser');
Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
   // authenticated staff routes here 
    Route::get('dashboard',[LoginController::class, 'userDashboard']);

    Route::get('post',[PostUserController::class, 'index']);
    Route::get('post/show/{id}',[PostUserController::class, 'show']);
    Route::get('post/edit/{id}',[PostUserController::class, 'edit']);
    Route::post('post/create',[PostUserController::class, 'create']);
    Route::post('post/update/{id}',[PostUserController::class, 'update']);
    Route::post('post/delete/{id}',[PostUserController::class, 'delete']);

});
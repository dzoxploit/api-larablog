<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Hash;
use Validator;
use Auth;

class LoginController extends Controller
{
    public function userDashboard()
    {
        $success =  [
            "Message" => 'Welcome to User Dashboard',
            "Name" => Auth::user()->name
        ];

        return response()->json($success, 200);
    }

    public function adminDashboard()
    {
        $users = User::all();
        $success = [
            "Message" => 'Welcome to Admin Dashboard',
            "Data_user" => $users
        ];

        return response()->json($success, 200);
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){
            config(['auth.guards.api.provider' => 'user']);
            
            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('appToken',['user'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'admin']);
            
            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('appToken',['admin'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }


    public function registerUser(Request $request){
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' =>'required|email',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
                ]);
 
                if($validator->fails()){
                    return response()->json($validator->errors(), 400);     
                }
 
                $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $success['token'] =  $user->createToken('appToken',['user'])->accessToken; 
                $success['name'] =  $user->name;
 
                 return response()->json($success, 200);
    }
    public function registerAdmin(Request $request){
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' =>'required|email',
                    'password' => 'required',
                    'c_password' => 'required|same:password',
                ]);
 
                if($validator->fails()){
                    return response()->json($validator->errors(), 400);      
                }
 
                $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $admin = Admin::create($input);
                $success['token'] =  $admin->createToken('appToken',['admin'])->accessToken; 
                $success['name'] =  $admin->name;
 
                return response()->json($success, 200);
    }

}
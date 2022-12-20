<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Hash;
use Validator;
use Auth;
use DB;

class ManageUserController extends Controller
{
    public function index(){
        $users = User::all();
        $success = [
            "Message" => 'Berikut ini adalah list user',
            "Data_user" => $users
        ];

        return response()->json($success, 200);
    }
    public function show($id){
          $users = User::where('id',$id)->firstOrFail();
            $success = [
                "Message" => 'Show Data User By Id',
                "Data_user" => $users
            ];

            return response()->json($success, 200);
    }

    public function create(Request $request){
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

    public function edit($id){
          $users = User::where('id',$id)->firstOrFail();
            $success = [
                "Message" => 'Show Data User By Id',
                "Data_user" => $users
            ];

            return response()->json($success, 200);
    }
    public function update(Request $request, $id){
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
                $user = User::where('id',$id)->update($input);
                $success['name'] =  $user->name;
 
                 return response()->json($success, 200);
    }
    public function delete($id){
        $user = User::delete($id);

        DB::statement("SET @count = 0;");
        DB::statement("UPDATE `users` SET `users`.`id` = @count:= @count + 1;");
        DB::statement("ALTER TABLE `users` AUTO_INCREMENT = 1;");
    
        $success = [
            'Message' => 'Delete successfully',
            'data' => $user
        ];

        return response()->json($success, 200);
    }

}

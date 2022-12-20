<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use Validator;
use Auth;
use DB;
use Illuminate\Support\Str;

class PostAdminController extends Controller
{
     public function index(){
        $posts = Post::with('admin')->where('is_delete','=',0)->get();
        $success = [
            "message" => 'This is list Post Admin Mode',
            "data" => $posts
        ];

        return response()->json($success, 200);
    }
    public function show($id){
          $posts = Post::with('admin')->where('is_delete','=',0)->where('id',$id)->firstOrFail();
            $success = [
                "message" => 'Show Data Post By Id',
                "data" => $posts
            ];

            return response()->json($success, 200);
    }

    public function create(Request $request){
                $validator = Validator::make($request->all(), [
                    'header' => 'required',
                    'summmary' =>'required',
                    'content' => 'required',
                    'status' => 'required',
                ]);
 
                if($validator->fails()){
                    return response()->json($validator->errors(), 400);     
                }
                $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
                $input = $request->all();
                $input['admin_id'] = $admin->id;
                $input['slug'] =  Str::slug($input['header']);
                $input['is_delete'] =  false;
                $posts = Post::create($input);
                $success = [
                    "message" => 'Create Post Successfully',
                    'data' => $posts
                ];

                return response()->json($success, 200);
    }

    public function edit($id){
          $posts = Post::where('id',$id)->firstOrFail();
            $success = [
                "message" => 'Edit Data User By Id',
                "data" => $posts
            ];

            return response()->json($success, 200);
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
                    'header' => 'required',
                    'summmary' =>'required',
                    'content' => 'required',
                    'status' => 'required',
                ]);
 
                if($validator->fails()){
                    return response()->json($validator->errors(), 400);     
                }
                $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
                $input = $request->all();
                $input['admin_id'] = $admin->id;
                $input['slug'] =  Str::slug($input['header']);
                $input['is_delete'] =  false;
                $posts = Post::where('id',$id)->update($input);
                $success = [
                    "message" => 'Update Posts Successfully',
                    'data' => $posts
                ];

                return response()->json($success, 200);
    }
    public function delete($id){
        $posts = Post::delete($id);

        DB::statement("SET @count = 0;");
        DB::statement("UPDATE `posts` SET `posts`.`id` = @count:= @count + 1;");
        DB::statement("ALTER TABLE `posts` AUTO_INCREMENT = 1;");
    
        $success = [
            'Message' => 'Delete successfully',
            'data' => $posts
        ];

        return response()->json($success, 200);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Validator;
use Auth;
use DB;

class PostDefaultController extends Controller
{
     public function index(){
        $posts = Post::all();
        $success = [
            "Message" => 'Berikut ini adalah list Article Blog',
            "Data_user" => $posts
        ];

        return response()->json($success, 200);
    }
    public function show($slug){
          $blogs = User::where('slug',$slug)->where('is_delete','=',0)->firstOrFail();
            $success = [
                "Message" => 'Show Data Article Blog',
                "Data_blog" => $blogs
            ];

            return response()->json($success, 200);
    }
}

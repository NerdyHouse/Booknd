<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
{
    public function index() {
        
        $posts = Post::orderBy('created_at', 'desc')->get();
        
        return view('blog',['posts' => $posts]);
    }
    
    public function show($slug) {
        
        
        $post = Post::where('slug',$slug)->first();
        
        return view('post', ['post' => $post]);
    }
}

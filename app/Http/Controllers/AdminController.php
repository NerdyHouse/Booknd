<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Validator;

class AdminController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
    }
    
    public function index(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        return view('admin/index');
    }
    
    public function posts(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        
        $posts = Post::orderBy('created_at', 'desc')->get();
        
        return view('admin/posts/index',['posts' => $posts]);
    }
    
    public function createPostForm(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        return view('admin/posts/create');
    }
    
    public function createPost(Request $request) {
        
        $request->user()->authorizeRoles(['admin']);
        
        $messages = [
            'required'  => 'This field is required'
        ];
        
        $validator = Validator::make($request->all(), [
            'ptitle' => 'required',
            'pbody' => 'required'
        ],$messages);
        if ($validator->fails()) {
            return redirect('admin/posts/new')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $newPost = new Post;
        $newPost->title = $request->ptitle;
        $newPost->body = $request->pbody;
        $newPost->slug = str_slug($request->ptitle, '-');
        $newPost->seo_title = $request->ptitle;
        $newPost->save();
        
        return redirect('admin/posts')->with('saved',['saved']);
    }
    
    public function singlePost(Request $request, $id) {
        $request->user()->authorizeRoles(['admin']);
        
        $post = Post::find($id);
        
        return view('admin/posts/single',['post' => $post]);
    }
    
    public function updatePost(Request $request, $id) {
        $request->user()->authorizeRoles(['admin']);
        
        $messages = [
            'required'  => 'This field is required'
        ];
        
        $validator = Validator::make($request->all(), [
            'ptitle' => 'required',
            'pbody' => 'required'
        ],$messages);
        if ($validator->fails()) {
            return redirect('admin/posts/new')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $post = Post::find($id);
        $post->title = $request->ptitle;
        $post->body = $request->pbody;
        $post->save();
        
        return redirect('admin/posts')->with('updated',['updated']);
    }
    
    public function userList(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        
        $users = User::all();
        
        return view('admin/users',['users' => $users]);
    }
}

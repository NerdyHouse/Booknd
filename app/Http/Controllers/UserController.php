<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use App\Book;
use Illuminate\Http\Request;
use App\Library\FriendFunctions;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/home');
    }
    
    public function show($id, Request $request) {
        
        $user = $request->user();
        
        if($user->id == $id) {
            return redirect('dashboard');
        }
        
        $bookndUser = User::find($id);
        $status = FriendFunctions::isFriend($user->id, $bookndUser->id);
        
        $userBooks      = User::find($id)->books()->where('active',1)->get();
        $myBooks        = User::find($user->id)->books()->where('active',1)->get();
        $myReviews      = User::find($user->id)->reviews()->get();
        $myReviews->load('book');
        
        $userBooks->transform(function($book,$key) use ($myReviews, $myBooks, $user) {
            
            if($myReviews) {
                $myReview = $myReviews->filter(function($review,$key) use ($book) {
                    return $review->book_id == $book->id;
                })->first();
            }
            
            $myBookStatus = $myBooks->filter(function($myBook,$key) use ($book) {
                return $myBook->id == $book->id;
            })->first();
            
            $book->my_review    = $myReview;
            if($myBookStatus) {
                $bookshelf          = Book::find($myBookStatus->id)->bookshelfs()->where('user_id',$user->id)->first();
                $book->status       = $bookshelf->status;
            }
            return $book;
        });
        
        return view('users/user',['user' => $bookndUser,'status' => $status,'books' => $userBooks]);
    }
}

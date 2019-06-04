<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use App\Book;
use App\Http\Controllers\BookshelfController;
use Illuminate\Http\Request;

use App\Library\FriendFunctions;

class DashboardController extends Controller
{
    
    protected $books;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookshelfController $books)
    {
        $this->middleware('auth');
        $this->books = $books;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $user           = $request->user();
        $friendRequests = Friend::where('friend_id',$user->id)->where('status','pending')->get();
        $friends        = FriendFunctions::userFriends($user->id);
        
        $myBooks        = User::find($user->id)->books()->where('active',1)->get();
        $myReviews      = User::find($user->id)->reviews()->get();
        $myReviews->load('book');
        
        $myBooks->transform(function($book,$key) use ($myReviews, $user) {
            $myReview = $myReviews->filter(function($review,$key) use ($book) {
                return $review->book_id == $book->id;
            })->first();
            $book->my_review    = $myReview;
            
            $bookshelf          = Book::find($book->id)->bookshelfs()->where('user_id',$user->id)->first();
            $book->status       = $bookshelf->status;
            return $book;
        });
        
        return view('users/dashboard',['myBooks' => $myBooks, 'friendRequests' => $friendRequests,'friends' => $friends,'reviews' => $myReviews]);
    }
}

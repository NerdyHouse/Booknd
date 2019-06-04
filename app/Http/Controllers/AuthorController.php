<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use App\Book;
use App\User;

class AuthorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::orderBy('name','asc')->paginate(12);
        return view('/authors/index',['authors' => $authors]);
    }
    
    public function show($id, Request $request) {
        
        $author = Author::where('id',$id)->first();
        $books  = Book::where('author_id',$id)->paginate(12);
        
        $user = $request->user();
        
        if($user) {
            $myBooks        = User::find($user->id)->books()->where('active',1)->get();
            $myReviews      = User::find($user->id)->reviews()->get();
            $myReviews->load('book');
            
            $books->transform(function($book,$key) use ($myReviews,$myBooks,$user) {
                
                $myReview = $myReviews->filter(function($review,$key) use ($book) {
                    return $review->book_id == $book->id;
                })->first();
                
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
        }
        
        return view('/authors/show',['author' => $author,'books' => $books]);
    }
}

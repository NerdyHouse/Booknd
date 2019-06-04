<?php

namespace App\Http\Controllers;

use App\User;
use App\Review;
use App\Book;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function check(Request $request) {
        $user = $request->user();
        
        if($request->has('book')) {
            $book = Book::find($request->book);
            $review = Review::where('user_id',$user->id)->where('book_id',$request->book)->first();
            if($review) {
                return response()->json([
                    'error'     => false,
                    'review'    => $review,
                    'book'      => $book,
                ]);
            } else {
                return response()->json([
                    'error'     => false,
                    'book'      => $book,
                ]);
            }
        } else {
            return response()->json([
                'error'     => true,
                'message'   => 'No book was supplied for the review',
            ]);
        }
    }
    
    public function save(Request $request) {
        $user = $request->user();
        
        if(!$request->has('rating')) {
            return response()->json([
                'error'     => true,
                'message'   => 'You must select a rating to continue.',
            ]);
        }
        
        if($request->has('book')) {
            
            $review = Review::where('user_id',$user->id)->where('book_id',$request->book)->first();
            if(!$review) {
                $review = new Review;
                $review->user_id = $user->id;
                $review->book_id = $request->book;
            }
            
            $review->rating = $request->rating;
            if($request->has('review')) {
                $review->review = $request->review;
            } else {
                $review->review = '';
            }
            $review->save();
            return response()->json([
                'error'     => false,
                'message'   => 'Your review was successfully saved!',
            ]);
            
        } else {
            return response()->json([
                'error'     => true,
                'message'   => 'No book was supplied for the review',
            ]);
        }
    }
}

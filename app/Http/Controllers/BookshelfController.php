<?php

namespace App\Http\Controllers;

use App\User;
use App\Book;
use App\Bookshelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookshelfController extends Controller
{
    /*
     * I want this to be fairly locked down functionality
     * So we use our auth middleware to make MOST functionality
     * only work for the authenticated user
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = User::find(Auth::user()->id)->books()->get();
        $books->load('author');
        $myReviews      = User::find(Auth::user()->id)->reviews()->get();
        $books->transform(function($book,$key) use ($myReviews) {
            $myReview = $myReviews->filter(function($review,$key) use ($book) {
                return $review->book_id == $book->id;
            })->first();
            $book->my_review = $myReview;
            return $book;
        });
        
        return view('users/bookshelf.index',['books' => $books,'myReviews' => $myReviews]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $user = $request->user();
        
        // Check if the user has the book
        $shelf = false;
        if($user && $request->has('book')) {
            $shelf = Bookshelf::where('user_id',$user->id)
                     ->where('book_id',$request->book)
                     ->first();
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error adding the book'
            ]);
        }
        
        // First see if the user USED to have the book and update if so
        if($shelf) {
            
            // Store the book title
            $book = Book::find($request->book);
            $title = $book->title;
            
            $shelf->active = 1;
            $shelf->save();
            return response()->json([
                'code'      => 1,
                'message'   => $title.' was added to your bookshelf'
            ]);
            
        // if not create it
        } else {
            
            $book = Book::find($request->book);
            $title = $book->title;
            
            $shelf = new Bookshelf;
            $shelf->book_id = $request->book;
            $shelf->user_id = $user->id;
            $shelf->status  = 'in';
            $shelf->active  = 1;
            $shelf->save();
            return response()->json([
                'code'      => 1,
                'message'   => $title.' was added to your bookshelf'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        $book->load('author');
        
        return view('users/bookshelf.show',['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    
    public function updateBookshelf(Request $request)
    {
        
        $user = $request->user();
        
        $shelf = false;
        if($user && $request->has('book')) {
            $shelf = Bookshelf::where('book_id',$request->book)
                     ->where('user_id',$user->id)->first();
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error updating the book'
            ]);
        }
        
        if($request->has('status')) {
            $shelf->status = $request->status;
        } else if($request->has('active')) {
            $shelf->active = $request->active;
        }
        
        if($shelf->save()) {
            return response()->json([
                'code'      => 1,
                'message'   => 'The book was updated'
            ]);
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error updating the book'
            ]);
        }

    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // OOPS...
    public function update(Request $request, $id)
    {
        
        $user = $request->user();
        
        $shelf = false;
        if($user && $request->has('book')) {
            $shelf = Bookshelf::where('book_id',$request->book)
                     ->where('user_id',$user->id)->first();
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error updating the book'
            ]);
        }
        
        if($request->has('status')) {
            $shelf->status = $request->status;
        } else if($request->has('active')) {
            $shelf->active = $request->active;
        }
        
        if($shelf->save()) {
            return response()->json([
                'code'      => 1,
                'message'   => 'The book was updated'
            ]);
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error updating the book'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

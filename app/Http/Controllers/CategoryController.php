<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use App\Book;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$categories = Category::all();
        $categories = Category::orderBy('name', 'asc')->paginate(30);
        
        return view('category.index',['categories' => $categories]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $books = Category::find($id)->books()->paginate(12);
        $category = Category::find($id);
        
        $user = $request->user();
        
        if($user) {
            // Also get our reviews and add them
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
        
        return view('category.show',['books' => $books,'category' => $category]);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

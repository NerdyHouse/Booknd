<?php

namespace App\Http\Controllers;
use App\Book;
use App\Author;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $recentBooks = Book::orderBy('created_at', 'desc')->take(12)->get();
        $recentAuthors = Author::orderBy('created_at', 'desc')->take(6)->get();
        
        return view('home',['recentBooks' => $recentBooks,'recentAuthors' => $recentAuthors]);
    }
}

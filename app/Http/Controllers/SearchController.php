<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\BookshelfServiceProvider;
use App;
use App\Library;
use App\Library\FriendFunctions;
use App\Friend;
use App\User;
use App\Book;

class SearchController extends Controller
{
    public function __construct()
    {
    }
    
    public function index(Request $request)
    {
        // We like to have the user
        $user           = $request->user();
        
        // Get the search query
        $query          = $request->search_query;
        $rawQ           = $request->search_query;
        
        // By default we are not searching for anything
        $searchFor      = false;
        $bookSearch     = false;
        $authorSearch   = false;
        $userSearch     = false;
        
        // But we check this junk in case we are...
        if($request->has('search_for')) {
            
            $searchFor  = $request->search_for;
            
            // With books, it's 1 or the other
            if(in_array('title', $searchFor)) {
                $bookSearch     = 'title';
            } else if(in_array('isbn', $searchFor)) {
                $bookSearch     = 'isbn';
            } else if(in_array('bauthor', $searchFor)) {
                $bookSearch     = 'bauthor';
            }
            
            // Search authors?
            if(in_array('author', $searchFor)) {
                $authorSearch   = true;
            }
            
            // Search users?
            if(in_array('user', $searchFor)) {
                $userSearch     = true;
            }
           
        }
        
        // Get the books
        if($bookSearch) {
            if($request->has('book_page')) {
                $skip = $request->book_page * 50;
                //$books = App\Book::search($query)->paginate(50,'',2);
                if($bookSearch === 'isbn') {
                    $books = App\Book::where('isbn10',$query)
                            ->orWhere('isbn13',$query)
                            ->skip($skip)
                            ->take(50)
                            ->get();
                } else if($bookSearch === 'title') {
                    $books = App\Book::where('title','like','%'.$query.'%')
                            ->skip($skip)
                            ->take(50)
                            ->get();
                } else if($bookSearch === 'bauthor') {
                    $bookAuthor = App\Author::where('name','like','%'.$query.'%')->first();
                    $bookAuthorID = 0;
                    $books = App\Book::where('author_id',$bookAuthorID)
                            ->skip($skip)
                            ->take(50)
                            ->get();
                }
            } else {
                //$books = App\Book::search($query)->paginate(50,'',1);
                if($bookSearch === 'isbn') {
                    $books = App\Book::where('isbn10',$query)
                            ->orWhere('isbn13',$query)
                            ->take(50)
                            ->get();
                } else if($bookSearch === 'title') {
                    $books = App\Book::where('title','like','%'.$query.'%')
                            ->take(50)
                            ->get();
                } else if($bookSearch === 'bauthor') {
                    $bookAuthor = App\Author::where('name','like','%'.$query.'%')->first();
                    $bookAuthorID = 0;
                    if($bookAuthor) { $bookAuthorID = $bookAuthor->id; } 
                    $books = App\Book::where('author_id',$bookAuthorID)
                            ->take(50)
                            ->get();
                }
            }
        };
        
        // authors and users for the query
        if($authorSearch) { $authors  = App\Author::search($query)->get(); };
        if($userSearch) { $users      = App\User::search($query)->get(); };
        
        // Create na empty results array
        $results    = [];
        
        // If there are books we also load auth user bookshelves
        if($bookSearch && $books->isNotEmpty()) {
            if($user) {
                
                // we always get the user books and reviews - need a provider...
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
                    
                    $book->my_review = $myReview;
                    if($myBookStatus) {
                        $bookshelf          = Book::find($myBookStatus->id)->bookshelfs()->where('user_id',$user->id)->first();
                        $book->status       = $bookshelf->status;
                    }
                    return $book;
                });
            }
            $results['books']['local'] = $books;
            $results['books']['local_count'] = count($books);
            $results['books']['total_count'] = count($books);
            
        }
        
        // If there are few or no books in the database we search openlib
        if(!isset($results['books']['local_count']) || $results['books']['local_count'] < 50) {
            $limit = 50;
            if(isset($results['books']['local_count'])) {
                $limit -= $results['books']['local_count'];
            }
            
            $offset = 0;
            if($request->has('book_page')) {
                $offset = $request->book_page * 50;
            }
            
            $search      = new Library\RemoteSearch;
            $olBooks     = $search->openLibSearch($query,$bookSearch,$limit,$offset);
            
            // Clean up some data
            $numFound = intval($olBooks['num_found']);
            foreach ($olBooks['docs'] as $key => $book) {
                if(!array_key_exists('isbn', $olBooks['docs'][$key])) {
                    unset($olBooks['docs'][$key]);
                    $numFound -= 1;
                }
                else if(isset($olBooks['docs'][$key]['language'])) {
                    if(!in_array('eng', $olBooks['docs'][$key]['language'])) {
                        unset($olBooks['docs'][$key]);
                        $numFound -= 1;
                    }
                }
            }
            //$olBooks['docs'] = array_values($olBooks['docs']);
            $olBooks['num_found'] = $numFound;
            if(isset($results['books']['total_count'])) {
                $results['books']['total_count'] += $numFound;
            } else {
                $results['books']['total_count'] = $numFound;
            }
            
            // Return results
            $results['books']['openlib'] = $olBooks;
        }
        
        // Calculate if paging for books required
        if(intval($results['books']['total_count'] > 50)) {
            $pages = ceil(intval($results['books']['total_count'])/50);
            $results['books']['pages'] = $pages;
        }
        if($request->has('book_page')) {
            $results['books']['current_page'] = $request->book_page+1;
        } else {
            $results['books']['current_page'] = 1;
        }
            
        
        // Now get authors
        if($authorSearch && $authors->isNotEmpty()) { $results['authors'] = $authors; }
        
        // Now get users
        if($userSearch && $users->isNotEmpty()) {
            if($user) {
                $myFriends  = FriendFunctions::userFriendsIdsWithStatus($user->id);
                $users->transform(function($friend,$key) use ($myFriends) {
                    if(array_key_exists($friend->id, $myFriends)) {
                        $friend['status'] = $myFriends[$friend->id];
                    }
                    return $friend;
                });
            }
            $results['users'] = $users;
        }
        
        return view('search',['results' => $results, 'query' => $rawQ, 'searchfor' => $searchFor]);
    }
}

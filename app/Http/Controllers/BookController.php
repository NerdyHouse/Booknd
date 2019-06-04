<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use ApaiIO\Configuration\GenericConfiguration;
//use ApaiIO\Operations\Search;
//use ApaiIO\ApaiIO;
//use Nathanmac\Utilities\Parser\Facades\Parser;
use App\Library;
use App\Book;
use App\Bookshelf;
use App\Author;
use App\Category;
use App\Review;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    
    public function __construct()
    {
    }
    
    /*
     * Add a database table to keep track of requests
     * Should be unix timestamped, and each call will check the database, so this will act essentially
     * as a queing system to ensure we meet Amazon api limits
     * OR
     * Set up laravel queue worker in the DB
     */
    public function index(Request $request) {
        
    }
    
    // Add author return id
    public function addAuthor($name,$id) {
        $image  = 'http://covers.openlibrary.org/a/olid/'.$id.'-M.jpg';
        $author = Author::firstOrCreate(
            ['olid' => $id], ['name' => $name, 'image' => $image]
        );
        return $author->id;
    }
    
    // Add genres return ids
    public function addGenres($genres) {
        $retIDs = array();
        foreach($genres as $genre) {
            $genreID = Category::firstOrCreate(
                ['name' => $genre]
            );
            $retIDs[] = $genreID->id;
        }
        return $retIDs;
    }
    
    // Add the actual book
    public function addBook($bookData) {
        $book = Book::firstOrCreate(
            ['isbn10' => $bookData['isbn10']],
            [
                'title'         => $bookData['title'],
                'author_id'     => $bookData['authorid'],
                'author_name'   => $bookData['author'],
                'summary'       => '',
                'isbn13'        => $bookData['isbn13'],
                'image'         => $bookData['image'],
                'publish'       => $bookData['year'],
                'olid'          => $bookData['olid']
            ]
        );
        return $book->id;
    }
    
    // Connect a book to cats
    public function addBookCategories($bookID,$catIDs) {
        $connections = [];
        foreach($catIDs as $catID) {
            $connections[] = ['book_id' => $bookID, 'category_id' => $catID];
        }
        
        DB::table('books_categories')->insert($connections);
        
        return;
    } 
    
    // Handles adding a book to the database and the bookshelf
    public function externalAdd(Request $request) {
        
        if($request->has('bookid')) {
            
            $user   = $request->user();
            $bookid = $request->bookid;
            
            if($user) {
                
                // Search the collection
                $search = new Library\RemoteSearch;
                
                // Create the edition string
                $editionsStr = '';
                $comma = '';
                $titleMatch = false;
                if($request->has('single')) {
                    $editionsStr = 'OLID:'.$request->bookid;
                } else {
                    $books  = $search->openLibSearch($bookid,'olid');
                    $titleMatch = $books['docs'][0]['title_suggest'];
                    foreach($books['docs'] as $book) {
                        foreach($book['edition_key'] as $edition) {
                            $editionsStr .= $comma.'OLID:'.$edition;
                            $comma = ',';
                        }
                    }
                }
                
                // Get the individual editions
                $bookData = $search->openLibBooks($editionsStr);
                //dd($bookData);
                
                // Remove any books that don't have isbn
                $returnBooks = array();
                foreach ($bookData as $book) {
                    if(isset($book['identifiers']['isbn_10']) || isset($book['identifiers']['isbn_13'])) {
                        if(!$titleMatch || (stripos($book['title'],$titleMatch) !== false)) {
                        
                            // Create our own simplified array
                            $bookData               = [];
                            $bookData['title']      = $book['title'];
                            $bookData['year']       = isset($book['publish_date']) ? $book['publish_date'] : NULL;
                            $bookData['author']     = isset($book['authors']) ? $book['authors'][0]['name'] : NULL;
                            $bookData['authorolid'] = isset($book['authors']) ? Library\Helpers::getAuthorIdFromUrl($book['authors'][0]['url']) : NULL;
                            $bookData['isbn10']     = isset($book['identifiers']['isbn_10']) ? $book['identifiers']['isbn_10'][0] : Library\Helpers::isbn13_to_10($book['identifiers']['isbn_13'][0]);
                            $bookData['isbn13']     = isset($book['identifiers']['isbn_13']) ? $book['identifiers']['isbn_13'][0] : Library\Helpers::isbn10_to_13($book['identifiers']['isbn_10'][0]);
                            $bookData['olid']       = $book['identifiers']['openlibrary'][0];
                            $bookData['image']      = isset($book['cover']) ? $book['cover']['medium'] : NULL;

                            // Get the genres
                            $bookData['subjects']   = [];
                            if(isset($book['subjects'])) {
                                foreach ($book['subjects'] as $subject) {
                                    $bookData['subjects'][] = $subject['name'];
                                }
                            }

                            //$returnBooks[] = $book;
                            $returnBooks[] = $bookData;
                            
                        }
                    }
                }
                
                //dd($returnBooks);
                //
                // Now we narrow down more, if only 1 book now, we add, otherwise show editions
                if(count($returnBooks) === 1) {
                    
                    $addBook    = $returnBooks[0];
                    
                    // first add author to get the id
                    $authorID   = !is_null($addBook['author']) ? $this->addAuthor($addBook['author'],$addBook['authorolid']) : NULL;
                    $addBook['authorid'] = $authorID;
                    
                    // Add the genres and collect the ids
                    $genreIDs   = $this->addGenres($addBook['subjects']);
                    
                    // Add the book
                    $bookid     = $this->addBook($addBook);
                    
                    // Connect the cats to the book
                    $bookCats   = $this->addBookCategories($bookid, $genreIDs);
                    
                    // Add the users bookshelf
                    $bookshelf  = new Library\BookshelfFunctions;
                    $shelfID    = $bookshelf->newBookshelf($user->id, $bookid);
                    
                    return redirect('dashboard');
                } else {
                    return view('add-book',['results' => $returnBooks]);
                }
            } else {
                return redirect('search');
            }
            
        } else {
            return redirect('search');
        }
        
    }
    
    /*
     * For showing a single book
     */
    public function show($id) {
        
        $book = Book::find($id);
        $reviews = Review::where('book_id',$id)->paginate(10);
        
        return view('books/single',['book' => $book, 'reviews' => $reviews]);
    }
}

<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;
use Nathanmac\Utilities\Parser\Facades\Parser;
use App\Bookshelf;

class BookshelfFunctions
{

    public function __construct()
    {
    }
    
    // Extract the OL author ID from a view URL
    public static function newBookshelf($userID,$bookID) {

        // First see if the user USED to have the book and update if so
        $shelf = Bookshelf::where('book_id',$bookID)->where('user_id',$userID)->first();
        if($shelf) {
            $shelf->active = 1;
            $shelf->save();
            return $shelf->id;
        } else {
            $shelf = new Bookshelf;
            $shelf->book_id = $bookID;
            $shelf->user_id = $userID;
            $shelf->status  = 'in';
            $shelf->active  = 1;
            $shelf->save();
            return $shelf->id;
        }
        
    }
    
}

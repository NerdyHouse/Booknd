<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookshelf extends Model
{
    
    protected $table = 'bookshelfs';
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function book() {
        return $this->hasOne('App\Book');
    }
}

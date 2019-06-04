<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Searchable;
    
    protected $fillable = ['title','author_id','author_name','summary','isbn10','isbn13','image','publish','olid'];
    
    public function author() {
        return $this->belongsTo('App\Author');
    }
    
    public function bookshelfs() {
        return $this->hasMany('App\Bookshelf');
    }
    
    public function users() {
        return $this->belongsToMany('App\User','bookshelfs')->withPivot('status','active','id')->wherePivot('active',1);
    }
    
    public function reviews() {
        return $this->hasMany('App\Review');
    }
    
    public function searchableAs() {
        return 'books_index';
    }
    
    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['id','title','isbn10','isbn13']);
    }
}

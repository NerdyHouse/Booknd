<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{   
    use Searchable;
    
    protected $fillable = ['name','image','summary','olid'];
    
    public function books()
    {
        return $this->hasMany('App\Book');
    }
    
    public function searchableAs() {
        return 'authors_index';
    }
    
    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['id','name']);
    }
}

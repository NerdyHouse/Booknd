<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
    
    public function friend() {
        return $this->belongsTo('App\User','friend_id');
    }
}

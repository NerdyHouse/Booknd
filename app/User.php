<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use App\Friend;

class User extends Authenticatable
{
    use Searchable;
    use Notifiable;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'fbid', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function bookshelf() {
        return $this->hasMany('App\Bookshelf');
    }
    
    public function books() {
        return $this->belongsToMany('App\Book', 'bookshelfs')->withPivot('status','active','id')->wherePivot('active',1);
    }
    
    public function myFriends() {
        return $this->hasMany('App\Friend','user_id','id')->where('status','active');
    }
    
    public function theirFriends() {
        return $this->hasMany('App\Friend','friend_id','id')->where('status','active');
    }
    
    public function friends() {
        return $this->myFriends->merge($this->theirFriends);
    }
    
    public function reviews() {
        return $this->hasMany('App\Review')->where('active',1);
    }
    
    public function roles() {
        return $this->belongsToMany('App\Role');
    }
    
    public function authorizeRoles($roles) {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'Not allowed.');
    }
    
    public function hasAnyRole($roles) {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    
    public function hasRole($role) {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
    
    public function searchableAs() {
        return 'users_index';
    }
    
    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['id','name','email']);
    }
}

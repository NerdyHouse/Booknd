<?php

namespace App\Library;

use Illuminate\Http\Request;
use App\User;
use App\Friend;

class FriendFunctions
{

    public function __construct()
    {
    }
    
    // Returns a collection of the users friends
    public static function userFriends($uid) {
        
        if($uid) {
            
            $allFriends = User::find($uid)->friends()->where('status','active');
            
            $ids = [];
            foreach ($allFriends as $friend) {
                if($uid == $friend->user_id) {
                    $ids[] = $friend->friend_id;
                } else if ($uid == $friend->friend_id) {
                    $ids[] = $friend->user_id;
                }
            }
            return User::find($ids);
        }
    }
    
    // Returns an array of the users friends ids
    public static function userFriendsIds($uid) {
        
        if($uid) {
            
            $allFriends = User::find($uid)->friends()->where('status','active');
            
            $ids = [];
            foreach ($allFriends as $friend) {
                if($uid == $friend->user_id) {
                    $ids[] = $friend->friend_id;
                } else if ($uid == $friend->friend_id) {
                    $ids[] = $friend->user_id;
                }
            }
            return $ids;
        }
    }
    
    // Returns an array of the users friends ids with status
    public static function userFriendsIdsWithStatus($uid) {
        
        if($uid) {
            
            $allFriends = Friend::where('user_id',$uid)
                            ->orWhere('friend_id',$uid)->get();
            
            $ids = [];
            foreach ($allFriends as $friend) {
                if($uid == $friend->user_id) {
                    $ids[$friend->friend_id] = $friend->status;
                } else if ($uid == $friend->friend_id) {
                    $ids[$friend->user_id] = $friend->status;
                }
            }
            return $ids;
        }
    }
    

    public static function pendingFriendRequest($userID,$bookID) {
        
    }
    
    public static function isFriend($userID,$friendID) {
        $friend = Friend::where('user_id',$userID)
                    ->where('friend_id',$friendID)
                    ->where('active',1)
                    ->orWhere('friend_id',$userID)
                    ->where('user_id',$friendID)
                    ->where('active',1)
                    ->first();
        
        if($friend) {
            return [
                'friends'   => true,
                'status'    => $friend->status
                ];
        } else {
            return [
                'friends'   => false
            ];
        }
    }
    
}

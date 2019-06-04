<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\FriendRequest;
use App\Notifications\AcceptRequest;
use App\Library\FriendFunctions;

class FriendController extends Controller
{
    
    /*
     * I want this to be fairly locked down functionality
     * So we use our auth middleware to make MOST functionality
     * only work for the authenticated user
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function sendRequest(Request $request) {
        
        // Get the current auth user
        $user   = $request->user();
        
        // Make sure the requested friend is an existing user
        $friend = false;
        if($request->has('friend')) {
            $friend = User::find($request->friend)->first();
        }
        
        if($user && $friend) {
            
            // check if there is an existing friend connection
            //$current = User::find($user->id)->friends()->where('friend_id',$request->friend)->first();
            $current    = Friend::where('user_id',$user->id)
                                  ->where('friend_id',$request->friend)
                                  ->orWhere('friend_id',$user->id)
                                  ->where('user_id',$request->friend)
                                  ->first();
            
            // If there is a pending request or already friends
            if($current) {
                
                $status = $current->status;
                
                $msg    = 'There was an error sending the friend request';
                if($status === 'pending') { $msg = 'There is already a pending friend request for this user';
                } else { $msg = 'You are already friends with this user'; }
                
                return response()->json([
                    'code'      => 0,
                    'message'   => $msg
                ]);
            
            // if not create the pending friend connection
            } else {
                
                $friend = new Friend;
                $friend->user_id = $user->id;
                $friend->requestor_id = $user->id;
                $friend->friend_id = $request->friend;
                $friend->status  = 'pending';
                $friend->active  = 1;
                $friend->save();
                
                $friendUser = User::find($request->friend);
                $friendUser->notify(new FriendRequest($user));
                
                return response()->json([
                    'code'      => 1,
                    'message'   => 'Friend request sent to '.$friendUser->name
                ]);
                
            }
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error sending the friend request'
            ]);
        }
        
    }
    
    public function acceptRequest(Request $request) {
        
        // As usual get the current auth user
        $user = $request->user();
        
        // Make sure the request exists and is actually pending
        $req = false;
        if($user && $request->has('req')) {
            $req = Friend::where('id',$request->req)
                    ->where('friend_id',$user->id)
                    ->where('status','pending')
                    ->first();
        }
        
        // If all is well, update the friend connection
        if($user && $req) {
                
                $req->status = 'active';
                $req->save();
                
                $friendUser = User::find($req->user_id);
                $friendUser->notify(new AcceptRequest($user));
                
                return response()->json([
                    'code'      => 1,
                    'message'   => 'Friend request accepted!'
                ]);
        
        // If not send an error
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error accepting the request, please try again'
            ]);
        }
    }
    
    public function deleteRequest(Request $request) {
        
        // Current user
        $user = $request->user();
        
        // Make sure the request exists and is actually pending
        $req = false;
        if($user && $request->has('req')) {
            $req = Friend::where('id',$request->req)
                    ->where('friend_id',$user->id)
                    ->where('status','pending')
                    ->first();
        }
        
        if($user && $req) {
            
            $req->delete();
            return response()->json([
                'code'      => 1,
                'message'   => 'Friend request deleted'
            ]);
            
        } else {
            return response()->json([
                'code'      => 0,
                'message'   => 'There was an error deleting the request, please try again'
            ]);
        }
    }
    
}

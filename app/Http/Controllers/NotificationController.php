<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class NotificationController extends Controller
{
    public function markRead(Request $request) {
        $user = $request->user();
        
        if($user && $request->has('notif')) {
            $notification = $user->notifications()->where('id',$request->notif)->first();
            if ($notification) {
                $notification->delete();
                return response()->json([
                    'code'      => 1
                ]);
            }
        }
    }
}

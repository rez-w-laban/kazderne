<?php

namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\Notification;
use App\Models\User;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{

    public function handleFollow(Request $request)
    {
        try {
            $user = Auth::user();
            $followed = $request->followed_id;
            if ($user->id == $followed) {
                return response()->json([
                    "status" => "failed",
                    "message" => "you can't follow yourself",
                ]);
            }
            $existing = Following::where('followed_id', $followed)
                ->where('follower_id', $user->id)
                ->first();

            if ($existing) {
                $existing->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'User unfollowed successfully',
                ]);
            }

            $follow = Following::create([
                'follower_id' => $user->id,
                'followed_id' => $followed,
            ]);

            $notification = Notification::create([
                "notification" => "followed you",
                "receiver_id" => $followed,
                "sender_id" => $user->id,

            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User followed successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when trying to follow',
            ]);
        }
    }
    public function getFollowings(Request $request)
    {
        try {
            $user = Auth::user();
            $followings = User::with('follower')->where('id', $user->id)->get();
            $count = Following::where('follower_id', $user->id)->count();
            return response()->json([
                'followings' => $followings,
                "count" => $count,
                'status' => 'success',
                'message' => 'Followings retrieved successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when retrieving followers',
            ]);
        }
    }

    public function getFollowers(Request $request)
    {

        try {
            $user = Auth::user();
            $followers = User::with('followed')->where('id', $user->id)->get();
            $count = Following::where('followed_id', $user->id)->count();
            return response()->json([
                'followers' => $followers,
                "count" => $count,
                'status' => 'success',
                'message' => 'Followers retrieved successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when retrieving followers',
            ]);
        }
    }
    
    public function getUserFollowings(Request $request,$user_id)
    {
        try {
           
            $followings = User::with('follower')->where('id', $user_id)->get();
            $count = Following::where('follower_id', $user_id)->count();
            return response()->json([
                'followings' => $followings,
                "count" => $count,
                'status' => 'success',
                'message' => 'Followings retrieved successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when retrieving followers',
            ]);
        }
    }

    public function getUserFollowers(Request $request,$user_id)
    {

        try {
           
            $followers = User::with('followed')->where('id', $user_id)->get();
            $count = Following::where('followed_id', $user_id)->count();
            return response()->json([
                'followers' => $followers,
                "count" => $count,
                'status' => 'success',
                'message' => 'Followers retrieved successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when retrieving followers',
            ]);
        }
    }
    
    public function isFollowing(Request $request,$user_id)
    {
        try{
            $user = Auth::user();
            $is_following= Following::where('followed_id',$user_id)->where('follower_id',$user->id)->exists();
            if($is_following){
               return response()->json([
                
                'status' => 'success',
                'message' => 'you follow user: '.$user_id,
            ]);
            }
            return response()->json([
                
                'status' => 'failed',
                'message' => 'you follow user: '.$user_id,
            ]);
            
            
        }catch(Exception $ex){
            return response()->json([
                
                'status' => 'error',
                'message' => "$ex",
            ]);
            
            
            
        }
        
        
        
        
    }
    
    
    
    
}

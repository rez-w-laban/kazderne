<?php

namespace App\Http\Controllers;

use App\Models\Following;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
   
    public function handleFollow(Request $request)
    {
        try {
            $user = Auth::user();
            $to_follow = $request->following_id;
            $existing = Following::where('following_id', $to_follow)
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
                'following_id' => $to_follow,
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
            $followings = Following::with('user')->where('follower_id', $user->id)->get();
            return response()->json([
                'followings' => $followings,
                'status' => 'success',
                'message' => 'Followings retrieved successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when retrieving followings',
            ]);
        }
    
    
     }



}

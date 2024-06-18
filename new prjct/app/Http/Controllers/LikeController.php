<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Like;
use App\Models\Post;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function handleLike(Request $request)
    {
        try {
            $user = Auth::user();
            if($request->activity_id){
            $liked_activity = $request->activity_id;
            $existing = Like::where("activity_id", $liked_activity)
                ->where("user_id", $user->id)
                ->first();

            $activity = Activity::findorfail($liked_activity);


            if ($existing) {

                $existing->delete();
                $activity->update(["likes_count" => $activity->likes_count - 1,]);
                return response()->json([
                    "status" => "success",
                    "message" => "Activity unliked successfully",
                ]);
            }

            $like = Like::create([
                "activity_id" => $liked_activity,
                "user_id" => $user->id,
            ]);

            $activity->update(["likes_count" => $activity->likes_count + 1,]);

            $notification = Notification::create([
                "notification" => "liked your activity",
                "sender_id" => $user->id,
                "receiver_id" => $activity->user_id,
                "activity_id" => $activity->id,
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Activity liked successfully",
                
            ]);
            }
            //post
            
            
            $liked_post = $request->post_id;
            $existing = Like::where("post_id", $liked_post)
                ->where("user_id", $user->id)
                ->first();

            $post = Post::findorfail($liked_post);


            if ($existing) {

                $existing->delete();
                $post->update(["likes_count" => $post->likes_count - 1,]);
                return response()->json([
                    "status" => "success",
                    "message" => "post unliked successfully",
                ]);
            }

            $like = Like::create([
                "post_id" => $liked_post,
                "user_id" => $user->id,
            ]);

            $post->update(["likes_count" => $post->likes_count + 1,]);
            
            if($user->id !== $post->user_id){
            $notification = Notification::create([
                "notification" => "liked your post",
                "sender_id" => $user->id,
                "receiver_id" => $post->user_id,
                "post_id" => $post->id,
            ]);
}
            return response()->json([
                "status" => "success",
                "message" => "post liked successfully",
                
            ]);
            
            
            
            
            
            
            
        } catch (Exception $ex) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred when trying to like ; error : $ex",
            ]);
        }
    }

    public function getLikeCount($activity_id)
    {

        try {
            $count = Like::where("activity_id", $activity_id)->count();

            return response()->json([
                "status" => "success",
                "messsage" => "like count for activity retrieved",
                "count" => $count,

            ]);
        } catch (Exception $ex) {

            return response()->json([
                "status" => "error",
                "message" => "An error occurred when trying to get like count ; error : $ex",
            ]);
        }
    }

    public function getUserLikedActivity()
    {
        try {
            $user = Auth::user();
            $user_liked_activities = Like::with("activity")->where("user_id", $user->id)->get();
            $count = Like::where("user_id", $user->id)->count();
            return response()->json([
                "status" => "success",
                "message" => "retrieved user liked acts ",
                "liked_activities" => $user_liked_activities,
                "count" => $count,

            ]);
        } catch (Exception $ex) {

            return response()->json([
                "status" => "error",
                "message" => "An error occurred when trying to get liked activities ; error : $ex",
            ]);
        }
    }
    
    public function isLiked($activity_id)
    {
        try{
            $user = Auth::user();
            $is_liked= Like::where('user_id',$user->id)->where('activity_id',$activity_id)->exists();
            if($is_liked){
               return response()->json([
                
                'status' => 'success',
                'message' => 'you like activity: '.$activity_id,
            ]);
            }
            return response()->json([
                
                'status' => 'failed',
                'message' => 'you dont like activity: '.$activity_id,
            ]);
            
            
        }catch(Exception $ex){
            return response()->json([
                
                'status' => 'error',
                'message' => "$ex",
            ]);
            
            
            
        }
        
        
        
        
    }
}

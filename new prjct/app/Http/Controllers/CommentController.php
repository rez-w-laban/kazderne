<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function handleComment(Request $request)
    {
        try { 
            $user = Auth::user();

            if($request->activity_id){
          
            if ($request->is_reply && $request->is_reply == 1) {
                $reply = Comment::create([
                    "content" => $request->content,
                    "is_reply" => 1,
                    "user_id" => $user->id,
                    "activity_id" => $request->activity_id,
                    "comment_id" => $request->comment_id,
                ]);

                $receiver = Comment::findOrFail($request->comment_id);
                $notification = Notification::create([
                    "notification" => "$user->name replied to you",
                    "sender_id" => $user->id,
                    "receiver_id" => $receiver->user_id,
                    "activity_id" => $request->activity_id,
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => "replied successfully",
                    "reply" => $reply,
                   
                ]);
            }

            $comment = Comment::create([
                "content" => $request->content,
                "is_reply" => 0,
                "user_id" => $user->id,
                "activity_id" => $request->activity_id,
                
            ]);
            
            $activity =Activity::findorfail($request->activity_id);
            $activity->update([
                'comments_count'=>$activity->comments_count +1 ,
                ]);

            $receiver = Activity::findOrFail($request->activity_id);
            $notification = Notification::create([
                "notification" => "commented on your activity",
                "sender_id" => $user->id,
                "receiver_id" => $receiver->user_id,
                "activity_id" => $request->activity_id,
            ]);

            return response()->json([
                "status" => "success",
                "message" => "User commented successfully",
                "comment" => $comment,
                
            ]);
            
            }
            
            
           //post
           

            if ($request->is_reply && $request->is_reply == 1) {
                $reply = Comment::create([
                    "content" => $request->content,
                    "is_reply" => 1,
                    "user_id" => $user->id,
                    "post_id" => $request->post_id,
                    "comment_id" => $request->comment_id,
                ]);

                $receiver = Comment::findOrFail($request->comment_id);
                $notification = Notification::create([
                    "notification" => "replied to your post",
                    "sender_id" => $user->id,
                    "receiver_id" => $receiver->user_id,
                    "post_id" => $request->post_id,
                ]);

                return response()->json([
                    "status" => "success",
                    "message" => "replied successfully",
                    "reply" => $reply,
                   
                ]);
            }

            $comment = Comment::create([
                "content" => $request->content,
                "is_reply" => 0,
                "user_id" => $user->id,
                "post_id" => $request->post_id,
                
            ]);
            
            $post =Post::findorfail($request->post_id);
            $post->update([
                'comments_count'=>$post->comments_count +1 ,
                ]);


            $receiver = Post::findOrFail($request->post_id);
            $notification = Notification::create([
                "notification" => "commented on your post",
                "sender_id" => $user->id,
                "receiver_id" => $receiver->user_id,
                "post_id" => $request->post_id,
            ]);

            return response()->json([
                "status" => "success",
                "message" => "User commented successfully",
                "comment" => $comment,
                
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => "error",
                "message" => "there was an error while trying to comment ; error : $ex",
            ]);
        }
    }


    public function editComment(Request $request, $comment_id)
    {
        $comment = Comment::findorfail($comment_id);
        $user = Auth::user();
        if ($user->id !== $comment->user_id) {

            return response()->json([
                "status" => "error",
                "message" => "only user can edit his comment",
            ]);
        }

        if (!$request->filled("content")) {
            return response()->json([
                "status" => "error",
                "message" => "Please fill in required fields!",
            ]);
        }
        $comment->update([
            "content" => $request->input("content",$comment->content),
        ]);


        return response()->json([
            "status" => "Success",
            "message" => "comment edited successfully",
            "comment" => $comment,
        ]);
    }


    public function deleteComment($comment_id)
    {

        try {
              $user = Auth::user();
            $comment = Comment::findorfail($comment_id);
            if( $comment->activity_id ){
            $activity = Activity::findorfail($comment->activity_id);
           
            if ($user->id !== $comment->user_id && $user->role_id !== 1 && $user->id != $activity->user_id ) {

                return response()->json([

                    "status" => "error",
                    "message" => "only owner can delete comment",


                ]);
            }
          
            $comment->delete();
              $activity->update([
                "comments_count" => $activity->comments_count - 1 ,
                ]);

          
            
            
            return response()->json([

                "status" => "success",
                "message" => " activity comment successfully deleted",


            ]);
            
}

// post

  $post = Post::findorfail($comment->post_id);
          
            if ($user->id !== $comment->user_id && $user->role_id !== 1 && $user->id != $post->user_id ) {

                return response()->json([

                    "status" => "error",
                    "message" => "only owner can delete comment",


                ]);
            }
             
            
            
            $comment->delete();
            
           
             $post->update([
                            "comments_count" => $post->comments_count - 1 ,
                            ]);
            
            return response()->json([

                "status" => "success",
                "message" => "post comment successfully deleted",


            ]);


        } catch (Exception $ex) {
            return response()->json([

                "status" => "error",
                "message" => "There was an error while trying to delete comment $ex",


            ]);
        }
    }


    public function getCommentReplies($replying_to_id)
    {
        try {
            $replies = Comment::where("comment_id", $replying_to_id)->get();
            return response()->json([
                "status" => "success",
                "message" => "retrieved replies successfully",
                "comment_replies" => $replies,

            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => "error",
                "message" => "failed to retrieve replies",
            ]);
        }
    }


    public function getComment($comment_id)
    {
        try {
            $comment = Comment::findorfail($comment_id);
            return response()->json([
                "status" => "success",
                "message" => "retrieved comment successfully",
                "comment" => $comment,

            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => "error",
                "message" => "failed to retrieve comment",
            ]);
        }
    }



    public function getUserComments()
    {
        try {

            $user = Auth::user();
            $comments = Comment::where("user_id", $user->id)->get();
            return response()->json([
                "status" => "success",
                "message" => "retrieved replies successfully",
                "user_comments" => $comments,

            ]);
        } catch (Exception $ex) {
            return response()->json([

                "status" => "error",
                "message" => "There was an error while trying to get user comments",


            ]);
        }
    }

    public function getActivityComments($activity_id)
    {
        try {
            $comments = Comment::where("activity_id", $activity_id)->where('is_reply',0)->get();
            return response()->json([
                "status" => "success",
                "message" => "retrieved activity comments successfully",
                "activity_comments" => $comments,
            ]);
        } catch (Exception $ex) {

            return response()->json([

                "status" => "error",
                "message" => "There was an error while trying to get activity comments",


            ]);
        }
    }
    
      public function getPostComments($post_id)
    {
        try {
            $comments = Comment::where("post_id", $post_id)->where('is_reply',0)->get();
            return response()->json([
                "status" => "success",
                "message" => "retrieved activity comments successfully",
                "activity_comments" => $comments,
            ]);
        } catch (Exception $ex) {

            return response()->json([

                "status" => "error",
                "message" => "There was an error while trying to get activity comments",


            ]);
        }
    }
}

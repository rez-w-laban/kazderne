<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function handleComment(Request $request)
    {
        try {
            $user = Auth::user();


            if ($request->is_reply == 1) {


                $reply = Comment::create([
                    'content' => $request->content,
                    'is_reply' => 1,
                    'user_id' => $user->id,
                    'activity_id' => $request->activity_id,
                    'comment_id' => $request->comment_id,

                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User replied successfully',
                    'reply' => $reply,
                ]);
            }
            $comment = Comment::create([
                'content' => $request->content,
                'is_reply' => 0,
                'user_id' => $user->id,
                'activity_id' => $request->activity_id,
                'comment_id' => $request->comment_id,


            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User commented successfully',
                'comment' => $comment,
            ]);
        } catch (Exception $ex) {


            return response()->json([
                'status' => 'error',
                'message' => $ex,
            ]);
        }
    }


    public function editComment(Request $request, $comment_id)
    {
        $comment = Comment::findorfail($comment_id);
        $user = Auth::user();
        if ($user->id !== $comment->user_id) {

            return response()->json([
                'status' => 'error',
                'message' => 'only user can edit his comment',
            ]);
        }

        if (!$request->filled('content')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please fill in required fields!',
            ]);
        }
        $comment->update([
            'content' => $request->input('content'),
        ]);


        return response()->json([
            'status' => 'Success',
            'message' => 'activity edited successfully',
            'comment' => $comment,
        ]);
    }


    public function deleteComment($comment_id)
    {

        try {
            $comment = Comment::findorfail($comment_id);
            $user = Auth::user();
            if ($user->id !== $comment->user_id) {

                return response()->json([

                    'status' => 'error',
                    'message' => 'only owner can delete comment',


                ]);
            }

            $comment->delete();

            return response()->json([

                'status' => 'success',
                'message' => 'comment successfully deleted',


            ]);
        } catch (Exception $ex) {
            return response()->json([

                'status' => 'error',
                'message' => 'There was an error while trying to delete comment',


            ]);
        }
    }


    public function getCommentReplies($replying_to_id)
    {
        try {
            $replies = Comment::where('comment_id', $replying_to_id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'retrieved replies successfully',
                'comment_replies' => $replies,

            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'failed to retrieve replies',
            ]);
        }
    }


    public function getComment($comment_id){
        try{
            $comment=Comment::findorfail($comment_id);
            return response()->json([
                'status' => 'success',
                'message' => 'retrieved comment successfully',
                'comment' => $comment,

            ]);
        }catch(Exception $ex){
            return response()->json([
                'status' => 'error',
                'message' => 'failed to retrieve comment',
            ]);


        }
    }



    public function getUserComments() 
    {
        try {

            $user = Auth::user();
            $comments = Comment::where('user_id', $user->id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'retrieved replies successfully',
                'user_comments' => $comments,

            ]);
        } catch (Exception $ex) {
            return response()->json([

                'status' => 'error',
                'message' => 'There was an error while trying to get user comments',


            ]);
        }
    }

    public function getActivityComments($activity_id) 
    {
        try {
            $comments = Comment::with('comment')->where('activity_id', $activity_id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'retrieved activity comments successfully',
                'activity_comments' => $comments,
            ]);
        } catch (Exception $ex) {

            return response()->json([

                'status' => 'error',
                'message' => 'There was an error while trying to get activity comments',


            ]);
        }
    }
}

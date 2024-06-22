<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Activity;
use App\Models\Comment;
use App\Models\Following;
use App\Models\Notification;
use App\Models\User;
use App\Models\Post;
use Carbon\Exceptions\Exception as ExceptionsException;
use Exception as GlobalException;
use FFI\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    
    public function addPost(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$request->description || !$request->media ) {
                
                return response()->json([
                    "status" => "error",
                    "message" => "fill all required fields",
                ]);
            }

          

                $messages = [
                    "required" => "Please select a file to upload.",
                    "mimes" => "The uploaded file is not a supported format.",
                    "max" => "The file size exceeds the maximum limit of 2 mb.",
                ];

                $validator = Validator::make(
                    $request->all(),
                    [  
                        "media" => "required|mimes:jpeg,jpg,png|max:2048",
                    ],
                    $messages
                );

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $media = $request->file("media");


                $post = Post::create([

                   
                    "description" => $request->description,
                    
                    "activity_id" => $request->activity_id,
                   
                    "user_id" => $user->id,


                ]);
                $file_name =  $file_name = uniqid("media_") . "." . $media->getClientOriginalExtension();

                $directory = "public/user/$user->id/post/$post->id";

                $path = Storage::putFileAs($directory, $media, $file_name);

                //$full_path = "C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";

                $post->update([
                    "media" => $file_name,
                ]);

               

                $activity = Activity::findorfail($request->activity_id);
                
                $followers = Following::where("followed_id", $user->id)->get();
                $data = json_decode($followers, true);
                
                //return $followers;
                foreach ($data as $follower) {
                    
                    $followerr = User::findorfail($follower['follower_id']);
                    
                    //return $followerr;
                    Notification::create([
                        
                        "notification" => "your friend " . $user->name .  " added a post ",
                        "receiver_id" => $followerr->id,
                        "sender_id"=>   $user->id,
                        "post_id" => $post->id,
                        
                    ]);
                }
                
                if( $user->id !== $activity->user_id ){
                Notification::create([
                    
                    "notification" =>  $user->name .  " added a post to your activity ",
                     "receiver_id" => $activity->user_id,
                        "sender_id"=>   $user->id,
                        "activity_id" => $activity->id,
                    
                    ]);

                }

                return response()->json([

                    "status" => "success",
                    "message" => "post added successfully",
                    "post" => $post,



                ]);
            
        } catch (Exception $ex) {


            return response()->json([
                "status" => "error",
                "message" => "an error occured while adding an post $ex ",
            ]);
        }
    }
    
    public function getActivityPosts($activity_id){
        
        try{
            
            $posts = Post::where('activity_id', $activity_id)->get();
            
              return response()->json([

                    "status" => "success",
                    "posts" => $posts,

                ]);
            
            
        }catch (Exception $ex) {


            return response()->json([
                "status" => "error",
                "message" => "an error occured while fetching posts  $ex ",
            ]);
        }
        
        
    }
    
    public function getUserPosts($user_id){
        
        try{
            
            $posts = Post::where('user_id', $user_id)->get();
            
              return response()->json([

                    "status" => "success",
                    "posts" => $posts,

                ]);
            
            
        }catch (Exception $ex) {


            return response()->json([
                "status" => "error",
                "message" => "an error occured while fetching posts  $ex ",
            ]);
        }
        
        
    }
      public function getPost($post_id){
        
        try{
            
            $post = Post::where('id', $post_id)->single();
            
              return response()->json([

                    "status" => "success",
                    "post" => $post,

                ]);
            
            
        }catch (Exception $ex) {


            return response()->json([
                "status" => "error",
                "message" => "an error occured while fetching post  $ex ",
            ]);
        }
        
        
    }
    
    
    
      public function deletePost($post_id){
          
          
          try{
              
              
              $user = Auth::user(); 
              
              $post = Post::findorfail($post_id);
              
              if($user->id !== $post->user_id && $user->role_id !== 1 ){
                  return response()->json([

                    "status" => "error",
                    "message" => "unauthorized access",

                ]);
            
                  
                  
                  
              }
              
              $post->delete();
              
               return response()->json([

                    "status" => "success",
                    "message" => "post deleted successfully",

                ]);
            
              
          }catch( Exception $ex){
              
               return response()->json([

                    "status" => "error",
                    "message" => "there was an error while trying to delete post , error : $ex",

                ]);
            
              
              
          }
          
          
      }
   
    
}

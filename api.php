<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityTypeController;
use App\Http\Controllers\ActivityPictureController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityPictureController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ChatController;
use App\Models\City;
use App\Models\Post;
use App\Models\Following;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["middleware" => "auth:api", "prefix" => "user"], function () {
    //user
    Route::post("logout", [AuthController::class, "logout"]);
    Route::get("getFollowings", [FollowController::class, "getFollowings"]);
    Route::get("getFollowers", [FollowController::class, "getFollowers"]);    
    Route::get("searchUsers", [AdminController::class, "searchUsers"]);
     Route::post("changePassword", [AuthController::class, "changePassword"]);
    
    Route::get("getUserFollowings/{user_id}", [FollowController::class, "getUserFollowings"]);
    
    Route::get("getUserFollowers/{user_id}", [FollowController::class, "getUserFollowers"]);
    
    Route::get("isFollowing/{user_id}", [FollowController::class, "isFollowing"]);
    
    Route::post("follow", [FollowController::class, "handleFollow"]);
    
    Route::get("profile", [AuthController::class, "getMyprofile"]);


    //like
    Route::post("like", [LikeController::class, "handleLike"]);
    Route::get("getLikeCount/{activity_id}", [LikeController::class, "getLikeCount"]);
    Route::get("getUserLikedActivity", [LikeController::class, "getUserLikedActivity"]);
    
    Route::get("isLiked/{activity_id}", [LikeController::class, "isLiked"]);
    //bookmark
    Route::post("bookmark", [BookmarkController::class, "handleBookmark"]);
    Route::post("isBookmarked/{activity_id}", [BookmarkController::class, "isBookmarked"]);
    Route::get("getBookmarkCount/{activity_id}", [BookmarkController::class, "getBookmarkCount"]);
    Route::get("getUserBookmarkedActivity", [BookmarkController::class, "getUserBookmarkedActivity"]);
    //rating
    Route::post("rating", [RatingController::class, "handleRating"]);
    //comment
    Route::post("comment", [CommentController::class, "handleComment"]);
    Route::post("editComment/{comment_id}", [CommentController::class, "editComment"]);
   
    Route::post("deleteComment/{comment_id}", [CommentController::class, "deleteComment"]);
    Route::get("getCommentReplies/{replying_to_id}", [CommentController::class, "getCommentReplies"]);
    Route::get("getComment/{comment_id}", [CommentController::class, "getComment"]);
    Route::get("getUserComments", [CommentController::class, "getUserComments"]);
    Route::get("getActivityComments/{activity_id}", [CommentController::class, "getActivityComments"]);
     Route::get("getPostComments/{post_id}", [CommentController::class, "getPostComments"]);

    //activity
    Route::get("getCityActivities/{city_id}", [ActivityController::class, "getCityActivities"]);
    Route::get("getUserActivities", [ActivityController::class, "getUserActivities"]);
    Route::get("searchActivities", [ActivityController::class, "searchActivities"]);
 
    Route::post("addActivity", [ActivityController::class, "addActivity"]);
    Route::post("editActivity/{activity_id}", [ActivityController::class, "editActivity"]);
    Route::post("deleteActivity/{activity_id}", [ActivityController::class, "deleteActivity"]);
    Route::post("addActivityMedia", [ActivityPictureController::class, "addActivityMedia"]);
    Route::post("addActivityMultiMedia", [ActivityPictureController::class, "addActivityMultiMedia"]);
    Route::post("addActivityMultiMedia", [ActivityPictureController::class, "addActivityMultiMedia"]);
    Route::post("deleteActivityMedia/{media_id}", [ActivityPictureController::class, "deleteActivityMedia"]);
    
    //post
     Route::post("addPost", [PostController::class, "addPost"]);
       Route::post("deletePost/{post_id}", [PostController::class, "deletePost"]);
     
    
    
    
       //notifications
           Route::get("getUserNotifications", [NotificationController::class, "getUserNotifications"]);
           Route::get("notificationsCount", [NotificationController::class, "notificationsCount"]);
       
   //user
    Route::get("getUser/{user_id}", [AdminController::class, "getUser"]);
    
    //chat
    Route::post("message", [ChatController::class, "message"]);
    Route::get("getAllChats", [ChatController::class, "getAllChats"]);
    Route::get("getChat/{receiver_id}", [ChatController::class, "getChat"]);
    Route::post("deleteMessage/{message_id}", [ChatController::class, "deleteMessage"]);
    Route::post("deleteChat/{receiver_id}", [ChatController::class, "deleteChat"]);
     


        //activityType
        Route::get("getActivityType/{activityType_id}", [ActivityTypeController::class, "getActivityType"]);

    //activityPicture 
    
    
    
    
    
    //user
     Route::post("editProfile", [AuthController::class, "editProfile"]);
    
    

    //admin group
          Route::group(["prefix" => "admin", "middleware" => "admin"], function () {
                //city
                Route::post("addCity", [CityController::class, "addCity"]);
                Route::post("deleteCity/{city_id}", [CityController::class, "deleteCity"]);
                Route::post("editCity/{city_id}", [CityController::class, "editCity"]);
               
                Route::post("addCityMedia", [CityPictureController::class, "addCityMedia"]);
        
                //comment
        
                //user
               
                Route::get("getAllUsers/", [AdminController::class, "getAllUsers"]);
                Route::post("userPrivilege/{user_id}", [AdminController::class, "userPrivilege"]);
                Route::post("deleteUser/{user_id}", [AdminController::class, "deleteUser"]);
        
                //activity_types
                Route::post("addActivityType", [ActivityTypeController::class, "addActivityType"]);
                Route::post("editActivityType/{activity_type_id}", [ActivityTypeController::class, "editActivityType"]);
            });
    
    
});
//search

Route::post("nancySearch", [ActivityController::class, "nancySearch"]);

//activity 
 Route::get("getActivity/{activity_id}", [ActivityController::class, "getActivity"]);
           Route::get("getAllActivities", [ActivityController::class, "getAllActivities"]);
           //post
           Route::get("getActivityPosts/{activity_id}", [PostController::class, "getActivityPosts"]);
            Route::get("getUserPosts/{user_id}", [PostController::class, "getUserPosts"]);
            Route::get("getPost/{post_id}", [PostController::class, "getPost"]);
            
//activity types
 Route::get("getAllActivityTypes", [ActivityTypeController::class, "getAllActivityTypes"]);



//auth
Route::post("login", [AuthController::class, "login"]);
Route::post("register", [AuthController::class, "register"]);

     
    // city
     Route::post("getCity/{city_id}", [CityController::class, "getCity"]);
        Route::get("getAllCities/", [CityController::class, "getAllCities"]);

//city media
Route::get('media/{city_id}/{filename}', function ($city_id, $filename) {
    $path = storage_path('app/public/city/' . $city_id . '/' . $filename);

    if (File::exists($path)) {
        return response()->file($path);
    } else {

        return response()->json(['error' => 'File not found'], 404);
    }
});
//city profile
Route::get('profile/{city_id}/{filename}', function ($city_id, $filename) {
    $path = storage_path('app/public/city/' . $city_id . '/profile/' . $filename);

    if (File::exists($path)) {
        return response()->file($path);
    } else {

        return response()->json(['error' => 'File not found'], 404);
    }
});
//activity media
Route::get('media/{user_id}/{activity_id}/{file_name}', function ($user_id, $activity_id, $file_name) {
    $path = storage_path('app/public/user/' . $user_id . '/activity/' . $activity_id . '/' . $file_name);

    if (File::exists($path)) {
        return response()->file($path);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});
//post
Route::get('post/{user_id}/{post_id}/{file_name}', function ($user_id, $post_id, $file_name) {
    $path = storage_path('app/public/user/' . $user_id . '/post/' . $post_id . '/' . $file_name);

    if (File::exists($path)) {
        return response()->file($path);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});

//activity profile
Route::get('profile/{user_id}/{activity_id}/{file_name}', function ($user_id, $activity_id, $file_name) {
    $path = storage_path('app/public/user/' . $user_id . '/activity/' . $activity_id . '/profile/' . $file_name);

    if (File::exists($path)) {
        return response()->file($path);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});
//user profile_picture
Route::get('profile_picture/{user_id}/{file_name}', function ($user_id, $file_name) {
    $path = storage_path('app/public/user/' . $user_id . '/profile/' . $file_name);

    if (File::exists($path)) {
        return response()->file($path);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
});

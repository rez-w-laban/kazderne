<?php

use App\Http\Controllers\ActivityController;
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
use App\Models\City;
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
    Route::post("follow", [ActivityController::class, "handleFollow"]);

    //like
    Route::post("like", [LikeController::class, "handleLike"]);
    Route::get("getLikeCount/{activity_id}", [LikeController::class, "getLikeCount"]);
    Route::get("getUserLikedActivity", [LikeController::class, "getUserLikedActivity"]);
    //bookmark
    Route::post("bookmark", [BookmarkController::class, "handleBookmark"]);
    Route::get("getBookmarkCount/{activity_id}", [BookmarkController::class, "getBookmarkCount"]);
    Route::get("getUserBookmarkedActivity", [BookmarkController::class, "getUserBookmarkedActivity"]);
    //rating
    Route::post("rating", [RatingController::class, "handleRating"]);
    //comment
    Route::post("comment", [CommentController::class, "handleComment"]);
    Route::post("editComment/{comment_id}", [CommentController::class, "editComment"]);
    Route::post("addReply/{reply_id}", [CommentController::class, "addReply"]);
    Route::delete("deleteComment/{comment_id}", [CommentController::class, "deleteComment"]);
    Route::get("getCommentReplies/{replying_to_id}", [CommentController::class, "getCommentReplies"]);
    Route::get("getComment/{comment_id}", [CommentController::class, "getComment"]);
    Route::get("getUserComments", [CommentController::class, "getUserComments"]);
    Route::get("getActivityComments/{activity_id}", [CommentController::class, "getActivityComments"]);

    //activity
    Route::get("getCityActivities/{city_id}", [ActivityController::class, "getCityActivities"]);
    Route::get("getUserActivities", [ActivityController::class, "getUserActivities"]);
    Route::get("searchActivities", [ActivityController::class, "searchActivities"]);
    Route::get("searchUsers", [AdminController::class, "searchUsers"]);



    //admin group
    Route::group(["prefix" => "admin", "middleware" => "admin"], function () {
        //city
        Route::post("addCity", [CityController::class, "addCity"]);
        Route::delete("deleteCity/{city_id}", [CityController::class, "deleteCity"]);
        Route::post("editCity/{city_id}", [CityController::class, "editCity"]);
        Route::post("getCity/{city_id}", [CityController::class, "getCity"]);
        Route::get("getAllCities/", [CityController::class, "getAllCities"]);
        Route::post("addCityMedia", [CityPictureController::class, "addCityMedia"]);



        //activity
        Route::post("addActivity", [ActivityController::class, "addActivity"]);
        Route::post("editActivity/{activity_id}", [ActivityController::class, "editActivity"]);
        Route::delete("deleteActivity/{activity_id}", [ActivityController::class, "deleteActivity"]);
        Route::post("addActivityMedia", [ActivityPictureController::class, "addActivityMedia"]);
        

        Route::get("getActivity/{activity_id}", [ActivityController::class, "getActivity"]);

        Route::get("getAllActivities", [ActivityController::class, "getAllActivities"]);
        
        //comment
        
        //user
        Route::get("getUser/{user_id}", [AdminController::class, "getUser"]);
        Route::get("getAllUsers/", [AdminController::class, "getAllUsers"]);
        Route::post("userPrivilege/{user_id}", [AdminController::class, "userPrivilege"]);
        Route::delete("deleteUser/{user_id}", [AdminController::class, "deleteUser"]);


        
    });
});
Route::post("login", [AuthController::class, "login"]);
Route::post("register", [AuthController::class, "register"]);

//city media
Route::get('media/{city_id}/{filename}', function ($city_id, $filename) {
    $path = storage_path('app/public/city/' . $city_id . '/' . $filename);
  
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
//user profile_picture
  Route::get('profile_picture/{user_id}/{file_name}', function ($user_id, $file_name) {
    $path = storage_path('app/public/user/' . $user_id . '/profile/'. $file_name);
  
    if (File::exists($path)) {
        return response()->file($path);
    } else {
        return response()->json(['error' => 'File not found'], 404);
    }
  });
  
  
  

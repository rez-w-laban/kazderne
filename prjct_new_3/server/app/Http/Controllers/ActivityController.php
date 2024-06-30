<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Following;
use App\Models\Notification;
use App\Models\User;
use Carbon\Exceptions\Exception as ExceptionsException;
use Exception as GlobalException;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function addActivity(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$request->activity_name || !$request->activity_type_id || !$request->city_id) {
                return response()->json([
                    "status" => "error",
                    "message" => "fill all required fields",
                ]);
            }

            if ($request->picture) {

                $messages = [
                    "required" => "Please select a file to upload.",
                    "mimes" => "The uploaded file is not a supported format.",
                    "max" => "The file size exceeds the maximum limit of 2 mb.",
                ];

                $validator = Validator::make(
                    $request->all(),
                    [
                        "picture" => "required|mimes:jpeg,jpg,png|max:2048",
                    ],
                    $messages
                );

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $picture = $request->file("picture");






                $activity = Activity::create([

                    "activity_name" => $request->activity_name,
                    "description" => $request->description,
                    "picture" => $request->file("picture"),
                    "price" => $request->price,
                    "contact" => $request->contact,
                    "likes_count" => 0,
                    "comments_count" => 0,
                    "rate_count" => 0,
                    "rate_sum" => 0,
                    "average_rate" => 0,
                    "location" => $request->location,
                    "activity_type_id" => $request->activity_type_id,
                    "city_id" => $request->city_id,
                    "user_id" => $user->id,


                ]);
                $file_name =  $file_name = uniqid("media_") . "." . $picture->getClientOriginalExtension();

                $directory = "public/user/$user->id/activity/$activity->id/profile";

                $path = Storage::putFileAs($directory, $picture, $file_name);

                //$full_path = "C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";

                $activity->update([
                    "picture" => $file_name,
                ]);

                return response()->json([

                    "status" => "success",
                    "message" => "Activity added successfully",
                    "activity" => $activity,
                    "picture" => $picture,


                ]);
            } else {


                $activity = Activity::create([

                    "activity_name" => $request->activity_name,
                    "description" => $request->description,
                    "price" => $request->price,
                    "contact" => $request->contact,
                    "likes_count" => 0,
                    "comments_count" => 0,
                    "rate_count" => 0,
                    "rate_sum" => 0,
                    "average_rate" => 0,
                    "location" => $request->location,
                    "activity_type_id" => $request->activity_type_id,
                    "city_id" => $request->city_id,
                    "user_id" => $user->id,


                ]);
                $followers = Following::where("followed_id", $user->id)->get();
                $data = json_decode($followers, true);
                //return $followers;
                foreach ($data as $follower) {
                    $followerr = User::findorfail($follower['follower_id']);
                    //return $followerr;
                    Notification::create([
                        "notification" => "your friend : " . $user->name .  " added a new activity ",
                        "receiver_id" => $followerr->id,
                        "activity_id" => $activity->id,
                    ]);
                }



                return response()->json([

                    "status" => "succes",
                    "message" => "Activity added successfully",
                    "activity" => $activity,



                ]);
            }
        } catch (Exception $ex) {


            return response()->json([
                "status" => "exception",
                "message" => "an exception occured while adding an activity ",
            ]);
        }
    }

    public function editActivity(Request $request, $activity_id)
    {


        try {
            $activity = Activity::findOrFail($activity_id);

            $user = Auth::user();

            if ($user->id !== $activity->user_id) {

                return response()->json([

                    "status" => "error",
                    "message" => "only owner can edit",


                ]);
            }

            // if (!$request->filled("activity_name") || !$request->filled("city_id") || !$request->filled("activity_type_id")) {
            //     return response()->json([
            //         "status" => "error",
            //         "message" => "Please fill in required fields!",
            //     ]);
            // }
            $activity->update([
                "activity_name" => $request->input("activity_name", $activity->activity_name),
                "description" => $request->input("description", $activity->description),
                "price" => $request->input("price", $activity->price),
                "content" => $request->input("contact", $activity->contact),
                "location" => $request->input("location", $activity->location),
                "picture" => $request->input("picture", $activity->picture),
                "city_id" => $request->input("city_id", $activity->city_id),
                "activity_type_id" => $request->input("activity_type_id", $activity->activity_type_id),


            ]);
            if ($request->picture) {

                $messages = [
                    "required" => "Please select a file to upload.",
                    "mimes" => "The uploaded file is not a supported format.",
                    "max" => "The file size exceeds the maximum limit of 2 mb.",
                ];

                $validator = Validator::make(
                    $request->all(),
                    [
                        "picture" => "required|mimes:jpeg,jpg,png|max:2048",
                    ],
                    $messages
                );

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $picture = $request->file("picture");

                $file_name =  $file_name = uniqid("media_") . "." . $picture->getClientOriginalExtension();

                $directory = "public/user/$user->id/activity/$activity->id/profile";

                $path = Storage::putFileAs($directory, $picture, $file_name);

                if (Storage::exists("$directory/$activity->picture")) {
                    Storage::delete("$directory/$activity->picture");
                }

                // if (File::exists("public/user/$user->id/activity/$activity->id/profile/$activity->picture")) {
                //     File::delete("public/user/$user->id/activity/$activity->id/profile/$activity->picture");
                // }


                $activity->update(["picture" => $file_name,]);
            }
            return response()->json([
                "status" => "Success",
                "message" => "activity edited successfully",
                "activity" => $activity,
            ]);
        } catch (Exception $ex) {

            return response()->json([
                "status" => "exception",
                "message" => "failed to edit",
            ]);
        }
    }

    public function deleteActivity($activity_id)
    {
        try {
            $user = Auth::user();
            $activity = Activity::findorfail($activity_id);

            if ($user->id !== $activity->user_id) {
                return response()->json([

                    "status" => "error",
                    "message" => "only owner can delete",


                ]);
            }
            $directory = "public/user/$user->id/activity/$activity->id/profile";


            if (Storage::exists("public/user/$user->id/activity/$activity->id")) {
                Storage::deleteDirectory("public/user/$user->id/activity/$activity->id");
            }
            $activity->delete();

            return response()->json([

                "status" => "success",
                "message" => "activity successfully deleted",


            ]);
        } catch (Exception $ex) {


            return response()->json([

                "status" => "exception",
                "message" => "There was an exception while trying to delete activity",


            ]);
        }
    }
    public function getActivity($activity_id)
    {
        try {
            $activity = Activity::with("activityPictures")->findorfail($activity_id);
            return response()->json([
                "activity" => $activity,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => $ex,
            ]);
        }
    }


    public function getAllActivities()
    {
        try {

            $activities = Activity::with('user')->with("activityPictures")->get();

            return response()->json([
                "status" => "success",
                "activities" => $activities,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while retrieving all activities.",
            ]);
        }
    }


    public function getUserActivities()
    {

        try {

            $user = Auth::user();
            $activities = Activity::with("activityPictures")->where("user_id", $user->id)->get();
            $count =  Activity::where("user_id", $user->id)->count();
            return response()->json([

                "status" => "success",
                "message" => "activities retrieved successfully",
                "activities" => $activities,
                "count"=>$count ,

            ]);
        } catch (Exception $ex) {


            return response()->json([

                "status" => "exception",
                "message" => "there was an exception retrieving activities",


            ]);
        }
    }


    public function getCityActivities($city_id)
    {
        try {
            $activities = Activity::with("activityPictures")->where("city_id", $city_id)->get();
            return response()->json([

                "status" => "success",
                "message" => "activities retrieved successfully",
                "activities" => $activities,

            ]);
        } catch (Exception $ex) {


            return response()->json([

                "status" => "exception",
                "message" => "there was an exception retrieving activities",


            ]);
        }
    }


    public function searchActivities(Request $request)
    {
        try {
            $search = $request->search;
            $activities = Activity::where("activity_name", "like", "%$search%")
                ->orWhere("description", "like", "%$search%")->with("city")->with("activityPictures")
                ->get();

            return response()->json([
                "status" => "success",
                "activities" => $activities,
            ]);
        } catch (Exception $ex) {


            return response()->json([

                "status" => "exception",
                "message" => "there was an exception searching activities",


            ]);
        }
    }
}

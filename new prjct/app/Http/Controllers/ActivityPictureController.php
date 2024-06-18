<?php

namespace App\Http\Controllers;

use App\Models\ActivityPicture;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActivityPictureController extends Controller
{
    public function addActivityMedia(Request $request)
    {
        try {
            $user = Auth::user();
            $activity_id = $request->activity_id;

            $messages = [
                'required' => 'Please select a file to upload.',
                'mimes' => 'The uploaded file is not a supported format.',
                'max' => 'The file size exceeds the maximum limit of 2 mb.',
            ];

            $validator = Validator::make(
                $request->all(),
                [
                    'media' => 'required|array|min:1|mimes:jpeg,jpg,png,avi,m4,mp4,mpeg|max:2048',
                ],
                $messages
            );

            // if ($validator->fails()) {
            //     return response()->json($validator->errors(), 400);
            // }


            $media = $request->file('media');
         //dd($request->all());
         
            
            $file_name = uniqid('media_') . '.' . $media->getClientOriginalExtension();
            $directory = "public/user/$user->id/activity/$activity_id";


            if (!Storage::disk('local')->exists($directory)) {
                Storage::disk('local')->makeDirectory($directory, 0755, true);
            }


            $path = Storage::putFileAs($directory, $media, $file_name);
            //$full_path="C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";

            $activity_media = ActivityPicture::create([
                'media' => $file_name,
                'activity_id' => $activity_id,
            ]);
            
           
            return response()->json([
                'status' => 'success',
                'activity_media' => $json,

            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => "$ex",
            ]);
        }
    }
    
    
    
    
    
   
    // public function deleteActivityPicture(Request $request,$activity_id,$media){
        
    //     try{
    //         $user = Auth::findorfail()
            
            
            
            
            
    //     }catch(Exception $ex){
            
            
            
    //     }
        
        
        
        
        
        
        
        
        
        
    //}
    
     
    // public function tokhbesetNancy(Request $request){
        
    // try{
    //     $acts = Activity::with('ActivityPicture')->get();
         
    //      $arr = [];
         
    //      // $data = json_decode($acts, true);
          
        
    //     foreach($acts as $activity){
    //     $j=1 ;
        
        
    //     for($i=1 ; $i <= 6;$i++){
    //         if($activity->activity_type_id == $i && $activity->city_id == $j && j<=6 ){
    //         array_push($arr,$activity);
        
    //         }
            
        
    //     }
    //     $j++;
    //     }
       
    //     $json = json_encode($arr);
        
    //     return response()->json([
    //         "status"=>"success",
    //         "message"=>"",
    //         "activity_pictures"=>$json,
    //         "arr"=>$arr,
            
    //         ]);
        
        
    // }catch(Exception $ex){
        
    //      return response()->json([
    //         "status"=>"error",
    //         "message"=>"$ex",
            
            
            
    //         ]);
    // }
       
        
        
        
    // }
    
    
    
    public function tokhbesetNancy(Request $request)
{
    try {
        $activities = Activity::with('ActivityPicture')->get();
        $filteredActivities = [];

        $j = 1; 

        foreach ($activities as $activity) {
            $added = false;
            for ($activityType = 1; $activityType <= 6; $activityType++) {
                if ($activity->activity_type_id == $activityType && $activity->city_id == $j) {
                    $filteredActivities[] = $activity;
                    $added = true;
                    break;
                }
            }
            
         
            $j++;
        }

        $json = json_encode($filteredActivities);

        return response()->json([
            "status" => "success",
            "message" => "",
            "activity_pictures" => $json,
        ]);
    } catch (Exception $ex) {
        return response()->json([
            "status" => "error",
            "message" => $ex->getMessage(),
        ]);
    }
}

    
    
    
}

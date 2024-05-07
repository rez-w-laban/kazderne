<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActivityTypeController extends Controller
{
    
    public function addActivityType(Request $request)
    {
    try {
            $user = Auth::user();
            if (!$request->name ) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'fill all required fields',
                ]);
            }

        if($request->icon){

            $messages = [
                'required' => 'Please select a file to upload.',
                'mimes' => 'The uploaded file is not a supported format.',
                'max' => 'The file size exceeds the maximum limit of 2 mb.',
            ];
        
            $validator = Validator::make($request->all(), [
                'icon' => 'required|mimes:jpeg,jpg,png|max:2048',]
                , $messages);
                
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
        
            $icon = $request->file('icon');
            
            




            $activity_type = ActivityType::create([

                'name' => $request->name,
                


            ]);
            $file_name =  $file_name = uniqid('media_') . '.' . $icon->getClientOriginalExtension();

            $directory = "public/activity_type/$activity_type->id";

            $path = Storage::putFileAs($directory, $icon, $file_name);

            $full_path="C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";
            
            $activity_type->update([
                'icon'=>$full_path,
            ]);

            return response()->json([

                "status" => 'success',
                "message" => 'Activity added successfully',
                "activity_type" => $activity_type,
               

            ]);

        }else{

            $activity_type = ActivityType::create([

                'name' => $request->name,
                


            ]);
            return response()->json([

                "status" => 'succes',
                "message" => 'Activity added successfully',
                "activity_type" => $activity_type,
                


            ]);



        }

        } catch (\Exception $ex) {


            return response()->json([
                'status' => 'exception',
                'message' => 'an exception occured while adding an activity'.$ex,
            ]);
        }

    }



public function editActivityType(Request $request, $activity_Type_id)
{


try {
    $activity_type = ActivityType::findOrFail($activity_Type_id);

       $user = Auth::user();

      if ($user->role_id !== 1) {

        return response()->json([

                    'status' => 'failed',
                    'message' => 'only admin can edit',


                ]);
            }

            if (!$request->filled('name')) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Please fill in required fields!',
                ]);
            }
            if(!$request->icon){
            $activity_type->update([
                'name' => $request->input('name'),
                

            ]);





            return response()->json([
                'status' => 'Success',
                'message' => 'activity edited successfully',
                'activity' => $activity_type,
            ]);
       
        
        }
        
        $messages = [
            'required' => 'Please select a file to upload.',
            'mimes' => 'The uploaded file is not a supported format.',
            'max' => 'The file size exceeds the maximum limit of 2 mb.',
        ];
    
        $validator = Validator::make($request->all(), [
            'icon' => 'required|mimes:jpeg,jpg,png|max:2048',]
            , $messages);
            
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $icon = $request->file('icon');


        $file_name =  $file_name = uniqid('media_') . '.' . $icon->getClientOriginalExtension();

        $directory = "public/activity_type/$activity_type->id/icon";

        $path = Storage::putFileAs($directory, $icon, $file_name);

        $full_path="C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";
                
        if (File::exists("$activity_type->icon")) {
            File::delete("$activity_type->icon");
        } 
            
        

        $activity_type->update([
            'name'=>$request->name,
            'icon'=>$full_path,
        ]);

        
        return response()->json([
            'status' => 'Success',
            'message' => 'activity edited successfully',
            'activity' => $activity_type,
        ]);
   



    } catch (\Exception $ex) {

            return response()->json([
                'status' => 'exception',
                'message' => 'failed to edit'.$ex,
                    ]);
                }
            
 }

// public function deleteActivity($activity_id){
//         try {
//         $user = Auth::user();
//             $activity = Activity::findorfail($activity_id);

//             if ($user->id !== $activity->user_id) {
//                return response()->json([

//                     'status' => 'error',
//                     'message' => 'only owner can delete',


//                 ]);
//     }

//     $activity->delete();

//     return response()->json([

//         'status' => 'success',
//         'message' => 'activity successfully deleted',


//     ]);
// } catch (Exception $ex) {


//     return response()->json([

//         'status' => 'exception',
//         'message' => 'There was an exception while trying to delete activity',


//     ]);
// }
// }
 }

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
    public function addActivityMedia(Request $request){
        try{
            $user = Auth::user();
        $activity_id = $request->activity_id; 
    
        $messages = [
            'required' => 'Please select a file to upload.',
            'mimes' => 'The uploaded file is not a supported format.',
            'max' => 'The file size exceeds the maximum limit of 2 mb.',
        ];
    
        $validator = Validator::make($request->all(), [
            'media' => 'required|mimes:jpeg,jpg,png,avi,m4,mp4,mpeg|max:10240',]
            , $messages);
            
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        
        $media = $request->file('media');
        $file_name = uniqid('media_') . '.' . $media->getClientOriginalExtension();
        $directory = "public/user/$user->id/activity/$activity_id";
    
    
        if (!Storage::disk('local')->exists($directory)) {
        Storage::disk('local')->makeDirectory($directory, 0755, true); 
        }
    
    
        $path = Storage::putFileAs($directory, $media, $file_name);
        $full_path="C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";
    
        $activity_media =ActivityPicture::create(['media'=>$full_path,
        'activity_id'=>$activity_id,                                                                                                                            
        ]);
            return response()->json([
                'status'=>'success',
                'activity_media'=>$activity_media,
    
            ]);
                }catch(Exception $ex){
                    return response()->json([
                        'status'=>'error',
                        'message'=>$ex,
                    ]);
    
                }
    
    }
}

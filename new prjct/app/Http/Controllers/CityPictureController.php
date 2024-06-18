<?php

namespace App\Http\Controllers;

use App\Models\CityPicture;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CityPictureController extends Controller
{
   
    public function addCityMedia(Request $request){
        try{
            $user = Auth::user();
        $city_id = $request->city_id; 
    
        $messages = [
            'required' => 'Please select a file to upload.',
            'mimes' => 'The uploaded file is not a supported format.',
            'max' => 'The file size exceeds the maximum limit of 2 mb.',
        ];
    
        $validator = Validator::make($request->all(), [
            'media' => 'required|mimes:jpeg,jpg,png|max:2048',]
            , $messages);
            
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        
        $media = $request->file('media');
        $file_name = uniqid('media_') . '.' . $media->getClientOriginalExtension();
        $directory = "public/city/$city_id";
    
    
        if (!Storage::disk('local')->exists($directory)) {
        Storage::disk('local')->makeDirectory($directory, 0755, true); 
        }
    
    
        $path = Storage::putFileAs($directory, $media, $file_name);
        $full_path="C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";
    
        $city_media =CityPicture::create(['media'=>$full_path,
        'city_id'=>$city_id,                                                                                                                            
        ]);
            return response()->json([
                'status'=>'success',
                'city_media'=>$city_media,
    
            ]);
                }catch(Exception $ex){
                    return response()->json([
                        'status'=>'error',
                        'message'=>$ex,]);
    
                }
    
    }
}

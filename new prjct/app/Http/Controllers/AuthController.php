<?php

namespace App\Http\Controllers;

use App\Models\User;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        try {
            if (!$request->email || !$request->password) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Both email and password are required',
                ]);
            }

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = Auth::attempt($credentials);

                return response()->json([
                    'status' => 'success',
                    'user' => $user,
                    'token' => $token,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wrong email or password',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed, try again later',
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            //     $request->validate([
            //         'name' => 'required|string|max:255',
            //         'email' => 'required|string|email|max:255',
            //         'password' => 'required|string|min:6',
            //         'profile_picture' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            //     ]);

            $messages = [
                'required' => 'Please fill all fields',
                'mimes' => 'The uploaded file is not a supported format.',
                'max' => 'The file size exceeds the maximum limit of 2 mb.',
                'min' => 'password must be at least 6 characters',
            ];

            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:6',
                    'profile_picture' => 'nullable|mimes:jpeg,jpg,png|max:2048',
                ],
                $messages
            );


            if ($validator->fails()) {
                return response()->json($validator->errors(), 500);
            }


            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already in use',
                ], 422);
            }


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
                //'profile_picture' => $request->file('profile_picture'),
            ]);

            if ($request->profile_picture) {
                $profile_picture = $request->file('profile_picture');
                $file_name = uniqid('media_') . '.' . $profile_picture->getClientOriginalExtension();
                $directory = "public/user/$user->id/profile";

                if (!Storage::disk('local')->exists($directory)) {
                    Storage::disk('local')->makeDirectory($directory, 0755, true);
                }


                $path = Storage::putFileAs($directory, $profile_picture, $file_name);
                //$full_path="C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";

                $user->update([
                    'profile_picture' => $file_name,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'User created successfully',
                    'user' => $user,
                ]);
            } else {

                return response()->json([
                    'status' => 'success',
                    'message' => 'User created successfully',
                    'user' => $user,
                ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed, try again later',
            ], 500);
        }
    }




    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Logout failed, try again later',
            ], 500);
        }
    }

    public function editProfile(Request $request)
    {


        try {
          

            $user = Auth::user();

          

            if ($request->profile_picture) {

                $messages = [
                    "required" => "Please select a file to upload.",
                    "mimes" => "The uploaded file is not a supported format.",
                    "max" => "The file size exceeds the maximum limit of 2 mb.",
                ];

                $validator = Validator::make(
                    $request->all(),
                    [
                        "profile_picture" => "required|mimes:jpeg,jpg,png|max:2048",
                    ],
                    $messages
                );

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $picture = $request->file("profile_picture");

                $file_name =  $file_name = uniqid("media_") . "." . $picture->getClientOriginalExtension();

                $directory = "public/user/$user->id/profile";

                $path = Storage::putFileAs($directory, $picture, $file_name);

                if (Storage::exists("$directory/$user->profile_picture")) {
                    Storage::delete("$directory/$user->profile_picture");
                }
                $user->update([
                                    "name" => $request->input("name", $user->name),
                                    "email" => $request->input("email", $user->email),
                                    
                                     "profile_picture" => $file_name,]);
            }else{
                
                
            $user->update([
                "name" => $request->input("name", $user->name),
                "email" => $request->input("email", $user->email),
                
                

            ]);
            }
            if($request->password){
                 $user->update([
                'password' => Hash::make($request->password),
            ]);
               
            }
            return response()->json([
                "status" => "success",
                "message" => "user edited successfully",
                "user" => $user,
            ]);
            
        } catch (Exception $ex) {

            return response()->json([
                "status" => "error",
                "message" => "failed to edit $ex",
            ]);
        }
    }
    

    public function changePassword(Request $request){
        
        try{
            $user = Auth::user();
            
            if (Hash::check($request->password, $user->password)) {
                
                if($request->new_password == $request->verify_new_password){
                    
                    $user->update([
                        
                        'password'=>Hash::make( $request->new_password) ,
                        
                        ]);
                        
                return response()->json([
                "status" => "success",
                "message" => "password changed successfully",
                ]);
                    
                    
                }else{
                    
                    
                 return response()->json([
                "status" => "error",
                "message" => "passwords dont match",
                ]);
                    
                    
                }
                
            }
                else{
                    
                    
                    
                        return response()->json([
                "status" => "error",
                "message" => "password is invalid",
                ]);
                    
                    
                    
                }
                
                
            }catch(Exception $ex){
                
                
                
            return response()->json([
                "status" => "error",
                "message" => "failed to change password $ex",
            ]);
                
                
                
            }
            
            
   
        }
        
     
    public function getMyProfile(Request $request)
    {
        try {
            $user = Auth::user();

            return response()->json([
                "status" => 'success',
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "profile_picture" => $user->profile_picture,


            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => 'error',
                "message" => "failed to return your profile ; exception : $ex",
            ]);
        }
    }
    
    


}


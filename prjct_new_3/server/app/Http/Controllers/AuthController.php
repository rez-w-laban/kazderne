<?php

namespace App\Http\Controllers;

use App\Models\User;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
                'profile_picture' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            ]);
            
      

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2 ,
                //'profile_picture' => $request->file('profile_picture'),
            ]);
            $profile_picture = $request->file('profile_picture');
            $file_name = uniqid('media_') . '.' . $profile_picture->getClientOriginalExtension();
            $directory = "public/user/$user->id/profile";
        
        
            if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory, 0755, true); 
            }
        
        
            $path = Storage::putFileAs($directory, $profile_picture, $file_name);
            $full_path="C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";

            $user->update([
                'profile_picture'=>$full_path,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user,
            ]);
        } catch (Exception $e) {

            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email already in use',
                ], 422);
            }
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function searchUsers(Request $request) 
    {
        try {
            $search = $request->search;
            $users = User::with('activity')->where('name', 'like', "%$search%")->get();

            return response()->json([
                'status' => 'success',
                'users' => $users,
            ]);
        } catch (Exception $ex) {


            return response()->json([

                'status' => 'exception',
                'message' => 'there was an exception searching users',


            ]);
        }
    }
    public function getUser($user_id) 
    {
        try {
            $user = User::with('activity')->findorfail($user_id);
            $count =User::withCount('activity')->findorfail($user_id);
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'count'=>$count,

            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'an error occured while trying to get user',

            ]);
        }
    }
   //searchActivities in activity

    public function getAllUsers() 
    {
        try {
            $users = User::with('activity')->get();

            return response()->json([
                'status' => 'success',
                'users' => $users,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving all users.',
            ]);
        }
    }

    public function deleteUser($user_id) 
    {
        try {
            $user = User::findOrFail($user_id);
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'deleted user successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while trying to delete user.',
            ]);
        }
    }

    public function userPrivilege($user_id) 
    {
        try {
            $user = User::findOrFail($user_id);

            if ($user->role_id == 1) {
                $user->role_id = 2;
                $message = 'User demoted to a normal user';
            } else {
                $user->role_id = 1;
                $message = 'User promoted to admin';
            }

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating user role.',
            ]);
        }
    }
    //crud for cities & activities in their controllers
}

<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUserNotifications()
    {
        try {
            $user = Auth::user();

            $notifications = Notification::where('receiver_id', $user->id)->get();
            

            return response()->json([
                'status' => 'success',
                "notifications" => $notifications,
            ]);
        } catch (Exception $ex) {

            return response()->json([
                'status' => 'error',
                "message" => "an error occured while trying to retreive notifications ;error : $ex",
            ]);
        }
    }
       public function notificationsCount()
    {
        try {
            $user = Auth::user();

            $count = Notification::where('receiver_id', $user->id)->count();
            

            return response()->json([
                'status' => 'success',
                "count" => $count,
            ]);
        } catch (Exception $ex) {

            return response()->json([
                'status' => 'error',
                "message" => "an error occured while trying to retreive notifications ;error : $ex",
            ]);
        }
    }
}

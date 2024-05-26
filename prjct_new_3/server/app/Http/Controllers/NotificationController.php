<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUserNotification()
    {
        try {
            $user = Auth::user();

            $notifications = Notification::where('user_id', $user->id)->get();

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
}

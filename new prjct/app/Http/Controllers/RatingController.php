<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Rating;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function handleRating(Request $request)
    {
        try {
            $user = Auth::user();
            $rated_activity = $request->activity_id;
            $existing = Rating::where('activity_id', $rated_activity)
                ->where('user_id', $user->id)
                ->first();

            if ($existing) {

                $activity = Activity::where('id', $rated_activity)->first();
                $activity->update(['rate_sum' =>  $activity->rate_sum + $request->rating - $existing->rating,]);
                $activity->update(['average_rate' => $activity->rate_sum / $activity->rate_count,]);


                $existing->update([

                    'rating' => $request->rating,
                    

                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'rating edited successfully',
                    'rating' => $existing,
                ]);
            }

            $rating = Rating::create([
                'rating' => $request->rating,
                'activity_id' => $rated_activity,
                'user_id' => $user->id,
            ]);
            $activity = Activity::where('id', $rated_activity)->first();


            $activity->update(['rate_count' => $activity->rate_count  + 1,]);


            $activity->update(['rate_sum' =>  $activity->rate_sum + $request->rating,]);


            $activity->update(['average_rate' => $activity->rate_sum / $activity->rate_count,]);
            
            



            return response()->json([
                'status' => 'success',
                'message' => 'Activity rated successfully',
                'rating' => $rating,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' =>  $ex,
            ]);
        }
    }
}

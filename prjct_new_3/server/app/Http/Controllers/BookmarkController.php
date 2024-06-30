<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function handleBookmark(Request $request)
    {
        try {
            $user = Auth::user();
            $bookmarked_activity = $request->activity_id;
            $existing = Bookmark::where('activity_id', $bookmarked_activity)
                ->where('user_id', $user->id)
                ->first();

            if ($existing) {
                $existing->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Activity unmarked successfully',
                ]);
            }

            $bookmark = Bookmark::create([
                'activity_id' => $bookmarked_activity,
                'user_id' => $user->id,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Activity bookmarked successfully',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when trying to bookmark',
            ]);
        }
    }

    public function getBookmarkCount($activity_id)
    {

        try {
            $count = Bookmark::where('activity_id', $activity_id)->count();

            return response()->json([
                'status' => 'success',
                'messsage' => 'Bookmark count for activity retrieved',
                'bookmarks_count' => $count,

            ]);
        } catch (Exception $ex) {

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when trying to get bookmarks count',
            ]);
        }
    }

    public function getUserBookmarkedActivity()
    {
        try {
            $user = Auth::user();
            $user_bookmarked_activities = Bookmark::with('activity')->where('user_id', $user->id)->get();
            $count = Bookmark::where('user_id', $user->id)->count();
            return response()->json([
                'status' => 'success',
                'message' => 'retrieved user bookmarked acts ',
                'bookmarked_activities' => $user_bookmarked_activities,
                'bookmarks_count' => $count,

            ]);
        } catch (Exception $ex) {

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred when trying to get bookmarked activities',
            ]);
        }
    }
}

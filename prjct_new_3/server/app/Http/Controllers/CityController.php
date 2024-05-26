<?php

namespace App\Http\Controllers;

use App\Models\City;
use Exception as GlobalException;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function addCity(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->role_id !== 1) {

                return response()->json([

                    'status' => 'error',
                    'message' => 'unauthorized access ',

                ]);
            }

            if (!$request->city_name) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please fill in all fields !',
                ]);
            }


            $existing = City::where('city_name', $request->city_name)->first();

            if ($existing) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'City exists',
                ]);
            }
            if ($request->picture) {


                $messages = [
                    'required' => 'Please select a file to upload.',
                    'mimes' => 'The uploaded file is not a supported format.',
                    'max' => 'The file size exceeds the maximum limit of 2 mb.',
                ];

                $validator = Validator::make(
                    $request->all(),
                    [
                        'picture' => 'required|mimes:jpeg,jpg,png|max:2048',
                    ],
                    $messages
                );

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $picture = $request->file('picture');
                $file_name = uniqid('picture_') . '.' . $picture->getClientOriginalExtension();

                $city = City::create([
                    'city_name' => $request->city_name,
                    'description' => $request->description,
                    'location' => $request->location,


                ]);

                $directory = "public/city/$city->id/profile";


                if (!Storage::disk('local')->exists($directory)) {
                    Storage::disk('local')->makeDirectory($directory, 0755, true);
                }


                $path = Storage::putFileAs($directory, $picture, $file_name);
                //$full_path = "C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";

                $city->update([
                    'picture' => $file_name,
                ]);


                return response()->json([

                    'status' => 'success',
                    'message' => 'city added successfully',
                    'city' => $city,

                ]);
            } else {





                $city = City::create([
                    'city_name' => $request->city_name,
                    'description' => $request->description,
                    'location' => $request->location,
                    'picture' => $request->picture,

                ]);

                return response()->json([

                    'status' => 'success',
                    'message' => 'city added successfully',
                    'city' => $city,

                ]);
            }
        } catch (Exception $ex) {
            return response()->json([

                'status' => 'exception',
                'message' => 'An exception occurred while adding the city',

            ]);
        }
    }

    public function editCity(Request $request, $city_id)
    {
        try {
            $user = Auth::user();
            $city = City::findorfail($city_id);

            if ($user->role_id !== 1) {
                return response()->json([

                    'status' => 'error',
                    'message' => 'unauthorized access ( only admin can edit cities )  ',

                ]);
            }


            // if (!$request->filled('city_name') || !$request->filled('location')) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Please fill in required fields!',
            //     ]);
            // }

            $city->update([
                'city_name' => $request->input('city_name', $city->city_name),
                'description' => $request->input('description', $city->description),
                'location' => $request->input('location', $city->location),

            ]);

            if ($request->picture) {


                $messages = [
                    'required' => 'Please select a file to upload.',
                    'mimes' => 'The uploaded file is not a supported format.',
                    'max' => 'The file size exceeds the maximum limit of 2 mb.',
                ];

                $validator = Validator::make(
                    $request->all(),
                    [
                        'picture' => 'required|mimes:jpeg,jpg,png|max:2048',
                    ],
                    $messages
                );

                if ($validator->fails()) {
                    return response()->json($validator->errors(), 400);
                }

                $picture = $request->file('picture');
                $file_name = uniqid('picture_') . '.' . $picture->getClientOriginalExtension();

                $directory = "public/city/$city->id/profile";

                //$full_path = "C:/xampp/htdocs/prjct_new_3/server/storage/app/$directory/$file_name";

                $path = Storage::putFileAs($directory, $picture, $file_name);


                if (Storage::exists("$directory/$city->picture")) {
                    Storage::delete("$directory/$city->picture");
                }





                $city->update([
                    'picture' => $file_name,
                ]);
            }


            return response()->json([
                'status' => 'success',
                'message' => 'successfully edited city',
                'city' => $city,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'exception',
                'message' => 'There was an exception while trying to edit city',
            ]);
        }
    }
    public function deleteCity($city_id)
    {
        try {

            $user = Auth::user();
            $city = City::findorfail($city_id);
            if ($user->role_id !== 1) {
                return response()->json([

                    'status' => 'error',
                    'message' => 'unauthorized access ( only admin can delete cities )',

                ]);
            }
            if (Storage::exists("public/city/$city->id")) {
                Storage::deleteDirectory("public/city/$city->id");
            }

            $city->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'successfully deleted city',
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'exception',
                'message' => 'There was an exception while trying to delete city',
            ]);
        }
    }
    public function getCity($city_id)
    {
        try {
            $user = Auth::user();
            $city = City::findorfail($city_id);
            if ($user->role_id !== 1) {
                return response()->json([

                    'status' => 'error',
                    'message' => 'unauthorized access ( only admin can access )',

                ]);
            }

            return response()->json([

                'status' => 'success',
                'message' => 'retrieved city successfully',
                'city' => $city,

            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'exception',
                'message' => 'There was an exception while trying to get city',
            ]);
        }
    }


    public function getAllCities()
    {
        try {

            $city = City::with("activity")->get();

            return response()->json([

                'status' => 'success',
                'message' => 'retrieved cities successfully',
                'cities' => $city,

            ]);
        } catch (Exception $ex) {

            return response()->json([

                'status' => 'error',
                'message' => 'failed to retrieve cities ',


            ]);
        }
    }
    //getCityActivities in ActivityController
}

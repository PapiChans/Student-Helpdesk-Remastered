<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\CustomUserTable;
use App\Models\UserProfile;
use App\Models\AdminProfile;
use App\Models\Office;

class ProfileController extends Controller
{
    public function backend_getUserProfile(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is logged in
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $userId = Auth::user()->user_id;

                $profile = UserProfile::where('user_id', $userId)->first();

                if ($profile) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $profile
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Profile not found.",
                    ], 404);
                }
            }
        }
        else {
            // If the User is Anonymous
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        }
    }

    public function backend_getAdminProfile(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is logged in
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $userId = Auth::user()->user_id;

                $profile = AdminProfile::where('user_id', $userId)->first();

                $office = Office::where('office_id', $profile->office_id)->first();

                if ($profile) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $profile,
                        'office_name' => $office->office_name
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Profile not found.",
                    ], 404);
                }
            }
        }
        else {
            // If the User is Anonymous
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\UserProfile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class SignUpController extends Controller
{
    public function backend_SignUp(Request $request)
    {
        // Validate incoming data
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'middle_name' => 'nullable|string|max:20',
            'gender' => 'required|in:Male,Female,Prefer not to say', // Assuming a fixed set of gender values
            'email' => 'required|email|unique:custom_user_tables,email|max:40',  // Unique email validation
            'password' => 'required|string|min:8|max:20|confirmed',  // Ensure password confirmation
            'agreement' => 'accepted',  // Agreement checkbox validation
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // Create User_Id
        $userId = (string) Str::uuid();

        // If validation passes, create the new user
        $user = CustomUserTable::create([
            'user_id' => $userId,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // Securely hash the password
            'is_admin' => false,
            'login_attempts' => 0,
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila')
        ]);

        // Get the User ID
        $userId = $user->id;

        // Create User Profile
        $userprofile = UserProfile::create([
            'profile_id' => (string) Str::uuid(),
            'user_id' => $user->user_id,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'gender' => $request->gender,
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila')
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Signup successful!',
            'user' => $user
        ], 201); // 201 Created
    }
}
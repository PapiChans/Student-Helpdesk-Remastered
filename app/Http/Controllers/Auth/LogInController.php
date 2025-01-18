<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\UserProfile;
use App\Models\AdminProfile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LogInController extends Controller
{
    public function backend_LogIn(Request $request)
    {
        $credentials = CustomUserTable::where('email', $request->email)->first();

        if ($credentials) {
            // Validate incoming data
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:40',  // Unique email validation
                'password' => 'required|string|min:8|max:20',  // Ensure password confirmation
            ]);

            // Check if the User Locked out expiration
            if ($credentials->lockout_expiration && strtotime($credentials->lockout_expiration) > time()) {
                // Get the remaining time until lockout expires
                $lockout_expiration_time = new \DateTime($credentials->lockout_expiration);
                $current_time = new \DateTime(); // current time
            
                // Calculate the difference
                $interval = $lockout_expiration_time->diff($current_time);
            
                // Get remaining minutes and seconds
                $remaining_minutes = $interval->i;  // Minutes remaining
                $remaining_seconds = $interval->s;  // Seconds remaining
            
                return response()->json([
                    'status' => 'error',
                    'message' => "Your account is locked. Please try again in $remaining_minutes minutes and $remaining_seconds seconds.",
                ], 403);
            }
            else {
                // Login Attempts Logic
                if (!Hash::check($request->password, $credentials->password)) {
    
                    // If attempts reach 3, set lockout expiration
                    if ($credentials->login_attempts >= 2) {
                        // Set lockout expiration time to 5 minutes from now
                        $credentials->lockout_expiration = now()->addMinutes(5);
                        $credentials->login_attempts = 0;
                        $credentials->update();
    
                        return response()->json([
                            'status' => 'error',
                            'message' => "Your account is locked for 5 minutes.",
                        ], 404);
                    }
                    else {
                        // Increment Login Attempt
                        $credentials->login_attempts++;
                        $credentials->update();
        
                        $remaining_attempts = 3 - $credentials->login_attempts;
                        return response()->json([
                            'status' => 'error',
                            'message' => "Incorrect Password. Attempts remaining: $remaining_attempts",
                        ], 404);
                    }
    
                }
                else {
                    // Reset login attempts if successful
                    $credentials->login_attempts = 0;
                    $credentials->lockout_expiration = null;
                    $credentials->update();

                    // Log In the User
                    Auth::login($credentials);

                    // Confirming if the User is the Admin
                    if ($credentials->is_admin == true) {
                        return response()->json([
                            'status' => 'success',
                            'admin' => true,
                        ], 200);
                    }
                    else {
                        return response()->json([
                            'status' => 'success',
                            'admin' => false,
                        ], 200);
                    }

                }
            }

        }
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'User Not Found',
            ], 404);
        }
    }
}

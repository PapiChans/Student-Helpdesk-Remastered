<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\Office;
use App\Models\Ticket;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminManagementController extends Controller
{
    // -------------------------
    // Admin Management Section
    // -------------------------

    public function backend_addAdmin(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                // Logics for Specific Validation
                $verifyEmail = CustomUserTable::where('email', $request->email)->first();
                if ($verifyEmail){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Email Address already exists.'
                    ], 409);
                }
                else {
                    // Validate incoming data
                    $validator = Validator::make($request->all(), [
                        'last_name' => 'required|string|max:20',
                        'first_name' => 'required|string|max:20',
                        'middle_name' => 'nullable|string|max:20',
                        'gender' => 'required|in:Male,Female,Prefer not to say', // Assuming a fixed set of gender values
                        'email' => 'required|unique:custom_user_tables,email|max:40',  // Unique email validation
                        'is_technician' => 'checked',  // Agreement checkbox validation
                        'office' => 'required|string|max:40',
                    ]);
                    
                    // Create User_Id
                    $userId = (string) Str::uuid();
            
                    // If validation passes, create the new user
                    $user = CustomUserTable::create([
                        'user_id' => $userId,
                        'email' => $request->email . '@sample.edu.ph',
                        'password' => Hash::make('admin@123'),  // Securely hash the password
                        'is_admin' => true,
                        'login_attempts' => 0,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
    
    
                    // Fetch the Office
                    $office = Office::where('office_id', $request->office)->first();
        
                    // Create Admin Profile
                    $userprofile = AdminProfile::create([
                        'profile_id' => (string) Str::uuid(),
                        'user_id' => $user->user_id,
                        'last_name' => $request->last_name,
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'gender' => $request->gender,
                        'office_id' => $office->office_id,  // Ensure we have the correct office_id here
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
    
    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Add Admin Successful.',
                    ], 201);
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

    public function backend_getAdmin(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $admins = AdminProfile::all();

                // Prepare an array
                $adminData = [];

                foreach ($admins as $admin) {
                    // Fetch office name using the office_id from the current admin profile
                    $office = Office::where('office_id', $admin->office_id)->first();

                    if ($office) {
                        // Store the required fields in an array
                        $adminData[] = [
                            'profile_id' => $admin->profile_id,
                            'first_name' => $admin->first_name,
                            'last_name' => $admin->last_name,
                            'middle_name' => $admin->middle_name,
                            'gender' => $admin->gender,
                            'is_technician' => $admin->is_technician,
                            'is_master_admin' => $admin->is_master_admin,
                            'office_name' => $office->office_name,
                        ];
                    }
                }

                if (count($adminData) > 0) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $adminData
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
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

    public function backend_getOneAdmin(Request $request, $profile_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $admin = AdminProfile::where('profile_id', $profile_id)->first();

                if ($admin) {   
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $admin
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                    ], 404);
                }
            }
        }
        else 
        {
            // If the User is Anonymous
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        }
    }

    public function backend_editAdmin(Request $request, $profile_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                // Get the Current Admin Data
                $admin = AdminProfile::where('profile_id', $profile_id)->first();

                // Update Admin data
                $admin->office_id = $request->input('office_id');
                $admin->is_technician = $request->input('is_technician');
                $admin->updated_at = now();
                $admin->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Edit Admin Successful.',
                ], 201);
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

    public function backend_removeAdmin(Request $request, $profile_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $adminprofile = AdminProfile::where('profile_id', $profile_id)->first();

                if ($adminprofile) {   
                    $admin = CustomUserTable::where('user_id', $adminprofile->user_id)->first();

                    // Assign the Current User
                    $user = Auth::user();
                    // Fetch the Admin Profile of User
                    $currentUser = AdminProfile::where('user_id', $user->user_id)->first();

                    if ($currentUser->is_technician == true && $currentUser->is_master_admin == false) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Unauthorized Access.",
                        ], 401);
                    }
                    else {
                        $adminprofile->delete();
                        $admin->delete();
                        return response()->json([
                            'status' => 'success',
                            'message' => "Delete Office Successful.",
                        ], 200);
                    }
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                    ], 404);
                }
            }
        }
        else 
        {
            // If the User is Anonymous
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        }
    }


    // -------------------------
    // Office Management Section
    // -------------------------
    public function backend_addOffice(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                // Validate incoming data
                $validator = Validator::make($request->all(), [
                    'office' => 'required|string|max:40',
                ]);

                // Get User
                $user = Auth::user();

                // Get the Current Admin Data
                $admin = AdminProfile::where('user_id', $user->user_id)->first();

                // Create Office
                $addOffice = Office::create([
                    'office_id' => (string) Str::uuid(),
                    'office_name' => $request->office,
                    'added_by' => $admin->first_name . ' ' . $admin->last_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Add Office Successful.',
                ], 201);
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

    public function backend_getOffice(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $offices = Office::whereNotIn('office_name', ['Master Admin', 'Technician'])->get();

                // Prepare an array
                $officeData = [];

                    foreach ($offices as $office) {
                        // Store the required fields in an array
                        $officeData[] = [
                            'office_id' => $office->office_id,
                            'office_name' => $office->office_name,
                            'added_by' => $office->added_by,
                            'date_added' => $office->created_at,
                            'last_modified' => $office->updated_at,
                        ];
                    }
                }
                if (count($officeData) > 0) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $officeData
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                    ], 404);
                }
            }
        else 
        {
            // If the User is Anonymous
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        }
    }

    public function backend_getOneOffice(Request $request, $office_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $office = Office::where('office_id', $office_id)->first();

                if ($office) {   
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $office
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                    ], 404);
                }
            }
        }
        else 
        {
            // If the User is Anonymous
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        }
    }

    public function backend_editOffice(Request $request, $office_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                // Validate incoming data
                $validator = Validator::make($request->all(), [
                    'office_name' => 'required|string|max:40',
                ]);


                // Get the Current Admin Data
                $office = Office::where('office_id', $office_id)->first();

                // Update office data
                $office->office_name = $request->input('office_name');
                $office->updated_at = now();
                $office->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Edit Office Successful.',
                ], 201);
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

    public function backend_removeOffice(Request $request, $office_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $office = Office::where('office_id', $office_id)->first();
                $ticket = Ticket::where('office_id', $office_id)->first();

                // Assign the Current User
                $user = Auth::user();
                // Fetch the Admin Profile of User
                $currentUser = AdminProfile::where('user_id', $user->user_id)->first();

                if ($currentUser->is_technician == true && $currentUser->is_master_admin == false) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Unauthorized Access.",
                    ], 401);
                }

                if ($office) {   
                    $admins = AdminProfile::where('office_id', $office_id)->first();
                    
                    if ($admins || $ticket) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "There are Admin/s or Ticket/s assigned in this office.",
                        ], 409);
                    }
                    else {
                        $office->delete();
                        return response()->json([
                            'status' => 'success',
                            'message' => "Delete Office Successful.",
                        ], 200);
                    }
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                    ], 404);
                }
            }
        }
        else 
        {
            // If the User is Anonymous
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        }
    }
}

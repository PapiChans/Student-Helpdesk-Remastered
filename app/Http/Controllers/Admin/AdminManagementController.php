<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\Office;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminManagementController extends Controller
{
    // -------------------------
    // Admin Management Section
    // -------------------------

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

                if ($office) {   
                    $admins = AdminProfile::where('office_id', $office_id)->first();
                    
                    if ($admins) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "There are Admin/s assigned in this office.",
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

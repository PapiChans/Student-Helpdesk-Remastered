<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\Office;

class AdminManagementController extends Controller
{
    public function backend_getAdmin(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is logged in
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

    public function backend_getOffice(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is logged in
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
}

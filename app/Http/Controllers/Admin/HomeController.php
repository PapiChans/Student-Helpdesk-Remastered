<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\Ticket;
use App\Models\Office;

use Carbon\Carbon;

class HomeController extends Controller
{
    public function backend_getTicketCount (Request $request) {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $userId = Auth::user();
                $admin = AdminProfile::where('user_id', $userId->user_id)->first();

                $currentMonth = Carbon::now()->format('m');
                $currentYear = Carbon::now()->year;

                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();

                $currentDate = $currentYear.'-'.$currentMonth;

                if ($admin->is_technician == true || $admin->is_master_admin == true) {
                    $pendingCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'Pending')->count();
                    $InProgressCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'In Progress')->count();
                    $resolvedCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'Resolved')->count();
                    $closedCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'Closed')->count();
                    $officeName = 'All Offices';
                }
                else {
                    $pendingCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'Pending')->where('office_id', $admin->office_id)->count();
                    $InProgressCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'In Progress')->where('office_id', $admin->office_id)->count();
                    $resolvedCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'Resolved')->where('office_id', $admin->office_id)->count();
                    $closedCount = Ticket::whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status', 'Closed')->where('office_id', $admin->office_id)->count();
                    $getOfficeName = Office::where('office_id', $admin->office_id)->first();
                    $officeName = $getOfficeName->office_name;
                }

                return response()->json([
                    'status' => 'success',
                    'message' => "Access Granted.",
                    'pending_count' => $pendingCount,
                    'in_progress_count' => $InProgressCount,
                    'resolved_count' => $resolvedCount,
                    'closed_count' => $closedCount,
                    'office_Name' => $officeName,
                ]);


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

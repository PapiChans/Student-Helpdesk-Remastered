<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\Ticket;
use App\Models\Office;
use App\Models\TicketRating;
use App\Models\Evaluation;

use Carbon\Carbon;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function backend_getReportTicketStatus(Request $request)
{
    if (Auth::check()) {
        // Check if the user is not admin
        if (!Auth::user()->is_admin) {
            return response()->json([
                'status' => 'error',
                'message' => "Unauthorized Access.",
            ], 409);
        } else {
            $userId = Auth::user()->user_id;

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // Fetch the Admin Profile
            $adminprofile = AdminProfile::where('user_id', $userId)->first();

            // Fetch the ticket counts based on their role
            if ($adminprofile->is_master_admin == true || $adminprofile->is_technician == true) {
                // For Master Admin or Technicians, fetch tickets across all offices
                $ticketCountsByOffice = Ticket::selectRaw('
                    office_id,
                    SUM(CASE WHEN status = \'Pending\' THEN 1 ELSE 0 END) as pending_count,
                    SUM(CASE WHEN status = \'In Progress\' THEN 1 ELSE 0 END) as in_progress_count,
                    SUM(CASE WHEN status = \'Resolved\' THEN 1 ELSE 0 END) as resolved_count,
                    SUM(CASE WHEN status = \'Closed\' THEN 1 ELSE 0 END) as closed_count
                ')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->groupBy('office_id')
                ->get();
            } else {
                // For other users, fetch tickets for the specific office of the user
                $ticketCountsByOffice = Ticket::selectRaw('
                    office_id,
                    SUM(CASE WHEN status = \'Pending\' THEN 1 ELSE 0 END) as pending_count,
                    SUM(CASE WHEN status = \'In Progress\' THEN 1 ELSE 0 END) as in_progress_count,
                    SUM(CASE WHEN status = \'Resolved\' THEN 1 ELSE 0 END) as resolved_count,
                    SUM(CASE WHEN status = \'Closed\' THEN 1 ELSE 0 END) as closed_count
                ')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('office_id', $adminprofile->office_id)
                ->groupBy('office_id')
                ->get();
            }

            // Prepare the data to return
            $ticketData = [];
            foreach ($ticketCountsByOffice as $ticketCount) {
                // Fetch office name using the office_id
                $office = Office::where('office_id', $ticketCount->office_id)->first();

                if ($office) {
                    // Add the office ticket counts to the array
                    $ticketData[] = [
                        'office_name' => $office->office_name,
                        'pending' => $ticketCount->pending_count,
                        'in_progress' => $ticketCount->in_progress_count,
                        'resolved' => $ticketCount->resolved_count,
                        'closed' => $ticketCount->closed_count,
                        'total' => $ticketCount->pending_count + $ticketCount->in_progress_count + $ticketCount->resolved_count + $ticketCount->closed_count,
                    ];
                }
            }

            // Return the response
            if (count($ticketData) > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => "Access Granted.",
                    'data' => $ticketData
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "No tickets found.",
                    'data' => []
                ], 200);
            }
        }
    } else {
        // If the User is not authenticated
        return response()->json([
            'status' => 'error',
            'message' => "Unauthorized Access.",
        ], 409);
    }
}


}

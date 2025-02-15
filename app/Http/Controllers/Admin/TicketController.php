<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\UserProfile;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\Office;
use App\Models\AuditTrail;

class TicketController extends Controller
{
    public function backend_getTickets(Request $request)
    {
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

                if ($admin->is_admin == true || $admin->is_technician == true) {
                    $tickets = Ticket::whereNotIn('status', ['Closed'])->get();
                }
                else {
                    $tickets = Ticket::whereNotIn('status', ['Closed'])->where('office_id', $admin->office_id)->get();
                }


                // Prepare an array
                $ticketData = [];

                foreach ($tickets as $ticket) {
                    // Fetch office name using the office_id from the current admin profile
                    $office = Office::where('office_id', $ticket->office_id)->first();

                    if ($office) {
                        // Store the required fields in an array
                        $ticketData[] = [
                            'ticket_id' => $ticket->ticket_id,
                            'user_id' => $ticket->user_id,
                            'ticket_number' => $ticket->ticket_number,
                            'affiliation' => $ticket->affiliation,
                            'priority' => $ticket->priority,
                            'status' => $ticket->status,
                            'type' => $ticket->type,
                            'resolved_date' => $ticket->resolved_date,
                            'service' => $ticket->service,
                            'office_name' => $office->office_name,
                            'date_added' => $ticket->created_at,
                        ];
                    }
                }

                if (count($ticketData) > 0) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $ticketData
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                        'data' => []
                    ], 200);
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

    // View Ticket
    // Get Ticket Info
    public function backend_getTicketInfo(Request $request, $ticket_number)
    {
        if (Auth::check()) {
            // Check if the user is not an admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $ticket = Ticket::where('ticket_number', $ticket_number)->first();

                $ticketdata = [];

                if ($ticket) {

                    $office = Office::where('office_id', $ticket->office_id)->first();
                    $user = UserProfile::where('user_id', $ticket->user_id)->first();

                    $ticketData[] = [
                        'ticket_id' => $ticket->ticket_id,
                        'affiliation' => $ticket->affiliation,
                        'created_at' => $ticket->created_at,
                        'ticket_number' => $ticket->ticket_number,
                        'priority' => $ticket->priority,
                        'status' => $ticket->status,
                        'type' => $ticket->type,
                        'office' => $office->office_name,
                        'service' => $ticket->service,
                        'resolved_date' => $ticket->resolved_date,
                        'user' => $user->last_name." ".$user->first_name,
                    ];

                    // admin Verification
                    $admin = Auth::user();
                    $adminProfile = AdminProfile::where('user_id', $admin->user_id)->first();

                    if ($adminProfile->office_id == $ticket->office_id) {
                        return response()->json([
                            'status' => 'success',
                            'message' => "Access Granted.",
                            'data' => $ticketData,
                            'verify' => 'matched',
                        ], 200);
                    }
                    else {
                        return response()->json([
                            'status' => 'error',
                            'verify' => 'unmatched',
                            'message' => "Access Denied.",
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

    public function backend_getTicketComment(Request $request, $ticket_number)
    {
        if (Auth::check()) {
            // Check if the user not an admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $user = Auth::user();
                $ticket = Ticket::where('ticket_number', $ticket_number)->first();
                $comment = TicketComment::where('ticket_id', $ticket->ticket_id)->orderBy('created_at', 'asc')->get();

                return response()->json([
                    'status' => 'success',
                    'message' => "Access Granted.",
                    'user_id' => $user->user_id,
                    'data' => $comment,
                ], 200);
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

    public function backend_getAuditTrail(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not an admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $trail = AuditTrail::where('reference', $request->ticket_number)->orderBy('created_at', 'asc')->get();

                return response()->json([
                    'status' => 'success',
                    'message' => "Access Granted.",
                    'data' => $trail,
                ], 200);
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

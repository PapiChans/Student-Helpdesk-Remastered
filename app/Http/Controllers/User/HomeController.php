<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\Ticket;
use App\Models\Office;

class HomeController extends Controller
{
    public function backend_getTickets(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is admin
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                $userId = Auth::user()->user_id;

                $tickets = Ticket::where('user_id', $userId)->get();

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

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\UserProfile;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\TicketRating;
use App\Models\Evaluation;
use App\Models\Office;
use App\Models\AuditTrail;

class TicketController extends Controller
{
    public function backend_addTicket(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is admin
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                // Fetch userID
                $user = CustomUserTable::where('user_id', Auth::user()->user_id)->first();
                $userId = $user->user_id;

                // Fetch the Office
                $office = Office::where('office_id', $request->office)->first();
                $office_id = $office->office_id; 
        
                // If validation passes, create the new user
                $ticket = Ticket::create([
                    'ticket_id' => (string) Str::uuid(),
                    'user_id' => $userId,
                    'ticket_number' => $request->ticket_number,
                    'affiliation' => $request->affiliation,
                    'office_id' => $office_id,
                    'priority' => $request->priority,
                    'status' => 'Pending',
                    'type' => $request->type,
                    'resolved_date' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'service' => $request->service,
                ]);

                // For Trail
                $reference = $request->ticket_number;
                $action = 'Created';
                $description = $request->ticket_number." ".'has been created.';
                $this->backend_addTrail($reference, $action, $description);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Add Ticket Successful.',
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
            // Check if the user is admin
            if (Auth::user()->is_admin) {
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

    // Get Ticket Info
    public function backend_getTicketInfo(Request $request, $ticket_number)
    {
        if (Auth::check()) {
            // Check if the user is an admin
            if (Auth::user()->is_admin) {
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

                    // user Verification
                    $user = Auth::user();

                    if ($user->user_id == $ticket->user_id) {
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

    public function backend_addTicketComment(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                // Get User
                $user = Auth::user();

                // Get the Ticket
                $ticket = Ticket::where('ticket_id', $request->ticket_id)->first();

                // Create Ticket Comment
                $addTicketComment = TicketComment::create([
                    'comment_id' => (string) Str::uuid(),
                    'ticket_id' => $ticket->ticket_id,
                    'user_id' => $user->user_id,
                    'comment' => $request->comment,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Add Comment Successful.',
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

    public function backend_getTicketComment(Request $request, $ticket_number)
    {
        if (Auth::check()) {
            // Check if the user is an admin
            if (Auth::user()->is_admin) {
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

    public function backend_addTicketRating(Request $request, $ticket_number)
    {
        if (Auth::check()) {
            // Check if the user is an admin
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                // Get User
                $user = Auth::user();

                // Get the Ticket
                $ticket = Ticket::where('ticket_number', $ticket_number)->first();

                // Create Ticket Rating
                $addTicketRating = TicketRating::create([
                    'rating_id' => (string) Str::uuid(),
                    'ticket_id' => $ticket->ticket_id,
                    'user_id' => $user->user_id,
                    'rating' => $request->ticket_rating,
                    'remarks' => $request->ticket_rating_remarks,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Create Ticket Evaluation
                $addTicketRating = Evaluation::create([
                    'evaluation_id' => (string) Str::uuid(),
                    'reference' => $ticket->ticket_number,
                    'user_id' => $user->user_id,
                    'status' => 'Rated',
                    'QA' => $request->eval_QA,
                    'QB' => $request->eval_QB,
                    'QC' => $request->eval_QC,
                    'QD' => $request->eval_QD,
                    'QE' => $request->eval_QE,
                    'QF' => $request->eval_QF,
                    'QG' => $request->eval_QG,
                    'QH' => $request->eval_QH,
                    'remarks' => $request->evaluation_remarks,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // For Trail
                $reference = $ticket_number;
                $action = 'Rated and Evaluated';
                $description = $ticket_number." ".'has been rated and evaluated.';
                $this->backend_addTrail($reference, $action, $description);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Add Rating Successful.',
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

    public function backend_checkTicketRatings(Request $request, $ticket_number)
    {
        if (Auth::check()) {
            // Check if the user is an admin
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {
                // Find Ticket
                $ticket = Ticket::where('ticket_number' , $ticket_number)->first();

                $evaluation = Evaluation::where('reference', $ticket_number)->first();

                $rating = TicketRating::where('ticket_id', $ticket->ticket_id)->first();

                if ($evaluation && $rating) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'found' => true,
                        'rating' => $rating,
                        'evaluation' => $evaluation,
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'found' => false,
                        'rating' => $rating,
                        'evaluation' => $evaluation,
                    ], 200);
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


    // Add Trail
    public function backend_addTrail($reference, $action, $description)
    {
        AuditTrail::create([
            'audit_id' => (string) Str::uuid(),
            'reference' => $reference,
            'action' => $action,
            'description' => $description,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function backend_getAuditTrail(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is an admin
            if (Auth::user()->is_admin) {
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

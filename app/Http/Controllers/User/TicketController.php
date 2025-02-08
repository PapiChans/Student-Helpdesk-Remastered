<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\Ticket;
use App\Models\Office;

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
}

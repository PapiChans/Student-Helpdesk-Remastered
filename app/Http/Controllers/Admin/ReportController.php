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

    public function backend_getReportTicketRating(Request $request)
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

                // Fetch the ticket ratings based on their role
                if ($adminprofile->is_master_admin == true || $adminprofile->is_technician == true) {
                    // For Master Admin or Technicians, fetch tickets across all offices
                    $ticketRatingsByOffice = TicketRating::selectRaw('
                        t.office_id,
                        SUM(CASE WHEN ticket_ratings.rating = 5 THEN 1 ELSE 0 END) as excellent_count,
                        SUM(CASE WHEN ticket_ratings.rating = 4 THEN 1 ELSE 0 END) as good_count,
                        SUM(CASE WHEN ticket_ratings.rating = 3 THEN 1 ELSE 0 END) as average_count,
                        SUM(CASE WHEN ticket_ratings.rating = 2 THEN 1 ELSE 0 END) as fair_count,
                        SUM(CASE WHEN ticket_ratings.rating = 1 THEN 1 ELSE 0 END) as poor_count
                    ')
                    ->join('tickets as t', 't.ticket_id', '=', 'ticket_ratings.ticket_id')
                    ->whereBetween('ticket_ratings.created_at', [$startOfMonth, $endOfMonth])
                    ->groupBy('t.office_id')
                    ->get();
                } else {
                    // For other users, fetch tickets for the specific office of the user
                    $ticketRatingsByOffice = TicketRating::selectRaw('
                        t.office_id,
                        SUM(CASE WHEN ticket_ratings.rating = 5 THEN 1 ELSE 0 END) as excellent_count,
                        SUM(CASE WHEN ticket_ratings.rating = 4 THEN 1 ELSE 0 END) as good_count,
                        SUM(CASE WHEN ticket_ratings.rating = 3 THEN 1 ELSE 0 END) as average_count,
                        SUM(CASE WHEN ticket_ratings.rating = 2 THEN 1 ELSE 0 END) as fair_count,
                        SUM(CASE WHEN ticket_ratings.rating = 1 THEN 1 ELSE 0 END) as poor_count
                    ')
                    ->join('tickets as t', 't.ticket_id', '=', 'ticket_ratings.ticket_id')
                    ->whereBetween('ticket_ratings.created_at', [$startOfMonth, $endOfMonth])
                    ->where('t.office_id', $adminprofile->office_id)
                    ->groupBy('t.office_id')
                    ->get();
                }

                // Prepare the data to return
                $ticketData = [];
                foreach ($ticketRatingsByOffice as $ticketRating) {
                    // Fetch office name using the office_id from the Ticket model
                    $office = Office::where('office_id', $ticketRating->office_id)->first();

                    if ($office) {
                        // Calculate total score
                        $totalRatings = ($ticketRating->excellent_count * 5) + ($ticketRating->good_count * 4) + 
                                        ($ticketRating->average_count * 3) + ($ticketRating->fair_count * 2) + 
                                        ($ticketRating->poor_count * 1);

                        $totalTickets = $ticketRating->excellent_count + $ticketRating->good_count + 
                                        $ticketRating->average_count + $ticketRating->fair_count + 
                                        $ticketRating->poor_count;

                        $averageScore = ($totalTickets > 0) ? round($totalRatings / $totalTickets, 2) : 0;

                        $overallRating = null;
                        
                        if ($averageScore == 5) {
                            $overallRating = 'Excellent';
                        }
                        else if ($averageScore >= 4) {
                            $overallRating = 'Good';
                        }
                        else if ($averageScore >= 3) {
                            $overallRating = 'Average';
                        }
                        else if ($averageScore >= 2) {
                            $overallRating = 'Fair';
                        }
                        else if ($averageScore >= 1) {
                            $overallRating = 'Poor';
                        }

                        // Add the office rating counts to the array
                        $ticketData[] = [
                            'office_name' => $office->office_name,
                            'excellent' => $ticketRating->excellent_count,
                            'good' => $ticketRating->good_count,
                            'average' => $ticketRating->average_count,
                            'fair' => $ticketRating->fair_count,
                            'poor' => $ticketRating->poor_count,
                            'score' => $averageScore,
                            'overall' => $overallRating,
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

    public function backend_getReportEvaluations(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            }

            // Get the start and end of the month
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // Fetch evaluations for this month
            $evaluations = Evaluation::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

            // Prepare the result array
            $evaluationData = [];

            // Iterate over the different questions (QA to QH)
            foreach (['QA', 'QB', 'QC', 'QD', 'QE', 'QF', 'QG', 'QH'] as $question) {
                $excellentCount = 0;
                $goodCount = 0;
                $averageCount = 0;
                $fairCount = 0;
                $poorCount = 0;
                $totalRatings = 0;
                $totalEvaluations = 0;

                foreach ($evaluations as $evaluation) {
                    // Get the rating for the current question (e.g., QA, QB, QC...)
                    $rating = $evaluation->$question;
                    if ($rating == 5) {
                        $excellentCount++;
                    } elseif ($rating == 4) {
                        $goodCount++;
                    } elseif ($rating == 3) {
                        $averageCount++;
                    } elseif ($rating == 2) {
                        $fairCount++;
                    } elseif ($rating == 1) {
                        $poorCount++;
                    }

                    // Add the rating to the total ratings for average calculation
                    if ($rating) {
                        $totalRatings += $rating;
                        $totalEvaluations++;
                    }
                }

                // Calculate the average score for this question
                $averageScore = $totalEvaluations > 0 ? $totalRatings / $totalEvaluations : 0;

                // Determine the overall rating based on the average score
                $overallRating = null;
                if ($averageScore == 5) {
                    $overallRating = 'Excellent';
                } else if ($averageScore >= 4) {
                    $overallRating = 'Good';
                } else if ($averageScore >= 3) {
                    $overallRating = 'Average';
                } else if ($averageScore >= 2) {
                    $overallRating = 'Fair';
                } else if ($averageScore >= 1) {
                    $overallRating = 'Poor';
                }

                // Add the data to the result array
                $evaluationData[] = [
                    'question' => $question,
                    'excellent' => $excellentCount,
                    'good' => $goodCount,
                    'average' => $averageCount,
                    'fair' => $fairCount,
                    'poor' => $poorCount,
                    'average_score' => $averageScore,
                    'overall' => $overallRating,
                ];
            }

            $userId = Auth::user()->user_id;

            // Fetch the Admin Profile
            $adminprofile = AdminProfile::where('user_id', $userId)->first();

            // Fetch the ticket ratings based on their role
            if ($adminprofile->is_master_admin == true || $adminprofile->is_technician == true) {
                return response()->json([
                    'status' => 'success',
                    'data' => $evaluationData,
                ]);
            }
            else {
                return response()->json([
                    'status' => 'success',
                    'data' => [],
                ]);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => "Unauthorized Access.",
        ], 409);
    }


}

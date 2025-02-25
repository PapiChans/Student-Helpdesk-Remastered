<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\KBFolder;
use App\Models\KBTopic;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

class KnowledgebaseController extends Controller
{
    public function backend_addFolder(Request $request)
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
                    'folder_name' => 'required|string|max:40',
                ]);

                // Create Office
                $folder = KBFolder::create([
                    'folder_id' => (string) Str::uuid(),
                    'folder_name' => $request->folder_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Add Folder Successful.',
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

    public function backend_getFolders(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $folders = KBFolder::all();

                }
                if (count($folders) > 0) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $folders
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                        'data' => $folders
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

    public function backend_getTopics(Request $request, $folder_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $topics = KBTopic::where('folder_id', $folder_id)->get();

                }
                if (count($topics) > 0) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $topics
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                        'data' => $topics
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

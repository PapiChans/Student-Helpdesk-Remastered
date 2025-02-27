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

                $folder = KBFolder::where('folder_id', $folder_id)->get();
                $topics = KBTopic::where('folder_id', $folder_id)->get();

                }
                if (count($topics) > 0) {
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'folder' => $folder,
                        'data' => $topics
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Data not found.",
                        'folder' => $folder,
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

    public function backend_getFolderInfo(Request $request, $folder_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $folder = KBFolder::where('folder_id', $folder_id)->first();

                return response()->json([
                    'status' => 'success',
                    'message' => "Access Granted.",
                    'data' => $folder
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

    public function backend_editFolder(Request $request, $folder_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $folder = KBFolder::where('folder_id', $folder_id)->first();

                $folder->folder_name = $request->folder_name;
                $folder->updated_at = now();
                $folder->save();

                return response()->json([
                    'status' => 'success',
                    'message' => "Edit Folder Succesfully.",
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

    public function backend_deleteFolder(Request $request, $folder_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $folder = KBFolder::where('folder_id', $folder_id)->first();
                
                // Search for Topic First
                $topics = KBTopic::where('folder_id', $folder_id)->first();
                if ($topics)
                {
                    return response()->json([
                        'status' => 'error',
                        'message' => "There are topic/s in this folder",
                    ], 409);
                }
                else {
                    $folder->delete();
                    return response()->json([
                        'status' => 'success',
                        'message' => "Delete Folder Successfully.",
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

    public function backend_addTopic(Request $request)
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
                    'topic_name' => 'required|string|max:50',
                ]);

                // Create Office
                $topic = KBTopic::create([
                    'topic_id' => (string) Str::uuid(),
                    'folder_id' => $request->folder_id,
                    'title' => $request->topic_name,
                    'content' => 'No Content Yet.',
                    'likes' => 0,
                    'dislikes' => 0,
                    'status' => "Unpublished",
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Add Topic Successful.',
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

    // Knowledgebase: Topic

    public function backend_getTopicInfo(Request $request, $topic_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $topic = KBTopic::where('topic_id', $topic_id)->first();

                return response()->json([
                    'status' => 'success',
                    'message' => "Access Granted.",
                    'data' => $topic
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

    public function backend_editTopic(Request $request, $topic_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $topic = KBTopic::where('topic_id', $topic_id)->first();

                $topic->title = $request->title;
                $topic->folder_id = $request->folder_id;
                $topic->content = $request->content;
                $topic->status = $request->status;
                $topic->updated_at = now();
                $topic->save();

                return response()->json([
                    'status' => 'success',
                    'message' => "Edit Folder Succesfully.",
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

    public function backend_deleteTopic(Request $request, $topic_id)
    {
        if (Auth::check()) {
            // Check if the user is not admin
            if (!Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $topic = KBTopic::where('topic_id', $topic_id)->first();

                $topic->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => "Delete Topic Successfully.",
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

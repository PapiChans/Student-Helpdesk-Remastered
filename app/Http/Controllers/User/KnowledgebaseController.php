<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\KBFolder;
use App\Models\KBTopic;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class KnowledgebaseController extends Controller
{
    public function backend_getFolders(Request $request)
    {
        if (Auth::check()) {
            // Check if the user is admin
            if (Auth::user()->is_admin) {
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
            // Check if the user is admin
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $folder = KBFolder::where('folder_id', $folder_id)->get();
                $topics = KBTopic::where('folder_id', $folder_id)->where('status', 'Published')->get();

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


    // Knowledgebase: Topic

    public function backend_getTopicInfo(Request $request, $topic_id)
    {
        if (Auth::check()) {
            // Check if the user is admin
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Unauthorized Access.",
                ], 409);
            } else {

                $topics = KBTopic::where('topic_id', $topic_id)->get();
                
                $topicData = [];
                
                if ($topics) {
                    foreach ($topics as $topic) {
                        $folder = KBFolder::where('folder_id', $topic->folder_id)->first();
                        
                        $topicData[] = [
                            'title' => $topic->title,
                            'content' => $topic->content,
                            'folder' => $folder->folder_name,
                        ];
                    }
    
                    return response()->json([
                        'status' => 'success',
                        'message' => "Access Granted.",
                        'data' => $topicData
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

}

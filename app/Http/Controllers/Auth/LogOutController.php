<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LogOutController extends Controller
{
    public function backend_LogOut(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Log Out Successfully.',
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\Office;

class PreLoadData extends Controller
{
    public function createMasterAdmin(Request $request) {

    $sampleid = (string) Str::uuid();
        
    $startingfields = [
        'user_id' => $sampleid,
        'email' => 'masteradmin@sample.edu.ph',
        'password' => bcrypt('admin@123'),
        'is_admin' => true,
        'login_attempts' => 0
    ];
    
    CustomUserTable::create($startingfields);

    $officeid = (string) Str::uuid();

    $sampleoffice = [
        'office_id' => $officeid,
        'office_name' => 'Master Admin',
        'added_by' => 'Juan Dela Cruz'
    ];

    Office::create($sampleoffice);

    $sampleprofile = [
        'profile_id' => (string) Str::uuid(),
        'user_id' => $sampleid,
        'last_name' => 'Cruz',
        'first_name' => 'Juan',
        'middle_name' => 'Dela',
        'gender' => 'Male',
        'office_id' => $officeid,
        'is_master_admin' => true,
        'is_technician' => true
    ];

    AdminProfile::create($sampleprofile);

        return 'Success';
    }
}

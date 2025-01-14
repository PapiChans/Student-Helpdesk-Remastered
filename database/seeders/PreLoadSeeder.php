<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\CustomUserTable;
use App\Models\AdminProfile;
use App\Models\Office;

use Carbon\Carbon;

class PreLoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sampleid = (string) Str::uuid();
        $sampleuserid = (string) Str::uuid();


        DB::table('custom_user_tables')->insert([
            [
                'user_id' => $sampleid,
                'email' => 'masteradmin@sample.edu.ph',
                'password' => bcrypt('admin@123'),
                'is_admin' => true,
                'login_attempts' => 0,
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila')
            ],
            [
                'user_id' => $sampleuserid,
                'email' => 'user123@gmail.com',
                'password' => bcrypt('user@123'),
                'is_admin' => false,
                'login_attempts' => 0,
                'created_at' => Carbon::now('Asia/Manila'),
                'updated_at' => Carbon::now('Asia/Manila')
            ]
        ]);

        $officeid = (string) Str::uuid();

        DB::table('offices')->insert([
            'office_id' => $officeid,
            'office_name' => 'Master Admin',
            'added_by' => 'Juan Dela Cruz',
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila')
        ]);

        DB::table('admin_profiles')->insert([
            'profile_id' => (string) Str::uuid(),
            'user_id' => $sampleid,
            'last_name' => 'Cruz',
            'first_name' => 'Juan',
            'middle_name' => 'Dela',
            'gender' => 'Male',
            'office_id' => $officeid,
            'is_master_admin' => true,
            'is_technician' => true,
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila')
        ]);

        DB::table('user_profiles')->insert([
            'profile_id' => (string) Str::uuid(),
            'user_id' => $sampleuserid,
            'last_name' => 'Cruz',
            'first_name' => 'Juan',
            'middle_name' => 'Dela',
            'gender' => 'Male',
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now('Asia/Manila')
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'テスト太郎',
            'user_id' => uniqid(),
            'company_id' => 1,
            'branch_office_id' => 1,
            'duty_station_id' => 1,
            'phone' => '0557553478',
            'deleted_at' => null,
            'role' => 2,
            'email' => 'test@test.com',
            'email_verified_at' => now(),
            'password' => 'password',
            'last_logined_at' => null,
            'last_checklist_id' => null,
        ]);
    }
}

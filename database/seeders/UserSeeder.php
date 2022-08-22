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
            [
                'name' => '山田太郎',
                'company_id' => 1,
                // 'branch_office_id' => 1,
                // 'duty_station_id' => 1,
                // 'phone' => '0557553478',
                // 'deleted_at' => null,
                // 'role' => 2,
                'email' => 'yamada@test.com',
                // 'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
                // 'last_logined_at' => null,
                // 'last_checklist_id' => null,
            ],
            [
                'name' => 'Admin',
                'company_id' => 1,
                // 'branch_office_id' => 1,
                // 'duty_station_id' => 1,
                // 'phone' => '0557553478',
                // 'deleted_at' => null,
                // 'role' => 2,
                'email' => 'admin@test.com',
                // 'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
                // 'last_logined_at' => null,
                // 'last_checklist_id' => null,
            ],
            [
                'name' => 'テスト太郎',
                'company_id' => 1,
                // 'branch_office_id' => 1,
                // 'duty_station_id' => 1,
                // 'phone' => '0557553478',
                // 'deleted_at' => null,
                // 'role' => 2,
                'email' => 'test@test.com',
                // 'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
                // 'last_logined_at' => null,
                // 'last_checklist_id' => null,
            ]
        ]);
    }
}

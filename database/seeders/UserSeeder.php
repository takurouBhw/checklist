<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

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
                'name' => Crypt::encryptString('開発者'),
                'company_id' => 1,
                // 'client_key' => null,
                'user_id' => "0adc3121-ab0b-4a1a-9ab6-09ee9d1bb16d",
                // 'branch_office_id' => 1,
                // 'duty_station_id' => 1,
                // 'phone' => '0557553478',
                // 'deleted_at' => null,
                // 'role' => 2,
                'email' => 'office@30s-blockhead.com',
                // 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                // 'last_logined_at' => null,
                // 'last_checklist_id' => null,
            ],
            [
                'name' =>  Crypt::encryptString('所有者'),
                // 'client_key' => "5d87d115-7ebb-4d17-adce-4ffe4b39f8c6",
                'user_id' => "5d87d115-7ebb-4d17-adce-4ffe4b39f8c6",
                'company_id' => 1,
                // 'branch_office_id' => 1,
                // 'duty_station_id' => 1,
                // 'phone' => '0557553478',
                // 'deleted_at' => null,
                // 'role' => 2,
                'email' => 'admin@test.com',
                // 'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                // 'last_logined_at' => null,
                // 'last_checklist_id' => null,
            ],
            [
                'name' => 'テスト太郎',
                // 'client_key' => "5d87d115-7ebb-4d17-adce-4ffe4b39f8c7",
                'user_id' => "5d87d115-7ebb-4d17-adce-4ffe4b39f8c7",
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

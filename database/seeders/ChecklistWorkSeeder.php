<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChecklistWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checklist_works')->insert([
            [
                'checklist_id' => 1,
                'capmpany_id' => 1,
                'branch_office_id' => 1,
                'user_id' => '1',
                'title' => '作業タイトル',
                'category1_id' => 1,
                'category2_id' => 1,
                'category3_id' => 1,
                'year' => 2022,
                'month' => 12,
                'user_id' => (string)time() + (3 * 24 * 60 * 60),
            ],
        ]);
    }
}

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
        $check_items = [
            [
            "id"=>1,
            "no" => 1,
            "title" => "TITLE1",
            "headline" => '見出し1',
            "input" => 0
            ],
            [
                "id" => 2,
                "no" => 2,
                "title" => "TITLE2",
                "headline" => "見出し2",
                "input" => 0,
            ],
            [
                "id" => 3,
                "no" => 3,
                "title" => "TITLE3",
                "headline" => "見出し3",
                "input" => 0
            ]
        ];
        $participants = [
            "0adc3121-ab0b-4a1a-9ab6-09ee9d1bb16d" => [
                "user_name" => "開発者",
                "started_at" => 1234567890,
                "finished_at" => 0,
                "checkeds_time" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0
                ],
                "checkeds" => [
                    "1" => 1,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0
                ],
                "inputs" => [
                    "2" => "開発者メモ",
                ],
            ],
            "5d87d115-7ebb-4d17-adce-4ffe4b39f8c6" => [
                "user_name" => "管理者",
                "started_at" => 0,
                "finished_at" => 0,
                "checkeds_time" => [
                    "1" => 0,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0
                ],
                "checkeds" => [
                    "1" => 1,
                    "2" => 0,
                    "3" => 0,
                    "4" => 0,
                    "5" => 0,
                    "6" => 0,
                    "7" => 0
                ],
                "inputs" => [
                    "2" => "管理者メモ",
                ],
            ]
        ];
        DB::table('checklist_works')->insert([
            [
                    'user_id' => 1,
                    'category1_id' => 1,
                    'category2_id' => 1,
                    // 'client_id' => '5d87d115-7ebb-4d17-adce-4ffe4b39f8c5',
                    'year' => 2023,
                    'month' => 12,
                    'title' => 'ハイツA101号室',
                    "opened_at" => '2001-12-6 00:00:00',
                    "colsed_at" => '2025-12-6 23:59:59',
                    "check_items" => json_encode($check_items, true),
                    'participants' => json_encode($participants, true),
            ],
        ]);
    }
}

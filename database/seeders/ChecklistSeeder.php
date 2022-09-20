<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checklists')->insert([
            [
                'category1_id' => 1,
                'category2_id' => 1,
                'client_key' => '5d87d115-7ebb-4d17-adce-4ffe4b39f8c5',
                'user_id' => '5d87d115-7ebb-4d17-adce-4ffe4b39f8c5',
                'title' => 'ハイツA101号室',
                'check_items' => '[{"key": "5d87d115-7ebb-4d17-adce-4ffe4b39f8c5","checklist_works_id": "項目タイトル1","val": 0, "memo": "テキスト","check_time": 1612345688},{"key": "CLIENT_ID","checklist_works_id": "項目タイトル2","val": "0", "memo": "テキスト","check_time": 1612345688}]',
                'participants' => '{"5d87d115-7ebb-4d17-adce-4ffe4b39f8c5":{"user_name":"ホゲ太郎","started_at":0,"finished_at":0}}',
                'completion_date' => '2022-9:20',
            ],
            [
                'category1_id' => 2,
                'category2_id' => 2,
                'client_key' => '5d87d115-7ebb-4d17-adce-4ffe4b39f8c6',
                'user_id' => '5d87d115-7ebb-4d17-adce-4ffe4b39f8c6',
                'title' => 'ハイツA101号室',
                'check_items' => '[{"key": "5d87d115-7ebb-4d17-adce-4ffe4b39f8c6","checklist_works_id": "項目タイトル","val": 1, "memo": "テキスト","check_time": "1612345688"}]',
                'participants' => '{"5d87d115-7ebb-4d17-adce-4ffe4b39f8c5":{"user_name":"ホゲ太郎","started_at":0,"finished_at":0}}',
                // 'check_item' => '{"no": "項目No","title": "項目タイトル","input": "テキスト入力の有無","headline": "見出しか？","started_at": "開始ボダン押し","finished_at": "全項目終了時間","participants": [1,2]}',
                'completion_date' => '2022-9:20',
            ]
        ]);
    }
}

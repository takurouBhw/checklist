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
                'check_items' => '[{"key": "5d87d115-7ebb-4d17-adce-4ffe4b39f8c5","id": 1, "no": 1 , "checklist_works_id": "項目タイトル1","val": 1, "memo": "テキスト1","check_time": 1612345688},{"key": "5d87d115-7ebb-4d17-adce-4ffe4b39f8c5", "id": 1, "no": 2,  "checklist_works_id": "項目タイトル2","val": "0", "memo": "テキスト2","check_time": 1612345688}]',
                'participants' => '{"5d87d115-7ebb-4d17-adce-4ffe4b39f8c":{"user_name":"ホゲ太郎","started_at":1234567890,"finished_at":0,  "checkeds_time":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0}, "checkeds":{"1":1,"2":1,"3":1,"4":1,"5":0,"6":0,"7":1},"inputs":{"1":"name"}},"user_id2":{"user_name":"TEST2","started_at":1234567890,"finished_at":0, "checkeds_time":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0}, "checkeds":{"1":1,"2":1,"3":1,"4":1,"5":0,"6":0,"7":1},"inputs":{"2":"name"}}}
                ',
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
                'completion_date' => '2022-9:20',
            ]
        ]);
    }
}

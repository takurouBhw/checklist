<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $max_num = 150;
        $check_items = [

        ];

        for($i = 1; $i <= $max_num; $i++) {
            $item = [
                "id"=> (string)$i,
                "no" => (string)$i,
                "title" => "TITLE" . $i,
                "headline" => '見出し' . $i,
                "input" => 0
            ];
            array_push($check_items, $item);
        }
        $category1_id = $this->faker->numberBetween(1, 150);
        $category2_id = $this->faker->numberBetween(1, 150);
        return [
            'category1_id' => $category1_id,
            'category2_id' => $category2_id,
            'client_id' => '5d87d115-7ebb-4d17-adce-4ffe4b39f8c5',
            'user_id' => '5d87d115-7ebb-4d17-adce-4ffe4b39f8c5',
            'title' => 'チェックリスト' . 'カテゴリ' . $category1_id . ' : カテゴリ' . $category2_id,
            "opened_at" => '2001-12-6 00:00:00',
            "colsed_at" => '2025-10-6 23:59:59',
            'deadline_at' => '2025-9-30 23:59:59',
            'check_items' => json_encode($check_items, true),
            // 'category_id' => 1,
            // 'user_id' => '1',
            // 'priority' => 1,
            // 'title' => $this->faker->title(),
            // 'drafted_at' => $this->faker->dateTime() ,
            // 'opened_at' => $this->faker->dateTime(),
            // 'colsed_at' => $this->faker->dateTime(),
            // 'progress' => $this->faker->latitude(0, 100),
            // 'locked_at' => $this->faker->dateTime(),
            // 'sort_num' => 0,
        ];
    }
}

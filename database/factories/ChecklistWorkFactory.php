<?php

namespace Database\Factories;

use Carbon\Carbon;
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
                "checklist_title" => $this->faker->title() . $i,
                "headline" => '見出し' . $i,
                "input" => 0
            ];
            array_push($check_items, $item);
        }
        $category1_id = $this->faker->numberBetween(1, 150);
        $category2_id = $this->faker->numberBetween(1, 150);
        // $date = new (Carbon(1696639444)->
        return [
            'category1_id' => $category1_id,
            'category2_id' => $category2_id,
            'client_id' => 1,
            'user_id' => 1,
            'year' => 2023,
            'month' => 12,
            'checklist_title' => 'チェックリスト' . 'カテゴリ' . $category1_id . ' : カテゴリ' . $category2_id,
            "opened_at" => $this->faker->dateTimeThisDecade('now'),
            "colsed_at" => $this->faker->dateTimeThisDecade(1696639442),
            'deadline_at' => $this->faker->dateTimeThisDecade(1696639442),
            'check_items' => json_encode($check_items, true),
        ];
    }
}

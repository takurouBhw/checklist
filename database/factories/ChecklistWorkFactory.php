<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

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
                "title" => $this->faker->title() . $i,
                "headline" => $this->faker->numberBetween(0, 1),
                "input" => $this->faker->numberBetween(0, 1),
                "edited_at" => $this->faker->dateTimeThisDecade(),
            ];
            $check_items["{$i}"] = $item;
        }

        $category1_id = $this->faker->numberBetween(1, 150);
        $category2_id = $this->faker->numberBetween(1, 150);
        $id = $this->faker->numberBetween(1, $max_num);
        $json_file_path = "public/works/{$id}_checkitem.dat";
        Storage::put($json_file_path, json_encode($check_items));
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

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class Category2Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $max_num = 150;
        $category_id = $this->faker->numberBetween(1, $max_num);
        return [
            'category1_id' => $category_id,
            'category2_name' => '親カテゴリ' . $category_id . ': ' . $this->faker->company,
        ];
    }
}

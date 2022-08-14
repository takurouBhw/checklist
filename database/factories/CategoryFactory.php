<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'テスト' . random_int(1, 10) . 'カテゴリ',
            'sort_num' => random_int(1, 5),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Category1Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'テスト' . random_int(1, 10) . 'カテゴリ1',
            'sort_num' => 0,
        ];
    }
}

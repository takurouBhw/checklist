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
            'category1_name' => 'カテゴリ１: ' . $this->faker->title(),
            'sort_num' => 0,
        ];
    }
}

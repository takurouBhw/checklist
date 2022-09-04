<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Category2Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category_id = $this->faker->numberBetween(1, 3);
        return [
            'category1_id' => $category_id,
            'name' => $this->faker->company(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Category3Factory extends Factory
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
            'cotegory1_id' => $category_id,
            'cotegory2_id' => $category_id,
            'name' => $this->faker->company(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => 1,
            'user_id' => '1',
            'priority' => 1,
            'title' => $this->faker->title(),
            'drafted_at' => $this->faker->dateTime() ,
            'opened_at' => $this->faker->dateTime(),
            'colsed_at' => $this->faker->dateTime(),
            'progress' => $this->faker->latitude(0, 100),
            'locked_at' => $this->faker->dateTime(),
            'sort_num' => 0,
        ];
    }
}

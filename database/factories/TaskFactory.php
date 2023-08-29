<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween(1, 3);
        return [
            'title' => 'user_id ' . $user_id . ':' . $this->faker->title(),
            'memo' =>  $this->faker->sentence(),
            'user_id' => $user_id,
            'is_done' => random_int(0, 1),
        ];
    }
}

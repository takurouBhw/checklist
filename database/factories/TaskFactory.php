<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    static int $sort_no = 0;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween(1, 3);
        return [
            'task_title' => $this->faker->title(),
            'memo' =>  $this->faker->sentence(),
            'user_id' => $user_id,
            'is_done' => random_int(0, 1),
            'sort_no' => TaskFactory::$sort_no++,
            'todo_id' => random_int(1, 3),
        ];
    }
}

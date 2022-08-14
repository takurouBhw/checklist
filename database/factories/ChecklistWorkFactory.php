<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistWorkFactory extends Factory
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
            'checklist_id' => 1,
            'user_id' => '1',
            'title' => $this->faker->title(),
            'started_at' => '2022-08-15 08:07:01',
            'ended_at' => '2022-09-15 08:07:01',
        ];
    }
}

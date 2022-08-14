<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistTodoWorkFactory extends Factory
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
            'headline' => 0,
            'attention' => 0,
            'check_item' => $this->faker->text(),
            'checked' => 1,
            'memo' => $this->faker->text(),
            'second' => time(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistTodoFactory extends Factory
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
            'headline' => 0,
            'attention' => 0,
            'check_item' => $this->faker->text(),
            'locked_at' => null,
            'sort_num' => 0,
        ];
    }
}

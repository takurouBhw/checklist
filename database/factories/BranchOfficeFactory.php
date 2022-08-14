<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BranchOfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'name' => 'テスト' . random_int(1, 10) . '支社',
            'postal_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'representative' => $this->faker->name(),
            'responsible' => $this->faker->name(),
            'url' => $this->faker->url(),
        ];
    }
}

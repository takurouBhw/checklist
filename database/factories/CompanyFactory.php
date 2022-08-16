<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_key' => '1',
            'name' => $this->faker->company(),
            'postal_code' => '133-4566',
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'representative' => $this->faker->name(),
            'responsible' => $this->faker->name(),
            'url' => $this->faker->url(),
        ];
    }
}
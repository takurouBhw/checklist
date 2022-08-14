<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DutyStationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->faker->randomNumber(1),
            'branch_office_id' => random_int(1, 10),
            'name' => 'テスト' . random_int(1, 10) . '部署',
            'postal_code' => $this->faker->postcode,
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'representative' => $this->faker->name(),
            'responsible' => $this->faker->name(),
            'url' => $this->faker->url(),
        ];
    }
}

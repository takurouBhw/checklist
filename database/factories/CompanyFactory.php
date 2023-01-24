<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PhpParser\Node\Stmt\Break_;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween(1, 3);
        $participant_id = 0;

        for(;;) {
            $participant_id =  $this->faker->numberBetween(1, 3);
            if($participant_id !== $user_id) break;
        }

        return [
            // 'client_key' => '1',
            'name' => 'user_id ' . $user_id . ':' . $this->faker->company(),
            'user_id' => $user_id,
            'input' => $this->faker->title(),
            'headline' => $this->faker->title(),
            'no' => $this->faker->numberBetween(1, 10),
            'participant_id' => $participant_id,
            // 'postal_code' => '133-4566',
            // 'address' => $this->faker->address(),
            // 'email' => $this->faker->email(),
            // 'phone' => $this->faker->phoneNumber(),
            // 'representative' => $this->faker->name(),
            // 'responsible' => $this->faker->name(),
            // 'url' => $this->faker->url(),
            'is_done' => random_int(0, 1),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'provider' => $this->faker->randomElement(['google', 'facebook', 'github']),
            'provider_id' => $this->faker->uuid(),
        ];
    }
}

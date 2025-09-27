<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StartupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->randomElement(config('wilayas'))->id,
            'website' => $this->faker->url(),
        ];
    }
}

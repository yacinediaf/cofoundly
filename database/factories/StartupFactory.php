<?php

namespace Database\Factories;

use App\Enums\StartupStage;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StartupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'owner_id' => User::factory(),
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->randomElement(collect(config('wilayas'))->pluck('id')),
            'website' => $this->faker->url(),
            'personal_startup' => true,
            'industry_id' => Industry::find(rand(1, 21))->id,
            'stage' => $this->faker->randomElement(StartupStage::values()),
        ];
    }
}

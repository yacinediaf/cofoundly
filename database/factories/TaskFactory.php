<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => 1,
            'title' => $this->faker->sentence(nbWords:3),
            'description' => $this->faker->sentence(),
            'assigned_to' => 1,
            'assigned_at' => now(),
            'delivery_date' => now()->addWeek(),
        ];
    }

    public function inProgress()
    {
        return $this->state(function (array $attributes) {
            return ['status' => TaskStatus::INPROGRESS];
        });
    }

    public function done()
    {
        return $this->state(function (array $attributes) {
            return ['status' => TaskStatus::DONE];
        });
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'type' => $this->faker->randomElement(['Matser', 'Normal']),
            'status' => $this->faker->randomElement(['to dispatch', 'to validate', 'open', 'completed']),
            'parent_id' => $this->faker->randomDigit(),
        ];
    }
}

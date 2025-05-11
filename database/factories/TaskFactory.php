<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
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
    public function definition(): array
    {
        $scheduled_at = fake()->dateTimeBetween('now', '+1 week');
        $due_at = fake()->dateTimeBetween($scheduled_at, '+2 weeks');

        return [
            'workspace_id' => Workspace::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['todo', 'in_progress', 'done']),
            'scheduled_at' => $scheduled_at,
            'due_at' => $due_at,
            'assigned_to' => User::factory(),
            'created_by' => User::factory(),
        ];
    }
} 
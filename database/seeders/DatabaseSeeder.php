<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Task;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 users with specific names and emails
        $users = User::factory(5)
            ->sequence(
                ['name' => 'user1', 'email' => 'user1@gmail.com'],
                ['name' => 'user2', 'email' => 'user2@gmail.com'],
                ['name' => 'user3', 'email' => 'user3@gmail.com'],
                ['name' => 'user4', 'email' => 'user4@gmail.com'],
                ['name' => 'user5', 'email' => 'user5@gmail.com'],
            )
            ->create();

        // For each user, create workspaces and related data
        foreach ($users as $user) {
            $workspaces = Workspace::factory(3)
                ->create(['created_by' => $user->id])
                ->each(function (Workspace $workspace) use ($user, $users) {
                    // Add the creator as a member with owner role
                    Member::factory()->create([
                        'workspace_id' => $workspace->id,
                        'user_id' => $user->id,
                        'role' => 'owner',
                    ]);

                    // Add some other members (excluding the owner)
                    $otherUsers = $users->where('id', '!=', $user->id)->random(2);
                    foreach ($otherUsers as $otherUser) {
                        Member::factory()->create([
                            'workspace_id' => $workspace->id,
                            'user_id' => $otherUser->id,
                            'role' => fake()->randomElement(['admin', 'member']),
                        ]);
                    }

                    // Add some tasks
                    Task::factory(5)->create([
                        'workspace_id' => $workspace->id,
                        'created_by' => $user->id,
                        'assigned_to' => $users->random()->id,
                    ]);
                });
        }
    }
}
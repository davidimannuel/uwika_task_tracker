<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workspace;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Workspace::factory()->count(5))
            ->create();

        // create 5 user with sequence suffix 
        // user1, user2, user3, user4, user5
        // each user has 5 workspaces
        User::factory(5)
            ->sequence(
                ['name' => 'user1', 'email' => 'user1@gmail.com'],
                ['name' => 'user2', 'email' => 'user2@gmail.com'],
                ['name' => 'user3', 'email' => 'user3@gmail.com'],
                ['name' => 'user4', 'email' => 'user4@gmail.com'],
                ['name' => 'user5', 'email' => 'user5@gmail.com'],
            )
            ->has(Workspace::factory()->count(15))
            ->create();
        
    }
}

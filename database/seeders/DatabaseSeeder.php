<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => 'admin',
            ]
        );
        Task::factory(10)->create(
            [
                'user_id' => $user->id
            ]
        );
    }
}

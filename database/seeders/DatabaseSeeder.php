<?php

namespace Database\Seeders;

use App\Models\Household;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $this->call(HouseholdSeeder::class);
        $this->call(TaskSeeder::class);

        // $household = Household::factory(1)->create();

        // $users = User::factory(2)
        //     ->create([
        //         'password' => 'password',
        //         // 'household_id' => 1,
        //         // 'household_id' => $household->first()->id
        //     ]);

        //     $t

        // $tasks = Task::factory()
        //     ->for($household)
        //     ->create();

        // Add a task to each household.
        // $users->map(function ($user) {
        //     var_dump('mapping user');

        //     // $user->household->tasks()->create([
        //     //     'name' => fake()->sentence(),
        //     //     'completion_interval' => 86400, // Day in seconds
        //     //     'task_history_id' => TaskHistory::factory()->create()->id(),
        //     // ]);
        // });
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Household;
use Illuminate\Database\Seeder;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HouseholdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();

        Household::factory(1)
            ->hasAttached($users)
            ->create();
    }
}

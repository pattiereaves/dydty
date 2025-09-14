<?php

namespace Database\Seeders;

use App\Models\Household;
use App\Models\User;
use Illuminate\Database\Seeder;

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

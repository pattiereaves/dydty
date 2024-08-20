<?php

namespace Database\Seeders;

use App\Models\Household;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(HouseholdSeeder::class);

        $household = Household::first();

        Task::factory(3)->hasAttached($household)->create();
    }
}

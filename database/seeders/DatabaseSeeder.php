<?php

namespace Database\Seeders;

use App\Models\Outlet;
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
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Outlet 1',
            'password' => 'password',
            'outlet_id' => 1,
            'username' => 'outletMarket1',
            'age' => 24,
        ]);

        Outlet::factory()->create([
            'name' => 'Outlet Marketing 1',
        ]);
    }
}

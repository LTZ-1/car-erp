<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles
        $this->call(RoleSeeder::class);

        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $salesRole = \App\Models\Role::where('name', 'sales')->first();

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@carerp.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
        ]);

        \App\Models\User::create([
            'name' => 'Sales User',
            'email' => 'sales@carerp.com',
            'password' => bcrypt('password'),
            'role_id' => $salesRole->id,
        ]);
    }
}

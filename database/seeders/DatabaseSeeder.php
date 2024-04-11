<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
// use App\Models\Customer;
// use App\Models\Log;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'Owner',
        ]);
        User::create([
            'role_id' => 1,
            'username' => 'admin',
            'password' => bcrypt('admin'),
        ]);
        User::create([
            'role_id' => 2,
            'username' => 'hamzia',
            'password' => bcrypt('hamzia'),
        ]);
        User::create([
            'role_id' => 2,
            'username' => 'yunus',
            'password' => bcrypt('yunus'),
        ]);
        // Customer::factory(200)->create();
        // Log::factory(200)->create();
        
    }
}

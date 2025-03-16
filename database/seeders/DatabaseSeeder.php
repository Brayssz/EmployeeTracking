<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('departments')->insert([
            ['name' => 'HR', 'status' => 'active'],
            ['name' => 'Finance', 'status' => 'active'],
            ['name' => 'IT', 'status' => 'active'],
            ['name' => 'Marketing', 'status' => 'active'],
            ['name' => 'Sales', 'status' => 'active'],
        ]);
        User::factory()->create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'position' => 'Admin',
            'department_id' => 1,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'position' => 'Employee',
            'department_id' => 2,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test User 3',
            'email' => 'test3@example.com',
            'position' => 'Employee',
            'department_id' => 3,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test User 4',
            'email' => 'test4@example.com',
            'position' => 'Employee',
            'department_id' => 4,
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Test User 5',
            'email' => 'test5@example.com',
            'position' => 'Employee',
            'department_id' => 5,
            'password' => bcrypt('password'),
        ]);
    }
}

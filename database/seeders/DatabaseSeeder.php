<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Ahmad Syaifuddin',
            'email' => 'admin@dinsflow.com',
            'password' => bcrypt('elabsolute10'),
            'role' => 'dins'
        ]);

        User::create([
            'name' => 'Viewer 1',
            'email' => 'viewer@dinsflow.com',
            'password' => bcrypt('test1234'),
            'role' => 'viewer'
        ]);
    }
}

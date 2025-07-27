<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Ahmad Syaifuddin', 
                'email' => 'admin@gmail.com', 
                'password' => Hash::make('elabsolute10'), 
                'role' => 'dins',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Viewer 1', 
                'email' => 'test@gmail.com', 
                'password' => Hash::make('test1234'), 
                'role' => 'viewer',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
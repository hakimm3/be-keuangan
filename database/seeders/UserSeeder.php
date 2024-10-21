<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin    
        \App\Models\User::create([
            'name' => 'Trisa Abdul Hakim',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create();
    }
}

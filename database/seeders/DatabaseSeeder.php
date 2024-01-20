<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'name' => 'Admin'
        ]);

        $this->call(RolesSeeder::class);
    }
}

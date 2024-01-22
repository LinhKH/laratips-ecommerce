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
        User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'name' => 'Admin'
        ]);
        User::factory()->create([
            'email' => 'editor@editor.com',
            'password' => bcrypt('password'),
            'name' => 'Editor'
        ]);

        $this->call(RolesSeeder::class);
    }
}

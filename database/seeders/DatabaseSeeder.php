<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Regular test user
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // DAL entries
        $this->call(DalEntriesSeeder::class);
    }
}


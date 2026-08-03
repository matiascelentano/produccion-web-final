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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test',
            'last_name' => 'User',
            'birth_date' => '1990-01-01',
            'username' => 'test.user',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Client',
            'last_name' => 'User',
            'birth_date' => '1995-05-05',
            'username' => 'client.user',
            'email' => 'cliente@example.com',
            'role' => 'cliente',
        ]);
        // Seed brands, categories and products (in this order)
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}

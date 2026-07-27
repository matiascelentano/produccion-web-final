<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Palancas arcade',
            'Joysticks',
            'Botones',
            'Fightpads y controladores',
            'PCBs y adaptadores',
            'Accesorios',
        ];

        foreach ($categories as $name) {
            $slug = Str::slug($name);

            if (! Category::where('slug', $slug)->exists()) {
                Category::factory()->create([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => null,
                ]);
            }
        }
    }
}

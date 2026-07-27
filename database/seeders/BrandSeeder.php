<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Sanwa',
            'Seimitsu',
            'Hori',
            'Crown',
            'Brook',
            'Mayflash',
            'Varmilo',
            "Jasen's Customs",
        ];

        foreach ($brands as $name) {
            $slug = Str::slug($name);

            if (! Brand::where('slug', $slug)->exists()) {
                Brand::factory()->create([
                    'name' => $name,
                    'slug' => $slug,
                ]);
            }
        }
    }
}

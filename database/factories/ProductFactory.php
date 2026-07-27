<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(4, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 15, 250),
            'stock' => fake()->numberBetween(5, 100),
            'image' => 'https://via.placeholder.com/640x480?text=' . urlencode($name),
            'active' => true,
            'brand_id' => Brand::inRandomOrder()->value('id') ?? Brand::factory(),
        ];
    }
}

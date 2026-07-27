<?php

namespace Database\Factories;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    protected array $imagePaths = [
        'images/arcade-stick.jpg',
        'images/gl-lever.jpg',
        'images/haute42-t16.jpg',
        'images/pw-leverless.jpg',
        'images/Qanba-Obsidian-2.png',
        'images/sanwa-buttons.jpg',
        'images/sanwa-red.jpg',
        'images/user.jpg',
        'images/victrix-pro-ko.png',
    ];

    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'path' => $this->faker->randomElement($this->imagePaths),
            'order' => fake()->numberBetween(0, 4),
            'is_primary' => false,
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sanwa JLF-TP-8YT Joystick',
                'description' => 'Joystick Sanwa popular, usado en muchas palancas arcade.',
                'price' => 49.99,
                'stock' => 25,
                'brand' => 'sanwa',
                'image' => 'images/sanwa-red.jpg',
                'categories' => ['joysticks', 'palancas-arcade'],
            ],
            [
                'name' => 'Sanwa OBSF-30 Button (Clear)',
                'description' => 'Botón Sanwa de 30mm tipo snap-in, con tapa transparente.',
                'price' => 3.5,
                'stock' => 200,
                'brand' => 'sanwa',
                'image' => 'images/sanwa-buttons.jpg',
                'categories' => ['botones'],
            ],
            [
                'name' => 'Seimitsu LS-32-01 Joystick',
                'description' => 'Joystick Seimitsu de alta precisión.',
                'price' => 45.0,
                'stock' => 20,
                'brand' => 'seimitsu',
                'image' => 'images/gl-lever.jpg',
                'categories' => ['joysticks'],
            ],
            [
                'name' => 'Hori Real Arcade Pro 4 Kai (Fightstick)',
                'description' => 'Fightstick Hori con licencia, diseñado para uso en consolas.',
                'price' => 199.99,
                'stock' => 10,
                'brand' => 'hori',
                'image' => 'images/victrix-pro-ko.png',
                'categories' => ['fightpads-y-controladores', 'palancas-arcade'],
            ],
            [
                'name' => 'Brook Universal Fighting Board',
                'description' => 'PCB adaptador y placa compatible con múltiples consolas.',
                'price' => 59.99,
                'stock' => 30,
                'brand' => 'brook',
                'image' => 'images/haute42-t16.jpg',
                'categories' => ['pcbs-y-adaptadores'],
            ],
            [
                'name' => 'Mayflash F300 Arcade Stick',
                'description' => 'Arcade stick económico de Mayflash.',
                'price' => 74.99,
                'stock' => 15,
                'brand' => 'mayflash',
                'image' => 'images/arcade-stick.jpg',
                'categories' => ['palancas-arcade'],
            ],
            [
                'name' => "Jasen's Customs Neutrik Mod",
                'description' => 'Mod Neutrik y accesorio de Jasen\'s Customs.',
                'price' => 12.0,
                'stock' => 50,
                'brand' => 'jasen-s-customs',
                'image' => 'images/pw-leverless.jpg',
                'categories' => ['accesorios'],
            ],
            [
                'name' => 'Varmilo Mechanical Keyboard',
                'description' => 'Teclado mecánico premium, ideal para configuraciones de PC.',
                'price' => 129.99,
                'stock' => 5,
                'brand' => 'varmilo',
                'image' => 'images/user.jpg',
                'categories' => ['accesorios'],
            ],
        ];

        foreach ($products as $p) {
            $slug = Str::slug($p['name']);
            $brand = Brand::where('slug', $p['brand'])->first();

            if (! Product::where('slug', $slug)->exists()) {
                $product = Product::factory()->create([
                    'name' => $p['name'],
                    'slug' => $slug,
                    'description' => $p['description'],
                    'price' => $p['price'],
                    'stock' => $p['stock'],
                    'image' => $p['image'],
                    'active' => true,
                    'brand_id' => $brand ? $brand->id : null,
                ]);

                $categoryIds = Category::whereIn('slug', $p['categories'])->pluck('id')->toArray();
                if (! empty($categoryIds)) {
                    $product->categories()->syncWithoutDetaching($categoryIds);
                }

                ProductImage::factory()->state(["product_id" => $product->id, 'path' => $p['image'], 'order' => 0, 'is_primary' => true])->create();
                ProductImage::factory()->count(2)->state(["product_id" => $product->id, 'is_primary' => false])->create();
            }
        }
    }
}

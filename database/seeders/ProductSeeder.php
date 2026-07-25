<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
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
                'categories' => ['joysticks', 'palancas-arcade'],
            ],
            [
                'name' => 'Sanwa OBSF-30 Button (Clear)',
                'description' => 'Botón Sanwa de 30mm tipo snap-in, con tapa transparente.',
                'price' => 3.5,
                'stock' => 200,
                'brand' => 'sanwa',
                'categories' => ['botones'],
            ],
            [
                'name' => 'Seimitsu LS-32-01 Joystick',
                'description' => 'Joystick Seimitsu de alta precisión.',
                'price' => 45.0,
                'stock' => 20,
                'brand' => 'seimitsu',
                'categories' => ['joysticks'],
            ],
            [
                'name' => 'Hori Real Arcade Pro 4 Kai (Fightstick)',
                'description' => 'Fightstick Hori con licencia, diseñado para uso en consolas.',
                'price' => 199.99,
                'stock' => 10,
                'brand' => 'hori',
                'categories' => ['fightpads-y-controladores', 'palancas-arcade'],
            ],
            [
                'name' => 'Brook Universal Fighting Board',
                'description' => 'PCB adaptador y placa compatible con múltiples consolas.',
                'price' => 59.99,
                'stock' => 30,
                'brand' => 'brook',
                'categories' => ['pcbs-y-adaptadores'],
            ],
            [
                'name' => 'Mayflash F300 Arcade Stick',
                'description' => 'Arcade stick económico de Mayflash.',
                'price' => 74.99,
                'stock' => 15,
                'brand' => 'mayflash',
                'categories' => ['palancas-arcade'],
            ],
            [
                'name' => "Jasen's Customs Neutrik Mod",
                'description' => 'Mod Neutrik y accesorio de Jasen\'s Customs.',
                'price' => 12.0,
                'stock' => 50,
                'brand' => 'jasen-s-customs',
                'categories' => ['accesorios'],
            ],
            [
                'name' => 'Varmilo Mechanical Keyboard',
                'description' => 'Teclado mecánico premium, ideal para configuraciones de PC.',
                'price' => 129.99,
                'stock' => 5,
                'brand' => 'varmilo',
                'categories' => ['accesorios'],
            ],
        ];

        foreach ($products as $p) {
            $slug = Str::slug($p['name']);
            $brand = Brand::where('slug', $p['brand'])->first();

            $product = Product::firstOrCreate([
                'slug' => $slug,
            ], [
                'name' => $p['name'],
                'description' => $p['description'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'image' => null,
                'active' => true,
                'brand_id' => $brand ? $brand->id : null,
            ]);

            // Attach categories by slug if they exist
            $categorySlugs = $p['categories'];
            $categoryIds = Category::whereIn('slug', $categorySlugs)->pluck('id')->toArray();
            if (!empty($categoryIds)) {
                $product->categories()->syncWithoutDetaching($categoryIds);
            }
        }
    }
}

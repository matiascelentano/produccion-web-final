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
    public function run(): void
    {
        $this->seedCuratedProducts();
        $this->seedGeneratedProducts(targetTotal: 48);
    }

    /**
     * Los 24 productos con nombres reales, cargados a mano.
     */
    private function seedCuratedProducts(): void
    {
        $products = [
            // (mismo array de 24 productos que ya armamos en el paso anterior)
            ['name' => 'Sanwa JLF-TP-8YT Joystick', 'description' => 'Joystick Sanwa popular, usado en muchas palancas arcade.', 'price' => 49.99, 'stock' => 25, 'brand' => 'sanwa', 'image' => 'images/sanwa-red.jpg', 'categories' => ['joysticks', 'palancas-arcade']],
            ['name' => 'Sanwa OBSF-30 Button (Clear)', 'description' => 'Botón Sanwa de 30mm tipo snap-in, con tapa transparente.', 'price' => 3.5, 'stock' => 200, 'brand' => 'sanwa', 'image' => 'images/sanwa-buttons.jpg', 'categories' => ['botones']],
            ['name' => 'Seimitsu LS-32-01 Joystick', 'description' => 'Joystick Seimitsu de alta precisión.', 'price' => 45.0, 'stock' => 20, 'brand' => 'seimitsu', 'image' => 'images/gl-lever.jpg', 'categories' => ['joysticks']],
            ['name' => 'Hori Real Arcade Pro 4 Kai (Fightstick)', 'description' => 'Fightstick Hori con licencia, diseñado para uso en consolas.', 'price' => 199.99, 'stock' => 10, 'brand' => 'hori', 'image' => 'images/victrix-pro-ko.png', 'categories' => ['fightpads-y-controladores', 'palancas-arcade']],
            ['name' => 'Brook Universal Fighting Board', 'description' => 'PCB adaptador y placa compatible con múltiples consolas.', 'price' => 59.99, 'stock' => 30, 'brand' => 'brook', 'image' => 'images/haute42-t16.jpg', 'categories' => ['pcbs-y-adaptadores']],
            ['name' => 'Mayflash F300 Arcade Stick', 'description' => 'Arcade stick económico de Mayflash.', 'price' => 74.99, 'stock' => 15, 'brand' => 'mayflash', 'image' => 'images/arcade-stick.jpg', 'categories' => ['palancas-arcade']],
            ['name' => "Jasen's Customs Neutrik Mod", 'description' => 'Mod Neutrik y accesorio de Jasen\'s Customs.', 'price' => 12.0, 'stock' => 50, 'brand' => 'jasen-s-customs', 'image' => 'images/pw-leverless.jpg', 'categories' => ['accesorios']],
            ['name' => 'Varmilo Mechanical Keyboard', 'description' => 'Teclado mecánico premium, ideal para configuraciones de PC.', 'price' => 129.99, 'stock' => 5, 'brand' => 'varmilo', 'image' => 'images/user.jpg', 'categories' => ['accesorios']],
            ['name' => 'Sanwa JLF-TP-8Y Joystick (Balltop negro)', 'description' => 'Variante clásica del joystick Sanwa, palanca suave de 4/8 direcciones.', 'price' => 47.99, 'stock' => 18, 'brand' => 'sanwa', 'image' => 'images/sanwa-red.jpg', 'categories' => ['joysticks', 'palancas-arcade']],
            ['name' => 'Sanwa OBSF-24 Button (Rojo)', 'description' => 'Botón Sanwa de 24mm, ideal para layouts compactos.', 'price' => 3.0, 'stock' => 250, 'brand' => 'sanwa', 'image' => 'images/sanwa-buttons.jpg', 'categories' => ['botones']],
            ['name' => 'Seimitsu PS-14-G Button (Set x6)', 'description' => 'Set de 6 botones Seimitsu de bajo recorrido, tacto suave.', 'price' => 18.5, 'stock' => 40, 'brand' => 'seimitsu', 'image' => 'images/sanwa-buttons.jpg', 'categories' => ['botones']],
            ['name' => 'Seimitsu LS-56 Joystick', 'description' => 'Joystick Seimitsu de tensión ajustable, popular en la escena competitiva.', 'price' => 52.0, 'stock' => 14, 'brand' => 'seimitsu', 'image' => 'images/gl-lever.jpg', 'categories' => ['joysticks']],
            ['name' => 'Hori Fighting Commander OCTA', 'description' => 'Gamepad Hori con D-pad octogonal, compatible con PC y consolas.', 'price' => 39.99, 'stock' => 22, 'brand' => 'hori', 'image' => 'images/victrix-pro-ko.png', 'categories' => ['fightpads-y-controladores']],
            ['name' => 'Crown Samducksa Joystick', 'description' => 'Joystick Crown de origen coreano, muy usado en máquinas arcade tradicionales.', 'price' => 35.0, 'stock' => 20, 'brand' => 'crown', 'image' => 'images/gl-lever.jpg', 'categories' => ['joysticks', 'palancas-arcade']],
            ['name' => 'Crown Button Set (24mm, 8 unidades)', 'description' => 'Set de botones Crown de 24mm en varios colores.', 'price' => 22.0, 'stock' => 35, 'brand' => 'crown', 'image' => 'images/sanwa-buttons.jpg', 'categories' => ['botones']],
            ['name' => 'Brook PS4/PS5 Fighting Board', 'description' => 'PCB Brook específico para consolas PlayStation, plug and play.', 'price' => 64.99, 'stock' => 25, 'brand' => 'brook', 'image' => 'images/haute42-t16.jpg', 'categories' => ['pcbs-y-adaptadores']],
            ['name' => 'Brook Wingman FGC (Adaptador cross-platform)', 'description' => 'Adaptador Brook para usar un mismo stick en múltiples consolas.', 'price' => 89.99, 'stock' => 12, 'brand' => 'brook', 'image' => 'images/haute42-t16.jpg', 'categories' => ['pcbs-y-adaptadores', 'accesorios']],
            ['name' => 'Mayflash F500 Elite Arcade Stick', 'description' => 'Versión superior del F300, con case metálico y joystick Sanwa incluido.', 'price' => 119.99, 'stock' => 8, 'brand' => 'mayflash', 'image' => 'images/arcade-stick.jpg', 'categories' => ['palancas-arcade']],
            ['name' => 'Mayflash Magic-NS (Adaptador para Switch)', 'description' => 'Adaptador Mayflash para conectar sticks arcade a Nintendo Switch.', 'price' => 24.99, 'stock' => 40, 'brand' => 'mayflash', 'image' => 'images/pw-leverless.jpg', 'categories' => ['pcbs-y-adaptadores']],
            ['name' => "Jasen's Customs Artisan Balltop", 'description' => 'Balltop artesanal personalizado, compatible con ejes Sanwa/Seimitsu.', 'price' => 15.0, 'stock' => 60, 'brand' => 'jasen-s-customs', 'image' => 'images/pw-leverless.jpg', 'categories' => ['accesorios']],
            ['name' => "Jasen's Customs Panel de Metacrilato", 'description' => 'Panel superior custom para montar botones y joystick.', 'price' => 45.0, 'stock' => 10, 'brand' => 'jasen-s-customs', 'image' => 'images/Qanba-Obsidian-2.png', 'categories' => ['accesorios', 'palancas-arcade']],
            ['name' => 'Varmilo VA88M Teclado (Low Profile)', 'description' => 'Teclado mecánico de perfil bajo, switches lineales silenciosos.', 'price' => 149.99, 'stock' => 6, 'brand' => 'varmilo', 'image' => 'images/user.jpg', 'categories' => ['accesorios']],
            ['name' => 'Varmilo Deadpool Keycap Set', 'description' => 'Set de keycaps temático, compatible con switches Cherry MX.', 'price' => 39.99, 'stock' => 15, 'brand' => 'varmilo', 'image' => 'images/user.jpg', 'categories' => ['accesorios']],
            ['name' => 'Qanba Obsidian Arcade Joystick', 'description' => 'Arcade stick premium con case de aluminio y joystick Sanwa JLF.', 'price' => 249.99, 'stock' => 5, 'brand' => 'hori', 'image' => 'images/Qanba-Obsidian-2.png', 'categories' => ['palancas-arcade', 'fightpads-y-controladores']],
        ];

        foreach ($products as $p) {
            $this->createProduct($p['name'], $p['description'], $p['price'], $p['stock'], $p['brand'], $p['image'], $p['categories']);
        }
    }

    /**
     * Completa el catálogo hasta $targetTotal combinando marcas x categorías
     * con plantillas de nombres temáticos, evitando duplicar los ya cargados.
     */
    private function seedGeneratedProducts(int $targetTotal): void
    {
        $templates = [
            'joysticks' => ['%s Competition Joystick', '%s Tournament Lever', '%s Precision Stick'],
            'botones' => ['Kit de Botones %s (Set x8)', 'Botón %s Mini 24mm', 'Set Botones %s Translúcidos'],
            'fightpads-y-controladores' => ['%s Fightpad Tournament Edition', '%s Wireless Controller Pro'],
            'pcbs-y-adaptadores' => ['%s Multi-Console Adapter', 'PCB %s Universal'],
            'accesorios' => ['Cable %s USB-C Trenzado', 'Case de Transporte %s', 'Kit de Cables %s Custom'],
            'palancas-arcade' => ['Palanca Arcade %s Deluxe', '%s Tournament Stick Edition'],
        ];

        $images = [
            'images/arcade-stick.jpg', 'images/gl-lever.jpg', 'images/haute42-t16.jpg',
            'images/pw-leverless.jpg', 'images/Qanba-Obsidian-2.png', 'images/sanwa-buttons.jpg',
            'images/sanwa-red.jpg', 'images/victrix-pro-ko.png',
        ];

        $priceRanges = [
            'joysticks' => [30, 60], 'botones' => [10, 35],
            'fightpads-y-controladores' => [50, 180], 'pcbs-y-adaptadores' => [40, 100],
            'accesorios' => [8, 50], 'palancas-arcade' => [70, 220],
        ];

        $brands = Brand::pluck('name', 'slug');
        $currentCount = Product::count();
        $needed = max(0, $targetTotal - $currentCount);

        $combinations = [];
        foreach ($brands as $brandSlug => $brandName) {
            foreach ($templates as $categorySlug => $templateList) {
                foreach ($templateList as $template) {
                    $combinations[] = [$brandSlug, $brandName, $categorySlug, $template];
                }
            }
        }

        shuffle($combinations);

        foreach (array_slice($combinations, 0, $needed) as [$brandSlug, $brandName, $categorySlug, $template]) {
            $name = sprintf($template, $brandName);
            $slug = Str::slug($name);

            if (Product::where('slug', $slug)->exists()) {
                continue;
            }

            [$min, $max] = $priceRanges[$categorySlug];

            $this->createProduct(
                name: $name,
                description: "Producto {$brandName} de la categoría " . Category::where('slug', $categorySlug)->value('name') . '.',
                price: fake()->randomFloat(2, $min, $max),
                stock: fake()->numberBetween(5, 80),
                brandSlug: $brandSlug,
                image: fake()->randomElement($images),
                categorySlugs: [$categorySlug],
            );
        }
    }

    private function createProduct(string $name, string $description, float $price, int $stock, string $brandSlug, string $image, array $categorySlugs): void
    {
        $slug = Str::slug($name);
        $brand = Brand::where('slug', $brandSlug)->first();

        if (Product::where('slug', $slug)->exists()) {
            return;
        }

        $product = Product::factory()->create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'price' => $price,
            'stock' => $stock,
            'image' => $image,
            'active' => true,
            'brand_id' => $brand?->id,
        ]);

        $categoryIds = Category::whereIn('slug', $categorySlugs)->pluck('id')->toArray();
        if (!empty($categoryIds)) {
            $product->categories()->syncWithoutDetaching($categoryIds);
        }

        ProductImage::factory()->state(['product_id' => $product->id, 'path' => $image, 'order' => 0, 'is_primary' => true])->create();
        ProductImage::factory()->count(2)->state(['product_id' => $product->id, 'is_primary' => false])->create();
    }
}
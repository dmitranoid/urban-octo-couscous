<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Manufacturer;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sku = $this->faker->unique()->numerify('##-' . $this->faker->currencyCode() . '-###');

        $names = [
            'Analog input module',
            'Interface module',
            'CPU',
            'Touch Panel',
            'Power supply',
            'Frequency converter',
            'Memory card',
            'Digital input module',
            'Digital output module',
            'Digital input/output module',
            'Analog output module',
        ];

        $images = [
            '/assets/images/products/6AV2123-2DB03-0AX0.jpg',
            '/assets/images/products/6AV2124-1GC01-0AX0.jpg',
            '/assets/images/products/6EP1933-2EC51.jpg',
            '/assets/images/products/6ES7132-6BF01-0AA0.jpg',
            '/assets/images/products/6ES7136-6AA00-0CA1.jpg',
            '/assets/images/products/6ES7211-1HE40-0XB0.jpg',
            '/assets/images/products/6ES7314-6CH04-0AB0.jpg',
            '/assets/images/products/6ES7526-1BH00-0AB0.jpg',
            '/assets/images/products/6ES7550-1AA00-0AB0.jpg',
            '/assets/images/products/6SL3210-5BE31-1UV0.jpg',
            '/assets/images/products/6SL3244-0BB13-1FA0.jpg',
            '/assets/images/products/7MH4910-0AA01.jpg',
        ];

        $files = [
            'file1.pdf',
            'file2.pdf',
            'file3.pdf',
            'file4.pdf',
            'file5.pdf',
        ];

        $category = Category::all()->random();

        return [
            'sku' => $sku,
            'name' => $this->faker->randomElement($names),
            'description' => $this->faker->paragraph(),
            'slug' => Str::slug($sku),
            'image' => $this->faker->randomElement($images),
            'images' => null,
            'options' => null,
            'files' => implode(PHP_EOL, $this->faker->randomElements($files, 2)),
            'manufacturer_id' => $category->manufacturer_id,
            'category_id' => $category->id,
            'position' => 100,
            'is_active' => 1,
            'stock' => random_int(0, 100),
            'partner_stock' => random_int(0, 100),
            'price' => random_int(10, 1000),
            'meta_title' => $this->faker->title,
            'meta_description' => $this->faker->sentence,
        ];
    }
}

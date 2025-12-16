<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;


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
        $name = $this->faker->words(3, true);

        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => $name,
            'slug' => '',
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10000, 1000000),
            'discount_price' => null,
            'stock' => $this->faker->numberBetween(0, 200),
            'weight' => $this->faker->numberBetween(100, 5000),
            'is_active' => $this->faker->boolean(85),
            'is_featured' => $this->faker->boolean(10),
        ];
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_featured' => true,
            ];
        });
    }
}

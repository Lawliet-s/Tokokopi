<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Product> */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'nama_kopi' => fake()->word() . ' Coffee',
            'harga' => fake()->numberBetween(10000, 50000),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition()
    {
        return [
            'img_path' => 'default_image.jpg',
            'product_name' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween($min = 100, $max = 500),
            'stock' => $this->faker->numberBetween($min = 0, $max = 5),
            'company_id' => $this->faker->realText(10),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => null,

        ];
    }
}

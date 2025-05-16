<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceProvider>
 */
class ServiceProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seed = $this->faker->unique()->numberBetween(1, 10000);

        return [
            'name'        => $this->faker->company,
            'description' => $this->faker->paragraph,
            'logo'        => "https://picsum.photos/seed/{$seed}/400/300",
            'category_id' => Category::factory(),
        ];
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 categories, each with 10 providers
        \App\Models\Category::factory(5)
            ->create()
            ->each(fn($category) => \App\Models\ServiceProvider::factory(10)
                ->create(['category_id' => $category->id])
            );
    }

}

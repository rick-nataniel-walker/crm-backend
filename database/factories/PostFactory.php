<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'slug' => fake()->sentence,
            'excerpt' => fake()->sentence,
            'content' => fake()->sentence,
            'author_id' => fake()->numberBetween(1,10),
            'category_id' => fake()->numberBetween(1,10),
            'featured_image' => fake()->sentence,
            'status' => "draft",
            'published_at' => fake()->dateTime,
        ];
    }
}

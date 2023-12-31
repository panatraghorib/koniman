<?php

namespace Database\Factories\Blog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog\Post>
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
            'name' => substr($this->faker->text(30), 0, -1),
            'slug' => '',
            'intro' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(rand(5, 7), true),
            'type' => $this->faker->randomElement(['Artikel', 'Blog', 'Pengumuman']),
            'is_featured' => $this->faker->randomElement([1, 0]),
            'featured_image' => 'https://picsum.photos/1200/630',
            'status' => $this->faker->randomElement([1, 0, 2]),
            'category_id' => $this->faker->numberBetween(1, 5),
            'meta_title' => '',
            'created_by' => $this->faker->randomElement([1, 3, 2, 4]),
            'meta_keywords' => '',
            'meta_description' => '',
            'meta_og_image' => 'https://picsum.photos/1200/630',
            'meta_og_url' => '',
            'created_by_name' => fake()->name(),
            'created_by_alias' => fake()->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'published_at' => Carbon::now(),
        ];
    }
}

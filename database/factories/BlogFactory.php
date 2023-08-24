<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blog;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text,
            'user_id' => rand(1,200),
            'slug' => $this->faker->slug,
            'keywords' => $this->faker->text,
            'description' => $this->faker->text,
            'content' => $this->faker->paragraph,
        ];
    }
}

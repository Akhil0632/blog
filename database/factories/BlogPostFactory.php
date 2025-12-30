<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 8));

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'content' => $this->faker->paragraphs(rand(5, 15), true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    public function recent()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }

    public function popular()
    {
        return $this->state(function (array $attributes) {
            return [
                'content' => $this->faker->paragraphs(rand(20, 30), true),
            ];
        });
    }

    public function shortTitle()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => $this->faker->words(rand(2, 3), true),
            ];
        });
    }

    public function longTitle()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => $this->faker->sentence(rand(8, 12)),
            ];
        });
    }
}

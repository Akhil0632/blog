<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BlogPost;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->has(
                BlogPost::factory()
                    ->count(rand(3, 8))
                    ->state(function (array $attributes, User $user) {
                        return ['user_id' => $user->id];
                    })
            )
            ->create();

        $users = User::all();
        
        foreach ($users as $user) {
            BlogPost::factory()
                ->count(rand(1, 3))
                ->create([
                    'user_id' => $user->id,
                ]);
        }

        $examplePosts = [
            [
                'user_id' => User::first()->id,
                'title' => 'Getting Started with Laravel',
                'content' => 'Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects.',
            ],
            [
                'user_id' => User::first()->id,
                'title' => 'Building RESTful APIs',
                'content' => 'RESTful APIs are a key component of modern web applications. They allow different systems to communicate with each other. Laravel makes it easy to build robust APIs with features like resource controllers, API authentication, and response formatting.',
            ],
            [
                'user_id' => User::inRandomOrder()->first()->id,
                'title' => 'Database Seeding in Laravel',
                'content' => 'Database seeding is the process of populating your database with sample or test data. Laravel includes a simple method of seeding your database with test data using seed classes. Seed classes are stored in the database/seeders directory.',
            ],
        ];

        foreach ($examplePosts as $post) {
            BlogPost::create($post);
        }

        BlogPost::factory()
            ->count(5)
            ->popular()
            ->create([
                'user_id' => User::inRandomOrder()->first()->id,
            ]);

        BlogPost::factory()
            ->count(8)
            ->recent()
            ->create([
                'user_id' => User::inRandomOrder()->first()->id,
            ]);

        $this->command->info('Blog posts seeded successfully!');
        $this->command->info('Total Users: ' . User::count());
        $this->command->info('Total Posts: ' . BlogPost::count());
    }
}

<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $blogs = [
            [
                'title' => 'The Future of Technology',
                'details' => 'Technology is evolving at a rapid pace. Here is what to expect in the coming years...',
                'tags' => ['tech', 'future', 'innovation'],
                'date' => now()->subDays(5),
            ],
            [
                'title' => 'Sustainable Business Practices',
                'details' => 'Sustainability is key to long-term success. Learn how to implement green practices...',
                'tags' => ['business', 'sustainability', 'environment'],
                'date' => now()->subDays(10),
            ],
            [
                'title' => 'Maximizing Productivity',
                'details' => 'Productivity hacks that will change the way you work forever...',
                'tags' => ['productivity', 'work', 'tips'],
                'date' => now()->subDays(2),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['title' => $blog['title']],
                [
                    'user_id' => $user?->id,
                    'slug' => Str::slug($blog['title']),
                    'details' => $blog['details'],
                    'tags' => $blog['tags'],
                    'date' => $blog['date'],
                    'active' => true,
                ]
            );
        }
    }
}

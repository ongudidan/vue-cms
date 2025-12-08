<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure default theme exists (it should be auto-discovered, but let's be safe)
        $defaultTheme = Theme::firstOrCreate(
            ['slug' => 'default'],
            [
                'name' => 'Default Theme',
                'path' => base_path('themes/default'),
                'is_active' => true,
                // 'config' => json_decode(file_get_contents(base_path('themes/default/theme.json')), true),
            ]
        );

        $pages = [
            [
                'title' => 'Home',
                'description' => 'Welcome to our company portfolio. We deliver excellence.',
                'published' => true,
            ],
            [
                'title' => 'About Us',
                'description' => 'Learn more about our history, mission, and vision.',
                'published' => true,
            ],
            [
                'title' => 'Contact Us',
                'description' => 'Get in touch with us for any inquiries.',
                'published' => true,
            ],
            [
                'title' => 'Services',
                'description' => 'Explore the wide range of services we offer.',
                'published' => true,
            ],
            [
                'title' => 'Portfolio',
                'description' => 'Check out our latest projects and success stories.',
                'published' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['title' => $page['title']],
                [
                    'slug' => Str::slug($page['title']),
                    'description' => $page['description'],
                    'published' => $page['published'],
                    'theme_id' => $defaultTheme->id,
                ]
            );
        }
    }
}

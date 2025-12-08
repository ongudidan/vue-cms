<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'details' => 'Custom web applications tailored to your business needs.',
            ],
            [
                'title' => 'Mobile App Development',
                'details' => 'Native and cross-platform mobile apps for iOS and Android.',
            ],
            [
                'title' => 'Digital Marketing',
                'details' => 'SEO, SEM, and social media marketing strategies to grow your audience.',
            ],
            [
                'title' => 'Cloud Solutions',
                'details' => 'Scalable cloud infrastructure and migration services.',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title' => $service['title']],
                [
                    'slug' => Str::slug($service['title']),
                    'details' => $service['details'],
                    'active' => true,
                ]
            );
        }
    }
}

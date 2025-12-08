<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'E-commerce Platform Revamp',
                'details' => 'Complete overhaul of a major e-commerce platform using modern technologies.',
                'tags' => ['web', 'e-commerce', 'react'],
                'status' => 1, // Completed
            ],
            [
                'title' => 'Corporate Mobile App',
                'details' => 'Development of a secure internal communication app for a large corporation.',
                'tags' => ['mobile', 'ios', 'android'],
                'status' => 1, // Completed
            ],
            [
                'title' => 'AI-Powered Analytics Dashboard',
                'details' => 'Building a real-time analytics dashboard with predictive capabilities.',
                'tags' => ['ai', 'analytics', 'dashboard'],
                'status' => 0, // In Progress
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['title' => $project['title']],
                [
                    'slug' => Str::slug($project['title']),
                    'details' => $project['details'],
                    'tags' => $project['tags'],
                    'status' => $project['status'],
                    'active' => true,
                ]
            );
        }
    }
}

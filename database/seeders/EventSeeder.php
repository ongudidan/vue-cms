<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $events = [
            [
                'title' => 'Annual Tech Conference',
                'date' => now()->addMonths(2),
                'location' => 'Convention Center, New York',
                'details' => 'Join us for the biggest tech event of the year.',
                'tags' => ['tech', 'conference', 'networking'],
            ],
            [
                'title' => 'Product Launch Webinar',
                'date' => now()->addWeeks(3),
                'location' => 'Online',
                'details' => 'Be the first to see our revolutionary new product.',
                'tags' => ['webinar', 'product', 'launch'],
            ],
            [
                'title' => 'Community Meetup',
                'date' => now()->addMonth(),
                'location' => 'Central Park, New York',
                'details' => 'A casual meetup for our community members.',
                'tags' => ['community', 'meetup', 'social'],
            ],
        ];

        foreach ($events as $event) {
            Event::updateOrCreate(
                ['title' => $event['title']],
                [
                    'user_id' => $user?->id,
                    'slug' => Str::slug($event['title']),
                    'date' => $event['date'],
                    'location' => $event['location'],
                    'details' => $event['details'],
                    'tags' => $event['tags'],
                    'active' => true,
                ]
            );
        }
    }
}

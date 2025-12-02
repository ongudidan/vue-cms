<?php

namespace Database\Seeders;

use App\Models\BoardMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BoardMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'John Doe',
                'position' => 'CEO',
                'details' => 'John has over 20 years of experience in the industry.',
            ],
            [
                'name' => 'Jane Smith',
                'position' => 'CTO',
                'details' => 'Jane is a visionary tech leader with a passion for innovation.',
            ],
            [
                'name' => 'Robert Johnson',
                'position' => 'CFO',
                'details' => 'Robert ensures the financial health and stability of the company.',
            ],
        ];

        foreach ($members as $member) {
            BoardMember::updateOrCreate(
                ['name' => $member['name']],
                [
                    'slug' => Str::slug($member['name']),
                    'position' => $member['position'],
                    'details' => $member['details'],
                    'active' => true,
                ]
            );
        }
    }
}

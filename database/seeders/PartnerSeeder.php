<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'TechGiant'],
            ['name' => 'CloudServices Provider'],
            ['name' => 'Marketing Gurus'],
            ['name' => 'Design Studio'],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                [
                    'active' => true,
                ]
            );
        }
    }
}

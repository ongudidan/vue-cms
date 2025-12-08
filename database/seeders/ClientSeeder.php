<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'Acme Corp'],
            ['name' => 'Global Tech'],
            ['name' => 'Innovate Inc'],
            ['name' => 'Future Systems'],
            ['name' => 'BlueSky Solutions'],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(
                ['name' => $client['name']],
                [
                    'active' => true,
                ]
            );
        }
    }
}

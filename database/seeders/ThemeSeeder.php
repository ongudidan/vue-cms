<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // The default theme will be auto-discovered by ThemeServiceProvider
        // This seeder is here in case you want to manually seed themes

        // You can manually create themes here if needed
        // Theme::create([
        //     'name' => 'Default Theme',
        //     'slug' => 'default',
        //     'path' => base_path('themes/default'),
        //     'is_active' => true,
        //     'config' => json_decode(file_get_contents(base_path('themes/default/theme.json')), true),
        // ]);
    }
}

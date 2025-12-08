<?php

namespace Database\Seeders;

use App\Services\ThemeService;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    protected ThemeService $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sync themes from filesystem
        $results = $this->themeService->syncThemes();

        $this->command->info('Themes synced successfully.');

        if (count($results['registered']) > 0) {
            $this->command->info('Registered: ' . implode(', ', $results['registered']));
        }

        if (count($results['removed']) > 0) {
            $this->command->info('Removed: ' . implode(', ', $results['removed']));
        }

        // Activate the default theme if it exists
        $defaultTheme = \App\Models\Theme::where('slug', 'default')->first();

        if ($defaultTheme) {
            $this->themeService->activateTheme($defaultTheme->id);
            $this->command->info("Default theme activated.");
        } else {
            $this->command->warn("Default theme not found. Please create a theme in the themes/ directory.");
        }
    }
}

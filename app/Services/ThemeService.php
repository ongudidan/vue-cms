<?php

namespace App\Services;

use App\Models\Theme;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ThemeService
{
    protected string $themesPath;
    protected string $jsThemesPath;

    public function __construct()
    {
        $this->themesPath = base_path('themes'); // For Blade templates and assets
        $this->jsThemesPath = resource_path('js/themes'); // For Vue forms and theme.json
    }

    /**
     * Discover all themes from the resources/js/themes directory.
     */
    public function discoverThemes(): array
    {
        if (!File::exists($this->jsThemesPath)) {
            File::makeDirectory($this->jsThemesPath, 0755, true);
            return [];
        }

        $themes = [];
        $directories = File::directories($this->jsThemesPath);

        foreach ($directories as $directory) {
            $themeJsonPath = $directory . '/theme.json';

            if (File::exists($themeJsonPath)) {
                try {
                    $themeData = json_decode(File::get($themeJsonPath), true);

                    if ($themeData && isset($themeData['slug'])) {
                        $themes[] = [
                            'path' => basename($directory),
                            'data' => $themeData,
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning("Failed to parse theme.json in {$directory}: " . $e->getMessage());
                }
            }
        }

        return $themes;
    }

    /**
     * Register a theme in the database.
     */
    public function registerTheme(array $themeData, string $path): Theme
    {
        return Theme::updateOrCreate(
            ['slug' => $themeData['slug']],
            [
                'name' => $themeData['name'] ?? $themeData['slug'],
                'path' => $path,
                'description' => $themeData['description'] ?? null,
                'version' => $themeData['version'] ?? '1.0.0',
                'author' => $themeData['author'] ?? null,
                'config' => $themeData,
            ]
        );
    }

    /**
     * Sync themes from filesystem with database.
     * Registers new themes and removes deleted ones.
     */
    public function syncThemes(): array
    {
        $discoveredThemes = $this->discoverThemes();
        $registeredSlugs = [];
        $results = [
            'registered' => [],
            'removed' => [],
        ];

        // Register discovered themes
        foreach ($discoveredThemes as $theme) {
            $registeredTheme = $this->registerTheme($theme['data'], $theme['path']);
            $registeredSlugs[] = $theme['data']['slug'];
            $results['registered'][] = $registeredTheme->name;
        }

        // Remove themes that no longer exist in filesystem
        $themesToRemove = Theme::whereNotIn('slug', $registeredSlugs)->get();

        foreach ($themesToRemove as $theme) {
            $results['removed'][] = $theme->name;
            $theme->delete();
        }

        return $results;
    }

    /**
     * Activate a theme and deactivate all others.
     */
    public function activateTheme(int $themeId): Theme
    {
        $theme = Theme::findOrFail($themeId);

        // Deactivate all themes
        Theme::where('is_active', true)->update(['is_active' => false]);

        // Activate the selected theme
        $theme->update(['is_active' => true]);

        return $theme->fresh();
    }

    /**
     * Deactivate a theme.
     */
    public function deactivateTheme(int $themeId): Theme
    {
        $theme = Theme::findOrFail($themeId);
        $theme->update(['is_active' => false]);

        return $theme->fresh();
    }

    /**
     * Get the currently active theme.
     */
    public function getActiveTheme(): ?Theme
    {
        return Theme::where('is_active', true)->first();
    }

    /**
     * Get sections for a specific theme.
     */
    public function getThemeSections(int $themeId): array
    {
        $theme = Theme::findOrFail($themeId);
        return $theme->getConfig('sections', []);
    }

    /**
     * Get sections for the active theme.
     */
    public function getActiveSections(): array
    {
        $activeTheme = $this->getActiveTheme();

        if (!$activeTheme) {
            return [];
        }

        return $activeTheme->getConfig('sections', []);
    }

    /**
     * Get the full path to a theme directory (for Blade templates).
     */
    public function getThemePath(string $slug): string
    {
        return $this->themesPath . '/' . $slug;
    }

    /**
     * Get the full path to a theme's JS directory (for Vue components).
     */
    public function getJsThemePath(string $slug): string
    {
        return $this->jsThemesPath . '/' . $slug;
    }

    /**
     * Check if a theme exists in the filesystem.
     */
    public function themeExists(string $slug): bool
    {
        $jsThemePath = $this->getJsThemePath($slug);
        $themeJsonPath = $jsThemePath . '/theme.json';

        return File::exists($jsThemePath) && File::exists($themeJsonPath);
    }
}

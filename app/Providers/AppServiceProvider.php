<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register theme Blade views - register each theme individually
        $themesPath = resource_path('js/themes');

        if (is_dir($themesPath)) {
            $themeDirs = glob($themesPath . '/*', GLOB_ONLYDIR);

            foreach ($themeDirs as $themeDir) {
                $themeName = basename($themeDir);
                $this->loadViewsFrom($themeDir, "themes.{$themeName}");
            }
        }
    }
}

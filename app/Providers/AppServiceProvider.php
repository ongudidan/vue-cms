<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

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
        // Share menus with all views
        View::composer('*', function ($view) {
            $menus = Menu::with(['page', 'children', 'pages'])
                ->where('parent_id', -1)
                ->orderBy('order', 'asc')
                ->get();
            $view->with('navigation_menus', $menus);
        });

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

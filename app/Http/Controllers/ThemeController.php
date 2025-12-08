<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThemeController extends Controller
{
    protected ThemeService $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    /**
     * Display a listing of themes.
     */
    public function index()
    {
        $themes = Theme::orderBy('is_active', 'desc')
            ->orderBy('name')
            ->get()
            ->map(function ($theme) {
                return [
                    'id' => $theme->id,
                    'name' => $theme->name,
                    'slug' => $theme->slug,
                    'description' => $theme->description,
                    'version' => $theme->version,
                    'author' => $theme->author,
                    'is_active' => $theme->is_active,
                    'path' => $theme->path,
                    'sections_count' => count($theme->getSections()),
                ];
            });

        return Inertia::render('Admin/Themes/Themes', [
            'data' => [
                'themes' => $themes,
            ],
        ]);
    }

    /**
     * Activate a theme.
     */
    public function activate(Request $request, int $id)
    {
        try {
            $theme = $this->themeService->activateTheme($id);

            return redirect()->route('admin.themes.index')
                ->with('success', "Theme '{$theme->name}' has been activated.");
        } catch (\Exception $e) {
            return redirect()->route('admin.themes.index')
                ->with('error', 'Failed to activate theme: ' . $e->getMessage());
        }
    }

    /**
     * Deactivate a theme.
     */
    public function deactivate(Request $request, int $id)
    {
        try {
            $theme = $this->themeService->deactivateTheme($id);

            return redirect()->route('admin.themes.index')
                ->with('success', "Theme '{$theme->name}' has been deactivated.");
        } catch (\Exception $e) {
            return redirect()->route('admin.themes.index')
                ->with('error', 'Failed to deactivate theme: ' . $e->getMessage());
        }
    }

    /**
     * Sync themes from filesystem.
     */
    public function sync()
    {
        try {
            $results = $this->themeService->syncThemes();

            $message = 'Themes synced successfully.';

            if (count($results['registered']) > 0) {
                $message .= ' Registered: ' . implode(', ', $results['registered']) . '.';
            }

            if (count($results['removed']) > 0) {
                $message .= ' Removed: ' . implode(', ', $results['removed']) . '.';
            }

            return redirect()->route('admin.themes.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('admin.themes.index')
                ->with('error', 'Failed to sync themes: ' . $e->getMessage());
        }
    }

    /**
     * Get sections for the active theme (API endpoint).
     */
    public function getActiveSections()
    {
        $sections = $this->themeService->getActiveSections();

        return response()->json([
            'sections' => $sections,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of pages.
     */
    public function index(Request $request)
    {
        $query = Page::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by published status
        if ($request->filled('published')) {
            $query->where('published', $request->published === '1');
        }

        $pages = $query->orderBy('created_at', 'desc')->get();

        return Inertia::render('Admin/Pages/Pages', [
            'data' => [
                'pages' => $pages,
                'filters' => [
                    'search' => $request->search,
                    'published' => $request->published,
                ],
            ],
        ]);
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:pages,title',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'description' => 'nullable|string',
            'content' => 'nullable|array',
            'published' => 'boolean',
            'is_homepage' => 'boolean',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $content = $request->input('content') ?? [];
        unset($validated['content']);

        $page = Page::create($validated);

        if (!empty($content)) {
            $page->content = $this->syncMedia($page, $content);
            $page->save();
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:pages,title,' . $page->id,
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'description' => 'nullable|string',
            'content' => 'nullable|array',
            'published' => 'boolean',
            'is_homepage' => 'boolean',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->has('content')) {
            $validated['content'] = $this->syncMedia($page, $request->input('content'));
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page)
    {
        // Delete all associated media
        $page->media()->each(function ($media) {
            $media->delete();
        });

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Process content media using custom Media model.
     */
    protected function syncMedia(Page $page, $content)
    {
        $processedContent = $content ?? [];
        $usedMediaIds = [];

        foreach ($processedContent as $index => &$section) {
            // Try to get the file directly from the request using the structured key
            $requestFile = request()->file("content.{$index}.data.background_image");

            if ($requestFile && $requestFile instanceof \Illuminate\Http\UploadedFile) {
                $image = $requestFile;
                $path = $image->store('media/pages', 'public');

                $media = $page->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);

                $section['data']['background_image'] = '/media-file/' . $path;
                $usedMediaIds[] = $media->id;
            } else {
                $image = $section['data']['background_image'] ?? null;

                if ($image && is_string($image) && !empty($image)) {
                    // Extract path from URL if it's one of ours
                    // Handle both absolute URLs and relative paths
                    $searchPath = $image;
                    if (str_contains($image, '/media-file/')) {
                        $parts = explode('/media-file/', $image);
                        $searchPath = end($parts);
                    }

                    $media = $page->media()->where('file_path', $searchPath)->first();
                    if ($media) {
                        $usedMediaIds[] = $media->id;
                    }
                }
            }
        }

        // Delete media that are no longer used in ANY section
        $page->media()
            ->whereNotIn('id', $usedMediaIds)
            ->each(fn($media) => $media->delete());

        return $processedContent;
    }

    /**
     * Display the homepage.
     */
    public function showHomepage()
    {
        $page = Page::where('is_homepage', true)
            ->where('published', true)
            ->first();

        if (!$page) {
            // Fallback to welcome page if no homepage is set
            return Inertia::render('Welcome', [
                'canRegister' => \Laravel\Fortify\Features::enabled(\Laravel\Fortify\Features::registration()),
            ]);
        }

        return $this->renderPage($page);
    }

    /**
     * Display the specified page on the frontend.
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        return $this->renderPage($page);
    }

    /**
     * Render a page with theme layout.
     */
    protected function renderPage(Page $page)
    {
        // Get active theme
        $theme = \App\Models\Theme::where('is_active', true)->first();

        // Determine which layout to use
        $layout = 'layouts.app'; // Default Laravel layout

        if ($theme) {
            // Check if theme has a custom layout
            $themeLayoutPath = resource_path("js/themes/{$theme->slug}/layout.blade.php");
            if (file_exists($themeLayoutPath)) {
                $layout = "themes.{$theme->slug}::layout";
            }
        }

        // Render sections
        $renderedSections = [];
        if (!empty($page->content)) {
            foreach ($page->content as $section) {
                if ($theme) {
                    $templatePath = $theme->getSectionTemplatePath($section['type']);
                    if ($templatePath) {
                        $renderedSections[] = view($templatePath, ['section' => $section])->render();
                    }
                }
            }
        }

        return view('pages.show', [
            'page' => $page,
            'sections' => $renderedSections,
            'layout' => $layout,
            'theme' => $theme,
        ]);
    }
}

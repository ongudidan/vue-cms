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

        Page::create($validated);

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

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}

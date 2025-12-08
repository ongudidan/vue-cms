<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of menus.
     */
    public function index(Request $request)
    {
        $query = Menu::query()
            ->with(['page', 'pages'])
            ->orderBy('order', 'asc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $menus = $query->get();
        $pages = Page::orderBy('title')->get(['id', 'title']);

        return Inertia::render('Admin/Menus/Index', [
            'data' => [
                'menus' => $menus,
                'pages' => $pages,
                'filters' => $request->only(['search']),
            ],
        ]);
    }

    /**
     * Store a newly created menu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:page,custom',
            'page_id' => 'nullable|exists:pages,id',
            'url' => 'nullable|string|max:255',
            'has_children' => 'boolean',
            'child_type' => 'nullable|in:pages,components',
            'component' => 'nullable|string|max:255',
            'pages' => 'nullable|array',
            'pages.*' => 'exists:pages,id',
        ]);

        // Get the highest order value and add 1
        $maxOrder = Menu::max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;

        // Remove pages array from validated data
        $pageIds = $validated['pages'] ?? [];
        unset($validated['pages']);

        $menu = Menu::create($validated);

        // Attach pages if child_type is 'pages'
        if ($validated['child_type'] === 'pages' && !empty($pageIds)) {
            $menu->pages()->attach($pageIds);
        }

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu created successfully.');
    }

    /**
     * Update the specified menu.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:page,custom',
            'page_id' => 'nullable|exists:pages,id',
            'url' => 'nullable|string|max:255',
            'has_children' => 'boolean',
            'child_type' => 'nullable|in:pages,components',
            'component' => 'nullable|string|max:255',
            'pages' => 'nullable|array',
            'pages.*' => 'exists:pages,id',
        ]);

        // Remove pages array from validated data
        $pageIds = $validated['pages'] ?? [];
        unset($validated['pages']);

        $menu->update($validated);

        // Sync pages if child_type is 'pages'
        if ($validated['child_type'] === 'pages') {
            $menu->pages()->sync($pageIds);
        } else {
            // Detach all pages if child_type is not 'pages'
            $menu->pages()->detach();
        }

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    /**
     * Update menu order (for drag and drop).
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'menus' => 'required|array',
            'menus.*.id' => 'required|exists:menus,id',
            'menus.*.order' => 'required|integer',
        ]);

        foreach ($validated['menus'] as $menuData) {
            Menu::where('id', $menuData['id'])->update(['order' => $menuData['order']]);
        }

        return back()->with('success', 'Menu order updated successfully.');
    }

    /**
     * Remove the specified menu.
     */
    public function destroy(Menu $menu)
    {
        $menu->pages()->detach();
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }
}

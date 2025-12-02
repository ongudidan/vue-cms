<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display a listing of Blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::query()->with('media');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%')
                    ->orWhere('details', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by active status
        if ($request->has('active') && $request->active !== null && $request->active !== '') {
            $query->where('active', $request->active);
        }


        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Paginate results
        $blogs = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Blogs/Blogs', [
            'data' => [
                'blogs' => $blogs,
                'filters' => $request->only(['search', 'active', 'sort', 'direction']),
            ],
        ]);
    }

    /**
     * Store a newly created Blog.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:Blogs,slug',
            'details' => 'nullable|string',
            'tags' => 'nullable|string',
            'date' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Convert tags string to array
        if (isset($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Remove images from validated data as we'll handle them separately
        unset($validated['images']);

        $blog = Blog::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/blogs', 'public');

                $blog->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    /**
     * Update the specified Blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blogs,slug,' . $blog->id,
            'details' => 'nullable|string',
            'tags' => 'nullable|string',
            'date' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Convert tags string to array
        if (isset($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Remove images from validated data
        unset($validated['images']);

        $blog->update($validated);

        // Handle image uploads - delete old media if new images are uploaded
        if ($request->hasFile('images')) {
            // Delete all existing media
            $blog->media()->each(function ($media) {
                $media->delete();
            });

            // Create new media records
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/blogs', 'public');

                $blog->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified Blog.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }
}

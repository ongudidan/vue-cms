<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(Request $request)
    {
        $query = Service::query()->with('media');

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
        $services = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Services/Services', [
            'data' => [
                'services' => $services,
                'filters' => $request->only(['search', 'active', 'sort', 'direction']),
            ],
        ]);
    }

    /**
     * Store a newly created service.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:services,slug',
            'details' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Remove images from validated data as we'll handle them separately
        unset($validated['images']);

        $service = Service::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/services', 'public');

                $service->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }



    /**
     * Update the specified service.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:services,slug,' . $service->id,
            'details' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Remove images from validated data
        unset($validated['images']);

        $service->update($validated);

        // Handle image uploads - delete old media if new images are uploaded
        if ($request->hasFile('images')) {
            // Delete all existing media
            $service->media()->each(function ($media) {
                $media->delete(); // This will trigger the Media model's deleting event
            });

            // Create new media records
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/services', 'public');

                $service->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }



    /**
     * Remove the specified service.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}

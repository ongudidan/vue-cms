<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of Events.
     */
    public function index(Request $request)
    {
        $query = Event::query()->with('media');

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

        // Filter by status
        if ($request->has('status') && $request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Paginate results
        $events = $query->paginate(10)->withQueryString();
        // dd($events);
        return Inertia::render('Admin/Events/Events', [
            'data' => [
                'events' => $events,
                'filters' => $request->only(['search', 'active', 'status', 'sort', 'direction']),
            ],
        ]);
    }

    /**
     * Store a newly created Event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:Events,slug',
            'details' => 'nullable|string',
            'tags' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'map_url' => 'nullable|url',
            'hosted_by' => 'nullable|string|max:255',
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

        $Event = Event::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/Events', 'public');

                $Event->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.Events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Update the specified Event.
     */
    public function update(Request $request, Event $Event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:Events,slug,' . $Event->id,
            'details' => 'nullable|string',
            'tags' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'map_url' => 'nullable|url',
            'hosted_by' => 'nullable|string|max:255',
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

        $Event->update($validated);

        // Handle image uploads - delete old media if new images are uploaded
        if ($request->hasFile('images')) {
            // Delete all existing media
            $Event->media()->each(function ($media) {
                $media->delete();
            });

            // Create new media records
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/Events', 'public');

                $Event->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return back(303)
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified Event.
     */
    public function destroy(Event $Event)
    {
        $Event->delete();

        return redirect()->route('admin.Events.index')
            ->with('success', 'Event deleted successfully.');
    }
}

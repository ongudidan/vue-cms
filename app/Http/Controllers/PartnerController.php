<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query()->with('media');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('active') && $request->active !== null && $request->active !== '') {
            $query->where('active', $request->active);
        }

        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $partners = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Partners/Index', [
            'data' => [
                'partners' => $partners,
                'filters' => $request->only(['search', 'active', 'sort', 'direction']),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        unset($validated['images']);
        $partner = Partner::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/partners', 'public');
                $partner->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        unset($validated['images']);
        $partner->update($validated);

        if ($request->hasFile('images')) {
            $partner->media()->each(function ($media) {
                $media->delete();
            });

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/partners', 'public');
                $partner->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}

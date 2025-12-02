<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BoardMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = BoardMember::query()->with('media');

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('position', 'like', '%' . $request->search . '%')
                    ->orWhere('details', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('active') && $request->active !== null && $request->active !== '') {
            $query->where('active', $request->active);
        }

        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $boardMembers = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/BoardMembers/Index', [
            'data' => [
                'boardMembers' => $boardMembers,
                'filters' => $request->only(['search', 'active', 'sort', 'direction']),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:board_members,slug',
            'position' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        unset($validated['images']);
        $boardMember = BoardMember::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/board-members', 'public');
                $boardMember->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.board-members.index')
            ->with('success', 'Board member created successfully.');
    }

    public function update(Request $request, BoardMember $boardMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:board_members,slug,' . $boardMember->id,
            'position' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        unset($validated['images']);
        $boardMember->update($validated);

        if ($request->hasFile('images')) {
            $boardMember->media()->each(function ($media) {
                $media->delete();
            });

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/board-members', 'public');
                $boardMember->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.board-members.index')
            ->with('success', 'Board member updated successfully.');
    }

    public function destroy(BoardMember $boardMember)
    {
        $boardMember->delete();
        return redirect()->route('admin.board-members.index')
            ->with('success', 'Board member deleted successfully.');
    }
}

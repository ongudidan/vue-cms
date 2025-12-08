<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query()->with('media');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('active') && $request->active !== null && $request->active !== '') {
            $query->where('active', $request->active);
        }

        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $clients = $query->paginate(10)->withQueryString();

        return Inertia::render('Admin/Clients/Index', [
            'data' => [
                'clients' => $clients,
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
        $client = Client::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/clients', 'public');
                $client->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        unset($validated['images']);
        $client->update($validated);

        if ($request->hasFile('images')) {
            $client->media()->each(function ($media) {
                $media->delete();
            });

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('media/clients', 'public');
                $client->media()->create([
                    'file_path' => $path,
                    'file_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}

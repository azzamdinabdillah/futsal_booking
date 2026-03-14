<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Illuminate\Support\Facades\Storage;
use App\Models\FieldPhoto;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with('photos')->get();

        return Inertia::render('Admin/Field/Index', [
            'fields' => $fields,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Field/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'length_m' => 'required|numeric|min:0',
            'width_m' => 'required|numeric|min:0',
            'surface_type' => 'required|string|max:100',
            'roof_type' => 'required|string|max:50',
            'player_capacity' => 'required|string|max:20',
            'description' => 'nullable|string',
            'status' => 'required|in:active,maintenance,inactive',
            'inactive_reason' => 'nullable|required_if:status,maintenance,inactive|string',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        $fieldData = collect($validated)->except('photos')->toArray();
        $field = Field::create($fieldData);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('fields', 'public');
                $field->photos()->create([
                    'photo_url' => 'storage/' . $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function edit(Field $field)
    {
        $field->load('photos');
        return Inertia::render('Admin/Field/Form', [
            'field' => $field,
        ]);
    }

    public function update(Request $request, Field $field)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'length_m' => 'required|numeric|min:0',
            'width_m' => 'required|numeric|min:0',
            'surface_type' => 'required|string|max:100',
            'roof_type' => 'required|string|max:50',
            'player_capacity' => 'required|string|max:20',
            'description' => 'nullable|string',
            'status' => 'required|in:active,maintenance,inactive',
            'inactive_reason' => 'nullable|required_if:status,maintenance,inactive|string',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|max:2048',
            'deleted_photos' => 'nullable|array',
            'deleted_photos.*' => 'integer|exists:field_photos,id',
        ]);

        $fieldData = collect($validated)->except(['photos', 'deleted_photos'])->toArray();
        $field->update($fieldData);

        // Handle deleted photos
        if ($request->filled('deleted_photos')) {
            $photosToDelete = FieldPhoto::whereIn('id', $request->deleted_photos)->get();
            foreach ($photosToDelete as $photo) {
                // Remove 'storage/' prefix if present to get relative path for deletion
                $path = str_replace('storage/', '', $photo->photo_url);
                Storage::disk('public')->delete($path);
                $photo->delete();
            }
        }

        // Handle new photos
        if ($request->hasFile('photos')) {
            // Re-fetch field with photos to ensure we have latest state if needed, or just use existing relation
            $currentMaxSortOrder = $field->photos()->max('sort_order') ?? 0;
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('fields', 'public');
                $field->photos()->create([
                    'photo_url' => 'storage/' . $path,
                    'sort_order' => $currentMaxSortOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Field $field)
    {
        // Delete associated photos from storage
        foreach ($field->photos as $photo) {
            $path = str_replace('storage/', '', $photo->photo_url);
            Storage::disk('public')->delete($path);
        }

        $field->delete();

        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus.');
    }
}

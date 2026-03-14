<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return Inertia::render('Admin/Field/Create');
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
}

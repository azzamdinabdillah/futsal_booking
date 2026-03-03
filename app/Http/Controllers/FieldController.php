<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with('photos')->get();
        return Inertia::render('Fields/Index', [
            'fields' => $fields,
        ]);
    }

    public function create()
    {
        return redirect()->route('fields.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('fields.index');
    }

    public function show(Field $field)
    {
        return redirect()->route('fields.index');
    }

    public function edit(Field $field)
    {
        return redirect()->route('fields.index');
    }

    public function update(Request $request, Field $field)
    {
        return redirect()->route('fields.index');
    }

    public function destroy(Field $field)
    {
        return redirect()->route('fields.index');
    }
}

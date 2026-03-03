<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        return view('fields.index');
    }

    public function create()
    {
        return view('fields.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('fields.index');
    }

    public function show(Field $field)
    {
        return view('fields.show', compact('field'));
    }

    public function edit(Field $field)
    {
        return view('fields.edit', compact('field'));
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

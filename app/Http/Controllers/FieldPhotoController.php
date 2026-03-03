<?php

namespace App\Http\Controllers;

use App\Models\FieldPhoto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FieldPhotoController extends Controller
{
    public function index()
    {
        return redirect()->route('fields.index');
    }

    public function create()
    {
        return redirect()->route('field-photos.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('field-photos.index');
    }

    public function show(FieldPhoto $fieldPhoto)
    {
        return redirect()->route('field-photos.index');
    }

    public function edit(FieldPhoto $fieldPhoto)
    {
        return redirect()->route('field-photos.index');
    }

    public function update(Request $request, FieldPhoto $fieldPhoto)
    {
        return redirect()->route('field-photos.index');
    }

    public function destroy(FieldPhoto $fieldPhoto)
    {
        return redirect()->route('field-photos.index');
    }
}

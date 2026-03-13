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
}

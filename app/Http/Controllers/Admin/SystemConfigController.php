<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SystemConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $configs = SystemConfig::all();

        return Inertia::render('Admin/SystemConfig/Index', [
            'configs' => $configs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation and update logic will be added later as per user request
    }
}

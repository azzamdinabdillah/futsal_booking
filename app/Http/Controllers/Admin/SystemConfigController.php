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
        // dd("bismillah");
        $config = SystemConfig::findOrFail($id);

        $validated = $request->validate([
            'value' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $config->update($validated);

        return redirect()->to('/admin/system-config');

        // return to_route('admin.system-config.index')->with('success', 'Configuration updated successfully!');
    }
}

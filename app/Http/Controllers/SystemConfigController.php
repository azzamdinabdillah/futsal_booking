<?php

namespace App\Http\Controllers;

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
        $configs = SystemConfig::with('updater')->get();
        return Inertia::render('SystemConfigs/Index', [
            'configs' => $configs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('system-configs.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('system-configs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemConfig $systemConfig)
    {
        return redirect()->route('system-configs.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SystemConfig $systemConfig)
    {
        return redirect()->route('system-configs.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SystemConfig $systemConfig)
    {
        return redirect()->route('system-configs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemConfig $systemConfig)
    {
        return redirect()->route('system-configs.index');
    }
}

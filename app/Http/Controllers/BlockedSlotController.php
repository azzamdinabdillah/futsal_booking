<?php

namespace App\Http\Controllers;

use App\Models\BlockedSlot;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlockedSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blockedSlots = BlockedSlot::with(['field', 'creator'])->get();
        return Inertia::render('BlockedSlots/Index', [
            'blockedSlots' => $blockedSlots
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('blocked-slots.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('blocked-slots.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlockedSlot $blockedSlot)
    {
        return redirect()->route('blocked-slots.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlockedSlot $blockedSlot)
    {
        return redirect()->route('blocked-slots.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlockedSlot $blockedSlot)
    {
        return redirect()->route('blocked-slots.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlockedSlot $blockedSlot)
    {
        return redirect()->route('blocked-slots.index');
    }
}

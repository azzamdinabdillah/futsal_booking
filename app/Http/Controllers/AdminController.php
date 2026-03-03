<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Index');
    }

    public function create()
    {
        return redirect()->route('admins.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admins.index');
    }

    public function show(Admin $admin)
    {
        return redirect()->route('admins.index');
    }

    public function edit(Admin $admin)
    {
        return redirect()->route('admins.index');
    }

    public function update(Request $request, Admin $admin)
    {
        return redirect()->route('admins.index');
    }

    public function destroy(Admin $admin)
    {
        return redirect()->route('admins.index');
    }
}

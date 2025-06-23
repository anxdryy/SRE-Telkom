<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    public function index(): View
    {
        $alumnis = Alumni::all();
        return view('alumni.index', compact('alumnis'));
    }

    public function create(): View
    {
        return view('alumni.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'achievement' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('alumni', 'public');
        }

        Alumni::create($validated);

        return redirect()->route('alumni.index')->with('success', 'Alumni created successfully.');
    }

    public function show(Alumni $alumni): View
    {
        return view('alumni.show', compact('alumni'));
    }

    public function edit(Alumni $alumni): View
    {
        return view('alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'achievement' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($alumni->image && Storage::disk('public')->exists($alumni->image)) {
                Storage::disk('public')->delete($alumni->image);
            }

            $path = $request->file('image')->store('members', 'public');
            $validated['image'] = $path;
        } else {
            // Keep existing image if no new one is provided
            $validated['image'] = $alumni->image;
        }


        $alumni->update($validated);

        return redirect()->route('alumni.index')->with('success', 'Alumni updated successfully.');
    }

    public function destroy(Alumni $alumni)
    {
        // Delete Alumni image
        if ($alumni->image && Storage::disk('public')->exists($alumni->image)) {
            Storage::disk('public')->delete($alumni->image);
        }
        $alumni->delete();

        return redirect()->route('alumni.index')->with('success', 'Alumni deleted successfully.');
    }
}

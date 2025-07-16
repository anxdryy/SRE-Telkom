<?php

namespace App\Http\Controllers;

use App\Models\Programs;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramsController extends Controller{

    public function create(): View{
        $categories = Category::all();
        return view('programs.create', compact('categories'));
    }

    public function index(): View{
        $programs = Programs::with('category')->oldest()->paginate(10);
        return view('programs.index', compact('programs'));
    }

    public function store(Request $request): RedirectResponse{
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'instagram' => 'required|url|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('programs', 'public');
            $validated['image'] = $path;
        }

        Programs::create($validated);

        return redirect()->route('programs.index')
            ->with('success', 'Program created successfully.');

    }

    public function show(Programs $program): View {
        $program->load('category');
        return view('programs.show', compact('program'));
    }

    public function edit(Programs $program): View{
        $categories = Category::all();
        return view('programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Programs $program): RedirectResponse{
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'instagram' => 'required|url|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
            }

            $path = $request->file('image')->store('programs', 'public');
            $validated['image'] = $path;
        } else {
            // Keep old image
            $validated['image'] = $program->image;
        }

        $program->update($validated);

        return redirect()->route('programs.index')
            ->with('success', 'Program updated successfully.');
    }

    public function destroy(Programs $program): RedirectResponse{
        // Delete image if exists
        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    public function activity(): \Illuminate\View\View
    {
        $category = \App\Models\Category::where('name', 'Activity')->first();

        $programs = $category ? $category->programs()->latest()->get() : collect();

        return view('activity', compact('programs'));
    }

    public function showDetail(string $slug): View
    {
        $program = Programs::with('category')->where('slug', $slug)->firstOrFail();

        return view('news', compact('program'));
    }

}



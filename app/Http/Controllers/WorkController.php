<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Department;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    // Show the create form
    public function create(): View {
        $departments = Department::all();
        return view('works.create', compact('departments'));
    }

    // List
    public function index(): View {
        $works = Work::with('department')->oldest()->paginate(10);
        return view('works.index', compact('works'));
    }

    // Store
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('works', 'public');
            $validated['image'] = $path;
        }

        Work::create($validated);

        return redirect()->route('works.index')
            ->with('success', 'Work created successfully.');
    }

    // Show details
    public function show(Work $work): View
    {
        $work->load('department');
        return view('works.show', compact('work'));
    }

    // Show the update form
    public function edit(Work $work): View
    {
        $departments = Department::all();
        return view('works.edit', compact('work', 'departments'));
    }

    // Update
    public function update(Request $request, Work $work): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($work->image && Storage::disk('public')->exists($work->image)) {
                Storage::disk('public')->delete($work->image);
            }

            $path = $request->file('image')->store('works', 'public');
            $validated['image'] = $path;
        } else {
            // Keep existing image if no new one is provided
            $validated['image'] = $work->image;
        }

        $work->update($validated);

        return redirect()->route('works.index')
            ->with('success', 'Work updated successfully.');
    }

    // Delete
    public function destroy(Work $work): RedirectResponse
    {
        // Delete work image
        if ($work->image && Storage::disk('public')->exists($work->image)) {
            Storage::disk('public')->delete($work->image);
        }

        $work->delete();

        return redirect()->route('works.index')
            ->with('success', 'Work deleted successfully.');
    }
}

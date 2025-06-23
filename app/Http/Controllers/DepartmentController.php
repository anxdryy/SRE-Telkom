<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    // Show the create form
    public function create(): View {
        return view('departments.create');
    }

    // List
    public function index(): View {
        $departments = Department::withCount('members', 'works')->oldest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    // Store
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('departments', 'public');
            $validated['image'] = $path;
        }

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    // Show details
    public function show(Department $department): View {
        $department->load('members', 'works');
        return view('departments.show', compact('department'));
    }

    // Show the update form
    public function edit(Department $department): View {
        return view('departments.edit', compact('department'));
    }

    // Update
    public function update(Request $request, Department $department): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,'. $department->id,
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($department->image && Storage::disk('public')->exists($department->image)) {
                Storage::disk('public')->delete($department->image);
            }

            $path = $request->file('image')->store('departments', 'public');
            $validated['image'] = $path;
        } else {
            // Keep existing image if no new one is provided
            $validated['image'] = $work->image;
        }

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    // Delete
    public function destroy(Department $department): RedirectResponse{
        // Check if department has members
        if ($department->members()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department with members.');
        }

        // Check if department has works
        if ($department->works()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department with works.');
        }

        // Delete department image
        if ($work->image && Storage::disk('public')->exists($work->image)) {
            Storage::disk('public')->delete($work->image);
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}

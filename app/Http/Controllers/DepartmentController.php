<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function create(): View {
        return view('departments.create');
    }

    public function index(): View {
        $departments = Department::withCount('members', 'works')->oldest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('departments', 'public');
            $validated['image'] = $path;
        }

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department): View {
        $department->load('members', 'works');
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department): View {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($department->image && Storage::disk('public')->exists($department->image)) {
                Storage::disk('public')->delete($department->image);
            }

            $path = $request->file('image')->store('departments', 'public');
            $validated['image'] = $path;
        } else {
            $validated['image'] = $department->image;
        }

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department): RedirectResponse {
        if ($department->members()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department with members.');
        }

        if ($department->works()->count() > 0) {
            return redirect()->route('departments.index')
                ->with('error', 'Cannot delete department with works.');
        }

        if ($department->image && Storage::disk('public')->exists($department->image)) {
            Storage::disk('public')->delete($department->image);
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    // Show the create form
    public function create(): View {
        return view('departments.create');
    }

    // List
    public function index(): View {
        $departments = Department::withCount('members')->oldest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    // Store
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    // Show details
    public function show(Department $department): View {
        $department->load('members');
        return view('departments.show', compact('department'));
    }

    // Show the update form
    public function edit(Department $department): View {
        return view('departments.edit', compact('department'));
    }

    // Update
    public function update(Request $request, Department $department): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

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

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}

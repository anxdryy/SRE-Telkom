<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    // Show create form
    public function create(): View {
        return view('departments.create');
    }

    // List departments
    public function index(): View {
        $departments = Department::withCount('members', 'works')->oldest()->paginate(10);
        return view('departments.index', compact('departments'));
    }

    // Store new department
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('departments', 'public');
            $validated['image'] = $path;
        }

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    // Show single department by route model binding
    public function show(Department $department): View {
        $department->load('members', 'works');
        return view('departments.show', compact('department'));
    }

    // Edit form
    public function edit(Department $department): View {
        return view('departments.edit', compact('department'));
    }

    // Update department
    public function update(Request $request, Department $department): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

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

    // Delete department
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

    // ✅ NEW METHOD: For front-end department page using ?dept=core
 public function detail(Request $request): \Illuminate\View\View
    {
        $id = $request->query('id');

        $department = \App\Models\Department::with(['members', 'works'])->find($id);

        if (!$department) {
            abort(404, 'Department not found');
        }

        return view('departement', compact('department'));
    }

    public function aboutUs(): View {
        $departments = Department::all();
        return view('aboutus', compact('departments'));
    }

    public function showDetail($slug): View
    {
        $department = Department::with(['members', 'works'])->where('slug', $slug)->first();

        if (!$department) {
            abort(404, 'Department not found');
        }

        return view('departement', compact('department'));
    }
}

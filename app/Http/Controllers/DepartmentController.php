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
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Upload background image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('departments/images', 'public');
            $validated['image'] = $path;
        }

        // Upload logo (optional)
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('departments/logos', 'public');
            $validated['logo'] = $logoPath;
        }

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    // Show single department
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Update image if uploaded
        if ($request->hasFile('image')) {
            if ($department->image && Storage::disk('public')->exists($department->image)) {
                Storage::disk('public')->delete($department->image);
            }

            $path = $request->file('image')->store('departments/images', 'public');
            $validated['image'] = $path;
        } else {
            $validated['image'] = $department->image;
        }

        // Update logo if uploaded
        if ($request->hasFile('logo')) {
            if ($department->logo && Storage::disk('public')->exists($department->logo)) {
                Storage::disk('public')->delete($department->logo);
            }

            $logoPath = $request->file('logo')->store('departments/logos', 'public');
            $validated['logo'] = $logoPath;
        } else {
            $validated['logo'] = $department->logo;
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

        // Delete stored files if exist
        if ($department->image && Storage::disk('public')->exists($department->image)) {
            Storage::disk('public')->delete($department->image);
        }
        if ($department->logo && Storage::disk('public')->exists($department->logo)) {
            Storage::disk('public')->delete($department->logo);
        }

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    public function showDetail($slug): View {
        $department = Department::with(['members', 'works'])->where('slug', $slug)->first();

        if (!$department) {
            abort(404, 'Department not found');
        }

        $departments = Department::where('slug', '!=', $slug)->get();

        return view('departement', compact('department', 'departments'));
    }

    public function fordeptpage(): View {
        $departments = Department::all();
        return view('departement', compact('departments'));
    }
}

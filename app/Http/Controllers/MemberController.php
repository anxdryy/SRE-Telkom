<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    // Show the create form
    public function create(): View {
        $departments = Department::all();
        return view('members.create', compact('departments'));
    }

    // List
    public function index(): View {
        $members = Member::with('department')->oldest()->paginate(10);
        return view('members.index', compact('members'));
    }

    // Store
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('members', 'public');
            $validated['image'] = $path;
        }

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Member created successfully.');
    }

    // Show details
    public function show(Member $member): View
    {
        $member->load('department');
        return view('members.show', compact('member'));
    }

    // Show the update form
    public function edit(Member $member): View
    {
        $departments = Department::all();
        return view('members.edit', compact('member', 'departments'));
    }

    // Update
    public function update(Request $request, Member $member): RedirectResponse {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($member->image && Storage::disk('public')->exists($member->image)) {
                Storage::disk('public')->delete($member->image);
            }

            $path = $request->file('image')->store('members', 'public');
            $validated['image'] = $path;
        } else {
            // Keep existing image if no new one is provided
            $validated['image'] = $member->image;
        }

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    // Delete
    public function destroy(Member $member): RedirectResponse
    {
        // Delete member image
        if ($member->image && Storage::disk('public')->exists($member->image)) {
            Storage::disk('public')->delete($member->image);
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programs;
use App\Models\Categories;

class ProgramsController extends Controller
{
    public function index()
    {
        $programs = Programs::all();
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        $categories = Categories::all(); // Ambil semua kategori untuk pilihan
        return view('programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Programs::create($request->all());

        return redirect()->route('programs.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function show(Programs $program)
    {
        return view('programs.show', compact('program'));
    }

    public function edit(Programs $program)
    {
        $categories = Categories::all(); // Untuk pilihan kategori saat edit
        return view('programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Programs $program)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $program->update($request->all());

        return redirect()->route('programs.index')->with('success', 'Program berhasil diupdate.');
    }

    public function destroy(Programs $program)
    {
        $program->delete();

        return redirect()->route('programs.index')->with('success', 'Program berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Alumni;
use Illuminate\View\View;

class AboutUsController extends Controller
{
    public function index(): View
    {
        $departments = Department::all();
        $alumnis = Alumni::all(); // Add this line to fetch alumni data

        return view('aboutus', compact('departments', 'alumnis'));
    }
}

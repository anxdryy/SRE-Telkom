<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\View\View;

class AboutUsController extends Controller
{
    public function index(): View
    {
        $departments = Department::all();
        return view('aboutus', compact('departments')); // <- this matches your Blade file name
    }
}

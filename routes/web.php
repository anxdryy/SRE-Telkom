<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AlumniController;
use App\Models\Programs;
use App\Models\Department;

Route::get('/', function () {
    $latestPrograms = Programs::with('category')->latest()->get();
    $departments = Department::all();
    return view('welcome', compact('latestPrograms', 'departments'));
});

Route::middleware(['guest'])->group(function () {
    Route::get('/admin', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('auth.login')
        ->middleware('throttle:5,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['login.auth'])
    ->prefix('admin')
    ->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('members', MemberController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('programs', ProgramsController::class);
        Route::resource('works', WorkController::class);
        Route::resource('alumni', AlumniController::class)->parameters(['alumni' => 'alumni']);
    });

Route::get('/AboutUs', [AboutUsController::class, 'index'])->name('aboutUs');

// Departments
Route::get('/departement', [DepartmentController::class, 'fordeptpage'])->name('departments.list');
Route::get('/departement/{slug}', [DepartmentController::class, 'showDetail'])->name('departments.showDetail');

// Programs by Category (with pagination)
Route::get('/Activity', function () {
    $programs = Programs::with('category')
        ->whereHas('category', function ($query) {
            $query->where('name', 'Activity');
        })
        ->paginate(5);

    return view('activity', compact('programs'));
});

Route::get('/Research', function () {
    $programs = Programs::with('category')
        ->whereHas('category', function ($query) {
            $query->where('name', 'Research');
        })
        ->paginate(5); // Show 5 items per page

    return view('research', compact('programs'));
});

Route::get('/Competition', function () {
    $programs = Programs::with('category')
        ->whereHas('category', function ($query) {
            $query->where('name', 'Competition');
        })
        ->paginate(5); // Show 5 items per page

    return view('competition', compact('programs'));
});

// Individual Program Detail
Route::get('/programs/{slug}', [ProgramsController::class, 'showDetail'])->name('programs.showDetail');

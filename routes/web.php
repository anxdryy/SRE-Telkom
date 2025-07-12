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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/admin', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['login.auth'])->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('members', MemberController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('programs', ProgramsController::class);
    Route::resource('works', WorkController::class);
    Route::resource('alumni', AlumniController::class)->parameters(['alumni' => 'alumni']);
});

Route::get('/AboutUs', [DepartmentController::class, 'aboutUs'])->name('aboutUs');

Route::get('/Departement', function () {
    return view('departement');
});

use App\Models\Programs;

Route::get('/Activity', function () {
    $programs = Programs::with('category')
        ->whereHas('category', function ($query) {
            $query->where('name', 'Activity');
        })
        ->get();

    return view('activity', compact('programs'));
});

Route::get('/Research', function () {
    return view('research');
});

Route::get('/Competition', function () {
    return view('competition');
});

Route::get('/News', function () {
    return view('news');
});

Route::get('/admin1', function () {
    return view('admin.crudAdmin');
});

//Departments
Route::get('/Departement', [DepartmentController::class, 'detail']);

Route::get('/departement/{slug}/detail', [DepartmentController::class, 'showDetail'])->name('departments.showDetail');

Route::get('/session-check', function () {
    return session()->all();
});

//News
Route::get('/programs/{program}', [ProgramsController::class, 'show'])->name('programs.show');


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProgramsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutUsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AuthController::class, 'showLogin'])->name('auth.showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['login.auth'])->group(function () {
    Route::resource('departments', DepartmentController::class);
    Route::resource('members', MemberController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('programs', ProgramsController::class);
});

Route::get('/AboutUs', function () {
    return view('aboutus');
});

Route::get('/Departement', function () {
    return view('departement');
});

Route::get('/Activity', function () {
    return view('activity');
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
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

//About Us
Route::get('/aboutus', [AboutUsController::class, 'index'])->name('aboutus');
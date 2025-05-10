<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProgramsController;

Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/Home', function () {
    return view('test');
});

Route::resource('departments', DepartmentController::class);
Route::resource('members', MemberController::class);
Route::resource('categories', CategoryController::class);
Route::resource('programs', ProgramsController::class);
// resource = create all routes

Route::get('/aboutUs', function () {
    return view('aboutus');
});

Route::get('/Departement', function () {
    return view('departement');
});

Route::get('/Program', function () {
    return view('program');
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

Route::get('/admin', function () {
    return view('admin.loginAdmin');
});

Route::get('/admin1', function () {
    return view('admin.crudAdmin');
});

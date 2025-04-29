<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProgramsController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/1', function () {
    return view('test');
});

Route::resource('departments', DepartmentController::class);
Route::resource('members', MemberController::class);
Route::resource('categories', CategoriesController::class);
Route::resource('programs', ProgramsController::class);
// resource = create all routes

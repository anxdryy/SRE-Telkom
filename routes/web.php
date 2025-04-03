<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/1', function () {
    return view('test');
});

Route::resource('departments', DepartmentController::class);
Route::resource('members', MemberController::class);

// resource = create all routes

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.loginAdmin');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // hardcoded credentials
        $validUsers = [
            'sreadmin' => 'adminsremautambahdata',
        ];

        $username = $request->input('username');
        $password = $request->input('password');

        if (isset($validUsers[$username]) && $validUsers[$username] === $password) {
            session(['authenticated' => true, 'username' => $username]);
            return redirect()->route('departments.index')
                ->with('success', 'Welcome back, ' . $username . '!');
        }

        return back()->withErrors(['login' => 'Invalid credentials']);
    }

    public function logout(): RedirectResponse
    {
        session()->forget(['authenticated', 'username']);
        return redirect()->route('auth.showLogin')
            ->with('success', 'You have been logged out successfully.');
    }
}

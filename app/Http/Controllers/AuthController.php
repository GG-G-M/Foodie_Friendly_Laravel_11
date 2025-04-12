<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login authentication
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    /**
     * Show registration page
     */
    public function showRegister()
    {
        return view('auth.register'); // Ensure this file exists in resources/views/auth/register.blade.php
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed', // 'confirmed' checks password_confirmation
            'role' => 'required|in:admin,customer',
        ], [
            'password.confirmed' => 'The passwords do not match.',
        ]);
    
        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
            ]);
    
            return redirect()->route('admin.user_management')
                             ->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating user: ' . $e->getMessage())
                         ->withInput();
        }
    }
    

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

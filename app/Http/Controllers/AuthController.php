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
            
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
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
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();  // Invalidates the session
        $request->session()->regenerateToken();  // Regenerates CSRF token
        
        return redirect()->route('login');
    }
}

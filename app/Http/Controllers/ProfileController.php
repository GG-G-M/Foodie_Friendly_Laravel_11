<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show(Request $request): View
    {
        return view('profile', [
            'user' => $request->user()
        ]);
    }
}
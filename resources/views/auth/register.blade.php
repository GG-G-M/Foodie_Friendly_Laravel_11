@extends('layouts.auth')

@section('title', 'Register')
@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 position-relative" 
    style="background: linear-gradient(to bottom, #D2B48C, #A67B5B);">
    
    <div class="position-absolute top-0 mt-4">
        <h1 class="display-3 fw-bold text-white text-center text-shadow">REGISTER</h1>
    </div>

    <div class="card p-4 shadow-lg border border-black" 
        style="width: 350px; border-radius: 15px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
        
    @if(session('error'))
        <p class="text-danger text-center">{{ session('error') }}</p>
    @endif
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
    

        <input type="hidden" name="role" value="customer">
    
        <div class="mb-3">
            <label class="form-label text-white">Name</label>
            <input type="text" name="name" class="form-control bg-dark text-white border-0" required>
        </div>
    
        <div class="mb-3">
            <label class="form-label text-white">Email</label>
            <input type="email" name="email" class="form-control bg-dark text-white border-0" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label text-white">Password</label>
            <input type="password" name="password" class="form-control bg-dark text-white border-0" required>
        </div>
    
        <div class="mb-3">
            <label class="form-label text-white">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-0" required>
        </div>
    
        <button type="submit" class="btn btn-success w-100">Create an Account</button>
    </form>
    

        <div class="text-center mt-2">
            <a href="{{ route('about') }}" class="btn btn-info w-100" style="border-radius: 5px; padding: 5px;">
                About Us 
            </a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-white">Already have an account? Log in</a>
        </div>

        <div class="text-center mt-2">
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-outline-light d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="40" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                        <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z"/>
                    </svg>
                </button>
                <button class="btn btn-outline-light d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="40" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
    
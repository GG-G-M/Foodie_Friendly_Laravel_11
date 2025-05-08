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

    </div>
</div>
@endsection
    
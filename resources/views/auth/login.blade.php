@extends('layouts.auth')

@section('title', 'Login')
@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 position-relative" 
    style="background: linear-gradient(to bottom, #D2B48C, #A67B5B);">
    <div class="position-absolute top-0 mt-4">
        <h1 class="display-3 fw-bold text-white text-center text-shadow">LOGIN</h1>
    </div>

    <div class="card p-4 shadow-lg border border-black" 
        style="width: 350px; border-radius: 15px; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
        
        @if(session('success'))
            <p class="text-success text-center">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p class="text-danger text-center">{{ $error }}</p>
            @endforeach
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
    
            <div class="mb-3">
                <label class="form-label text-white">Email</label>
                <input type="email" name="email" class="form-control bg-dark text-white border-0 @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback text-center">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-white border-0 @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback text-center">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success w-100">Log in</button>
        </form>
        <div class="text-center mt-2">
            <a href="{{ route('about') }}" class="btn btn-info w-100" style="border-radius: 5px; padding: 5px;">
                About Us 
            </a>
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="text-white">Register</a>
        </div>
    </div>
</div>
@endsection
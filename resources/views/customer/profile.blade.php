@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                <!-- Card Header with Gradient Background -->
                <div class="card-header py-3" style="background: linear-gradient(to right, #8B4513, #A67B5B);">
                    <h3 class="mb-0 text-white">
                        <i class="bi bi-person-circle me-2"></i>My Profile
                    </h3>
                </div>
                
                <!-- Card Body -->
                <div class="card-body" style="background-color: #F5F5DC;">
                    <!-- Profile Picture Section -->
                    <!-- <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=A67B5B&color=fff&size=128" 
                                 class="rounded-circle shadow border border-4 border-brown" 
                                 style="border-color: #8B4513 !important; width: 128px; height: 128px; object-fit: cover;">
                            <span class="position-absolute bottom-0 end-0 bg-brown rounded-circle p-2 border border-2 border-white">
                                <i class="bi bi-pencil-fill text-white"></i>
                            </span>
                        </div>
                    </div> -->

                    <!-- Profile Details -->
                    <div class="row g-3">
                        <!-- Name Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light-brown border-brown" id="name" 
                                       value="{{ $user->name }}" readonly>
                                <label for="name" class="text-brown">
                                    <i class="bi bi-person-fill me-2"></i>Full Name
                                </label>
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control bg-light-brown border-brown" id="email" 
                                       value="{{ $user->email }}" readonly>
                                <label for="email" class="text-brown">
                                    <i class="bi bi-envelope-fill me-2"></i>Email Address
                                </label>
                            </div>
                        </div>

                        <!-- Member Since Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light-brown border-brown" id="created_at" 
                                       value="{{ $user->created_at->format('F j, Y') }}" readonly>
                                <label for="created_at" class="text-brown">
                                    <i class="bi bi-calendar-check-fill me-2"></i>Member Since
                                </label>
                            </div>
                        </div>

                        <!-- Account Status Field -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light-brown border-brown" id="status" 
                                       value="Active" readonly>
                                <label for="status" class="text-brown">
                                    <i class="bi bi-shield-check me-2"></i>Account Status
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top border-brown">
                        <button class="btn btn-outline-brown">
                            <i class="bi bi-lock-fill me-2"></i>Change Password
                        </button>
                        <button class="btn btn-brown">
                            <i class="bi bi-pencil-fill me-2"></i>Edit Profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Brown Theme Colors */
    .bg-brown { background-color: #8B4513; }
    .bg-light-brown { background-color: #F5DEB3; }
    .border-brown { border-color: #A67B5B !important; }
    .text-brown { color: #5A3E36; }
    .btn-brown { 
        background-color: #A67B5B; 
        border-color: #8B4513;
        color: white;
    }
    .btn-brown:hover {
        background-color: #8B4513;
        border-color: #5A3E36;
        color: white;
    }
    .btn-outline-brown {
        border-color: #A67B5B;
        color: #5A3E36;
    }
    .btn-outline-brown:hover {
        background-color: #F5DEB3;
        border-color: #8B4513;
    }
</style>
@endsection
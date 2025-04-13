<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckRole;

// Redirect root ('/') to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (for guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Common Authenticated Routes (for all logged-in users)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

// Customer Routes
Route::middleware(['auth', CheckRole::class.':customer'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    
    // Cart routes
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');

    // Order tracker route
    Route::get('/tracker', function () {
        return view('view_tracker');
    })->name('tracker');
});

// Admin Routes
Route::middleware(['auth', CheckRole::class.':admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/user_management', [AdminController::class, 'userManagement'])->name('admin.user_management');
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');

   // Food Routes
   Route::get('/order-categories', [FoodController::class, 'index'])->name('admin.order_categories');
   Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
   Route::put('/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
   Route::delete('/foods/{food}', [FoodController::class, 'destroy'])->name('foods.destroy');
    
    // Order Menu Routes
    Route::get('/order-menu', [AdminController::class, 'orderMenu'])->name('admin.order_menu');
    Route::post('/order_menu/store', [AdminController::class, 'storeFood'])->name('admin.food.store');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
});

// Publicly accessible about page
Route::get('/about', function () {
    return view('about');
})->name('about');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\CartController; // Added
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RiderController;
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
Route::middleware(['auth', CheckRole::class . ':customer'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [FoodController::class, 'search'])->name('search');

    // Cart routes
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
    Route::post('/cart/add/{foodId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::get('/order-history', [CartController::class, 'orders'])->name('order-history');

    // Order tracker route
    Route::get('/tracker', function () {
        return view('customer.view_tracker');
    })->name('tracker');
});

// Admin Routes
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // User Management Routes
    Route::get('/user_management', [AdminController::class, 'userManagement'])->name('admin.user_management');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Rider Routes
    Route::prefix('riders')->group(function () {
        Route::get('/', [RiderController::class, 'index'])->name('admin.riders.index');
        Route::get('/create', [RiderController::class, 'create'])->name('admin.riders.create');
        Route::post('/', [RiderController::class, 'store'])->name('admin.riders.store');
        Route::get('/{rider}/edit', [RiderController::class, 'edit'])->name('admin.riders.edit');
        Route::put('/{rider}', [RiderController::class, 'update'])->name('admin.riders.update');
        Route::delete('/{rider}', [RiderController::class, 'destroy'])->name('admin.riders.destroy');
    });

    // Food Routes
    Route::get('/order-categories', [FoodController::class, 'index'])->name('admin.order_categories');
    Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
    Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('foods.edit');
    Route::put('/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
    Route::delete('/foods/{food}', [FoodController::class, 'destroy'])->name('foods.destroy');
    
    // Order Menu Routes
    Route::get('/order-menu', [OrderController::class, 'index'])->name('admin.order_menu');    Route::get('/orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('admin.orders.cancel');
    Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('admin.orders.complete');
    
    // Sales Report Routes
    Route::get('/sales_report', [SalesController::class, 'index'])->name('admin.sales_report');
    Route::post('/sales_report/filter', [SalesController::class, 'filter'])->name('admin.sales_report.filter');
});

// Publicly accessible about page
Route::get('/about', function () {
    return view('about');
})->name('about');
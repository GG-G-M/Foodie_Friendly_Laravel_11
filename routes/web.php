<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RiderController;
use App\Http\Controllers\Rider\RiderDashboardController;
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Root Route
|--------------------------------------------------------------------------
|
| Redirects the root URL (/) to the login page.
|
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|

*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
*/
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', CheckRole::class . ':customer'])->group(function () {
    Route::get('/home', [CartController::class, 'index'])->name('home');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
    Route::post('/cart/add/{foodId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/order-history', [CartController::class, 'orders'])->name('order-history');
    Route::get('/order/{id}', [CartController::class, 'viewOrder'])->name('order.view'); // Ensure this route is defined
    Route::post('/order/{id}/cancel', [CartController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/order/{id}/status', [CartController::class, 'getOrderStatus'])->name('order.status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // User Management
    Route::get('/user_management', [AdminController::class, 'userManagement'])->name('admin.user_management');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users', [AuthController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Rider Management (nested under /riders prefix)
    Route::prefix('riders')->group(function () {
        Route::get('/', [RiderController::class, 'index'])->name('admin.riders.index');
        Route::get('/create', [RiderController::class, 'create'])->name('admin.riders.create');
        Route::post('/', [RiderController::class, 'store'])->name('admin.riders.store');
        Route::get('/{rider}/edit', [RiderController::class, 'edit'])->name('admin.riders.edit');
        Route::put('/{rider}', [RiderController::class, 'update'])->name('admin.riders.update');
        Route::delete('/{rider}', [RiderController::class, 'destroy'])->name('admin.riders.destroy');
    });

    // Order Categories (Food Management)
    Route::get('/order-categories', [FoodController::class, 'index'])->name('admin.order_categories');
    Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
    Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('foods.edit');
    Route::put('/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
    Route::delete('/foods/{food}', [FoodController::class, 'destroy'])->name('foods.destroy');

    // Order Menu (Admin Order Management)
    Route::get('/order-menu', [OrderController::class, 'index'])->name('admin.order_menu');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('admin.orders.cancel');
    Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('admin.orders.complete');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update_status');
    Route::post('/orders/{order}/start-delivery', [OrderController::class, 'startDelivery'])->name('admin.orders.start_delivery');
    Route::post('/orders/{order}/complete-delivery', [OrderController::class, 'completeDelivery'])->name('admin.orders.complete_delivery');

    // Sales Report Routes (Fix for RouteNotFoundException)
    Route::get('/sales-report', [SalesController::class, 'index'])->name('admin.sales_report'); // Main sales report page
    Route::post('/sales-report/filter', [SalesController::class, 'filter'])->name('admin.sales_report.filter'); // Filter sales report by date
});

// Rider routes (protected by auth and rider role)
Route::middleware(['auth', CheckRole::class . ':rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/dashboard', [RiderController::class, 'index'])->name('index');
    Route::post('/start-delivery/{id}', [RiderController::class, 'startDelivery'])->name('startDelivery');
    Route::post('/complete-delivery/{id}', [RiderController::class, 'completeDelivery'])->name('completeDelivery');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| Routes accessible to all users, such as the about page.
|
*/
Route::get('/about', function () {
    return view('about');
})->name('about');
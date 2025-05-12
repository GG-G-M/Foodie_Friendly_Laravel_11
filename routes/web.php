<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.update-password');
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
    Route::get('/order/{id}', [CartController::class, 'viewOrder'])->name('order.view');
    Route::post('/order/{id}/cancel', [CartController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/order/{id}/status', [CartController::class, 'getOrderStatus'])->name('order.status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // User Management
    Route::get('/user_management', [AdminController::class, 'userManagement'])->name('admin.user_management');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/view', [AdminController::class, 'view'])->name('users.view');

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
    Route::get('/order-categories', [AdminController::class, 'OrderCategories'])->name('admin.order_categories');
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

    // Delivery Fee Management
    Route::get('/set-delivery-fee', [OrderController::class, 'setDeliveryFee'])->name('admin.set_delivery_fee');
    Route::post('/set-delivery-fee', [OrderController::class, 'updateDeliveryFee'])->name('admin.update_delivery_fee');

    // Sales Report Routes
    Route::get('/sales-report', [SalesController::class, 'index'])->name('admin.sales_report.index');
    Route::post('/sales-report/filter', [SalesController::class, 'filter'])->name('admin.sales_report.filter');
});

// Rider routes
Route::middleware(['auth', CheckRole::class . ':rider'])->prefix('rider')->name('rider.')->group(function () {
    // Redirect /dashboard to /index
    Route::get('/dashboard', function () {
        return redirect()->route('rider.index');
    })->name('dashboard');

    Route::get('/index', [RiderDashboardController::class, 'index'])->name('index');
    Route::get('/orders', [RiderDashboardController::class, 'orders'])->name('orders');
    Route::get('/my-deliveries', [RiderDashboardController::class, 'myDeliveries'])->name('my-deliveries');
    Route::get('/earnings', [RiderDashboardController::class, 'earnings'])->name('earnings');
    Route::get('/profile', [RiderDashboardController::class, 'profile'])->name('profile');

    Route::post('/start-delivery/{order}', [RiderDashboardController::class, 'startDelivery'])->name('startDelivery');
    Route::post('/finish-delivery/{order}', [RiderDashboardController::class, 'finishDelivery'])->name('finishDelivery');
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
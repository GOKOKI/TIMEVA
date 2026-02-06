<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;


// Home
Route::view('/', 'welcome')->name('home');

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Produits
Route::get('/watches', [ProductController::class, 'watches'])->name('products.watches');
Route::get('/glasses', [ProductController::class, 'glasses'])->name('products.glasses');
Route::get('/watches/{product}', [ProductController::class, 'watchesshow'])->name('product.watchesshow');
Route::get('/glasses/{product}', [ProductController::class, 'glassesshow'])->name('product.glassesshow');

// Panier
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add'); 
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'check'])->name('checkout');

// Utilisateur
Route::group([], function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/orders', [UserController::class, 'orders'])->name('profile.orders');
});

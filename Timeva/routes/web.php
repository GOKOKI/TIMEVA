<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;

// ========== PUBLIC ROUTES ==========
Route::view('/', 'welcome')->name('home');

// ========== GUEST ROUTES (non connectés) ==========
Route::middleware('guest')->group(function () {
    // Auth - Inscription
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    
    // Auth - Connexion
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Auth - Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('forgot');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.send');
});

// ========== AUTH ROUTES (connectés) ==========
Route::middleware('auth')->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ===== PROFIL UTILISATEUR =====
    Route::prefix('profile')->name('profile.')->controller(UserController::class)->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/', 'updateProfile')->name('update');
        Route::get('/orders', 'orders')->name('orders');
        Route::get('/orders/{order}', 'orderDetails')->name('orders.details');
    });
    
    // ===== PANIER & CHECKOUT =====
    Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add/{variant}', 'add')->name('add'); // variant_id au lieu de product
        Route::patch('/update/{variant}', 'update')->name('update'); // pour modifier quantité
        Route::delete('/remove/{variant}', 'remove')->name('remove');
        Route::delete('/clear', 'clear')->name('clear'); // vider le panier
    });
    
    // Checkout (nécessite panier non vide)
    Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/process', 'process')->name('process');
        Route::get('/success/{order}', 'success')->name('success');
        Route::get('/cancel', 'cancel')->name('cancel');
    });
});

// ========== PRODUCT ROUTES (publiques) ==========
Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
    // Catégories
    Route::get('/watches', 'watches')->name('watches');
    Route::get('/glasses', 'glasses')->name('glasses');
    
    // Détails produit (avec slug pour SEO)
    Route::get('/{product:slug}', 'show')->name('show');
});

// Fallback pour les anciennes URLs (redirection)
Route::get('/watches/{product}', function ($product) {
    return redirect()->route('products.show', $product);
})->name('product.watchesshow');

Route::get('/glasses/{product}', function ($product) {
    return redirect()->route('products.show', $product);
})->name('product.glassesshow');

// ========== ADMIN ROUTES ==========
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
//     Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
//     Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
//     Route::resource('users', App\Http\Controllers\Admin\UserController::class);
// });

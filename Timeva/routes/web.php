<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;

// ========== ROUTES PUBLIQUES (ACCUEIL) ==========
Route::view('/', 'welcome')->name('home');

// ========== ROUTES INVITES (NON CONNECTÉS) ==========
Route::middleware('guest')->group(function () {
    // Inscription
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    
    // Connexion
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Mot de passe oublié
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('forgot');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.send');
});

// ========== ROUTES AUTHENTIFIÉES (CONNECTÉS) ==========
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
    
    // ===== PANIER (CART) =====
    // On utilise {variant} car on ajoute une variante spécifique (couleur/taille)
    Route::prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/add/{variant}', 'add')->name('add'); 
        Route::patch('/update/{variant}', 'update')->name('update');
        Route::delete('/remove/{variant}', 'remove')->name('remove');
        Route::delete('/clear', 'clear')->name('clear');
    });
    
    // ===== PAIEMENT (CHECKOUT) =====
    Route::prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/process', 'process')->name('process');
        Route::get('/success/{order}', 'success')->name('success');
        Route::get('/cancel', 'cancel')->name('cancel');
    });
});

// ========== ROUTES PRODUITS (PUBLIQUES) ==========
Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
    // Liste par catégorie
    Route::get('/watches', 'watches')->name('watches');
    Route::get('/glasses', 'glasses')->name('glasses');
    
    // Détails produit : l'URL sera /products/nom-du-produit
    // Le ":slug" indique à Laravel de chercher dans la colonne slug de la DB
    Route::get('/{product:slug}', 'show')->name('show');
});

// ========== REDIRECTIONS SEO (ANCIENNES URLS) ==========
// Si quelqu'un essaie d'accéder à l'ancien format, on le renvoie vers la nouvelle fiche produit
Route::get('/watches/{slug}', function ($slug) {
    return redirect()->route('products.show', $slug);
});

Route::get('/glasses/{slug}', function ($slug) {
    return redirect()->route('products.show', $slug);
});

// ========== ADMIN ROUTES ==========
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
//     Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
//     Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
//     Route::resource('users', App\Http\Controllers\Admin\UserController::class);
// });

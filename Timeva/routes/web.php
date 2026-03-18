<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;

// ========== ROUTES PUBLIQUES (ACCUEIL) ==========
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ========== ROUTES INVITES (NON CONNECTÉS) ==========
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('forgot');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.send');
});

// ========== ROUTES AUTHENTIFIÉES (CONNECTÉS) ==========
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ===== PROFIL UTILISATEUR =====
    Route::prefix('profile')->name('profile.')->controller(UserController::class)->group(function () {
        Route::get('/', 'profile')->name('index');
        Route::put('/', 'updateProfile')->name('update');
        Route::get('/orders', 'orders')->name('orders');
        Route::get('/orders/{order}', 'orderDetails')->name('orders.details');
        Route::patch('/orders/{order}/cancel', 'cancelOrder')->name('orders.cancel');
    });

    // ===== PANIER (CART) =====
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
        Route::get('/fedapay/callback/{commande}', 'fedapayCallback')->name('fedapay.callback');
        Route::get('/success/{commande}', 'success')->name('success');
        Route::get('/cancel', 'cancel')->name('cancel');
    });
});

// ========== ROUTES PRODUITS (PUBLIQUES) ==========
Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
    Route::get('/watches', 'watches')->name('watches');
    Route::get('/glasses', 'glasses')->name('glasses');
    Route::get('/{product:slug}', 'show')->name('show');
});

// ========== COLLECTIONS ==========
Route::get('/collections', [App\Http\Controllers\CollectionController::class, 'index'])->name('collections');

// ========== PAGES STATIQUES ==========
Route::get('/contact', fn() => view('pages.contact'))->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
Route::view('/politique-de-confidentialite', 'pages.confidentialite')->name('pages.confidentialite');
Route::view('/conditions-generales', 'pages.conditions')->name('pages.conditions');
Route::view('/mentions-legales', 'pages.mentions-legales')->name('pages.mentions');

// ========== REDIRECTIONS SEO (ANCIENNES URLS) ==========
Route::get('/watches/{slug}', fn($slug) => redirect()->route('products.show', $slug));
Route::get('/glasses/{slug}', fn($slug) => redirect()->route('products.show', $slug));

// ========== ADMIN ==========
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Produits (CRUD + variantes)
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::post('products/{product}/variants', [App\Http\Controllers\Admin\ProductController::class, 'storeVariant'])
        ->name('products.variants.store');
    Route::delete('products/{product}/variants/{variant}', [App\Http\Controllers\Admin\ProductController::class, 'destroyVariant'])
        ->name('products.variants.destroy');

    // Commandes
    Route::get('commandes', [App\Http\Controllers\Admin\CommandeController::class, 'index'])->name('commandes.index');
    Route::get('commandes/{commande}', [App\Http\Controllers\Admin\CommandeController::class, 'show'])->name('commandes.show');
    Route::patch('commandes/{commande}/statut', [App\Http\Controllers\Admin\CommandeController::class, 'updateStatut'])->name('commandes.updateStatut');

    // Paiements
    Route::get('paiements', [App\Http\Controllers\Admin\PaiementController::class, 'index'])->name('paiements.index');
});

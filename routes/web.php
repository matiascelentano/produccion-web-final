<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');

// Solo accesibles si NO estás logueado
Route::middleware('guest')->group(function () {
    Route::get('/registro', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/registro', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Solo accesible si estás logueado
Route::middleware('auth')->group(function () {
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/carrito', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    
    Route::get('/mis-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/mis-pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/mis-direcciones', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/mis-direcciones', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/mis-direcciones/{address}', [AddressController::class, 'update'])->name('addresses.update');

    Route::get('/productos/{product}/checkout', [OrderController::class, 'checkoutSingle'])->name('orders.checkoutSingle');
    Route::post('/productos/{product}/comprar', [OrderController::class, 'storeSingle'])->name('orders.storeSingle');

    Route::get('/checkout', [OrderController::class, 'checkoutCart'])->name('orders.checkoutCart');
    Route::post('/checkout', [OrderController::class, 'storeFromCart'])->name('orders.storeFromCart');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::delete('product-images/{image}', [AdminProductController::class, 'destroyImage'])->name('product-images.destroy');

    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('brands', AdminBrandController::class)->except(['show']);

    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});

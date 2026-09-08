<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CartController;
use App\Models\Product;
use App\Models\categories as Category;
use Illuminate\Support\Facades\Auth;

// --- 1. ROUTE HOME (Sudah diberi nama 'home') ---
Route::get('/', function () {
    $products = Product::all();
    $categories = Category::all();

    $recommendations = collect();
    if (Auth::check()) {
        $service = new \App\Services\RecommendationService();
        $recommendations = $service->getRecommendations(Auth::id());
    }

    return view('welcome', compact('products', 'recommendations', 'categories'));
})->name('home');

Route::get('/viewproduct', function () {
    $products = Product::all();
    $categories = Category::all();

    return view('viewproduct', compact('products', 'categories'));
})->name('viewproduct');

// --- 2. ROUTE CATEGORIES ---
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// --- 3. ROUTE PRODUCT DETAIL ---
Route::get('/product/{id}', function ($id) {
    $product = Product::with(['category', 'variants'])->findOrFail($id);
    return view('product_detail', compact('product'));
})->name('product.detail');

// --- 4. ROUTE SEARCH ---
Route::get('/search', [ProductController::class, 'search'])->name('product.search');

// --- 5. ROUTE CART & ORDERS ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');

Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');

// --- 6. ROUTE ADMIN & REFUNDS ---
Route::middleware('auth')->group(function () {
    Route::post('/admin/return/{id}/approve', function ($id) {
        $return = \App\Models\ReturnModel::with('orderItem')->findOrFail($id);
        $return->update(['status' => 'approved']);

        $alreadyRefunded = \App\Models\Refund::where('return_id', $return->id)->exists();
        if (!$alreadyRefunded) {
            \App\Models\Refund::create([
                'return_id'   => $return->id,
                'order_id'    => $return->orderItem->order_id,
                'amount'      => $return->orderItem->price,
                'status'      => 'pending',
                'refunded_at' => null,
            ]);
        }

        return response()->json(['success' => true]);
    })->name('admin.return.approve');

    Route::get('/product/{id}', function ($id) {
        $product = Product::with(['category', 'variants'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->findOrFail($id);
        return view('product_detail', compact('product'));
    })->name('product.detail');

    Route::post('/admin/return/{id}/reject', function ($id) {
        $return = \App\Models\ReturnModel::findOrFail($id);
        $return->update(['status' => 'rejected']);
        return response()->json(['success' => true]);
    })->name('admin.return.reject');

    Route::post('/admin/refund/{id}/complete', function ($id) {
        $refund = \App\Models\Refund::findOrFail($id);
        $refund->update([
            'status'      => 'completed',
            'refunded_at' => now(),
        ]);
        return response()->json(['success' => true]);
    })->name('admin.refund.complete');
});

// --- 7. ROUTE AUTHENTICATION ---
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
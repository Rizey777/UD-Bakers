<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menus (CRUD)
    Route::prefix('menus')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menus.index');
        Route::get('/create', [MenuController::class, 'create'])->name('menus.create');
        Route::post('/', [MenuController::class, 'store'])->name('menus.store');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
    });

    // Orders
    Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::post('/add/{menu_id}', [OrderController::class, 'addToCart'])->name('order.add');
    
    Route::get('/{order}/items', [OrderItemController::class, 'index'])->name('order.items');
    Route::post('/{order}/items', [OrderItemController::class, 'store'])->name('order.items.store');
    Route::delete('/{order}/items/{item}', [OrderItemController::class, 'destroy'])->name('order.items.destroy');

    Route::get('/{order}/confirm', [OrderController::class, 'confirm'])->name('order.confirm');
    

    // Hanya 1 route untuk success, GET dengan parameter order
//    Route::post('orders/success/{order}', [OrderController::class, 'success'])->name('order.success');
Route::post('/order/{order}/success', [OrderController::class, 'success'])->name('order.success');

Route::post('/order/{menu}/add-to-cart', [OrderController::class, 'addToCart'])->name('order.addToCart');



    // Route tambahan lain
    Route::post('/add-item', [OrderController::class, 'addItem'])->name('order.addItem');

    // Riwayat pesanan
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
   Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');


    Route::put('{order}/items/{item}', [OrderController::class, 'updateItem'])->name('order.items.update');
    Route::delete('{order}/items/{item}', [OrderController::class, 'destroyItem'])->name('order.items.destroy');
    Route::get('/history/download-pdf', [HistoryController::class, 'downloadPdf'])->name('history.downloadPdf');

    Route::get('/generate-order-codes', [OrderController::class, 'generateOrderCodes']);
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

    // routes/web.php
Route::post('/buyer/save', [OrderController::class, 'saveBuyerName'])->name('buyer.save');



    });
});

require __DIR__.'/auth.php';

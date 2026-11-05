<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BestCustomerController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect halaman awal ke halaman menu publik
Route::get('/', function () {
    return redirect('/menu-pelanggan');
});

// Route untuk Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk Self-Service Ordering (Public, tanpa login)
Route::get('/menu-pelanggan', [OrderController::class, 'indexPublic'])->name('menu.public');
Route::post('/cart/add/{menu}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{menuId}', [OrderController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{menuId}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear', [OrderController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart', [OrderController::class, 'viewCart'])->name('cart.view');
Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('order.checkout');
Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('order.processCheckout');
Route::get('/order/{order}/payment', [OrderController::class, 'showPayment'])->name('order.payment');

// Route untuk Pembayaran Midtrans
Route::get('/payment/{order}/snap', [\App\Http\Controllers\PembayaranController::class, 'createSnapToken'])->name('pembayaran.snap');
Route::post('/payment/callback', [\App\Http\Controllers\PembayaranController::class, 'webhookCallback'])->name('pembayaran.callback');
Route::get('/payment/finish', [\App\Http\Controllers\PembayaranController::class, 'finishPayment'])->name('pembayaran.finish');
Route::get('/order/{id}/success', [\App\Http\Controllers\PembayaranController::class, 'finishPayment'])->name('order.success');
Route::get('/order/{id}/pending', [\App\Http\Controllers\PembayaranController::class, 'finishPayment'])->name('order.pending');

// Route untuk Pembayaran Tunai
Route::post('/payment/{order}/cash', [\App\Http\Controllers\PembayaranController::class, 'processCash'])->name('pembayaran.cash');

// Route-route yang memerlukan otentikasi
Route::middleware(['auth'])->group(function () {
    // Route Dashboard Utama
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Route Dashboard Kasir - Pesanan masuk & Pesan Manual
    Route::get('/kasir/pesanan', [\App\Http\Controllers\OrderListController::class, 'kasirDashboard'])->name('kasir.pesanan');
    Route::get('/kasir/pesan-manual', [\App\Http\Controllers\OrderListController::class, 'createManual'])->name('kasir.pesanan.manual');
    Route::post('/kasir/pesan-manual', [\App\Http\Controllers\OrderListController::class, 'storeManual'])->name('kasir.pesanan.manual.store');
    Route::post('/pesanan/{order}/status', [\App\Http\Controllers\OrderListController::class, 'updateStatus'])->name('order.updateStatus');
    Route::post('/pesanan/{order}/confirm-cash', [\App\Http\Controllers\PembayaranController::class, 'confirmCash'])->name('order.confirmCash');
    Route::get('/pesanan/{order}', [\App\Http\Controllers\OrderListController::class, 'show'])->name('order.show');
    Route::get('/pesanan/{order}/print', [\App\Http\Controllers\OrderListController::class, 'print'])->name('order.print');

    // Route Dashboard Pemilik - Laporan Pendapatan
    Route::get('/pemilik/dashboard', [\App\Http\Controllers\RevenueController::class, 'dashboard'])->name('pemilik.dashboard');
    Route::get('/pemilik/laporan/export', [\App\Http\Controllers\RevenueController::class, 'exportReport'])->name('pemilik.export');

    // Route Pelanggan Terbaik - Untuk Admin Kasir dan Pemilik
    Route::middleware('auth')->group(function () {
        Route::get('/best-customer', [BestCustomerController::class, 'index'])->name('best-customer.index');
        Route::get('/best-customer/export/csv', [BestCustomerController::class, 'export'])->name('best-customer.export');
        Route::get('/best-customer/export/pdf', [BestCustomerController::class, 'exportPdf'])->name('best-customer.export-pdf');
        Route::get('/best-customer/{customerName}', [BestCustomerController::class, 'show'])->name('best-customer.show');
    });

    // Route Resource untuk Manajemen Menu
    Route::resource('menu', MenuController::class)->middleware('can:admin');

    // Route Resource untuk Manajemen Kategori
    Route::resource('kategori', KategoriController::class)->middleware('can:admin');

    // Route Resource untuk Manajemen User (Hanya Admin)
    Route::resource('user', UserController::class)->middleware('can:admin');
});

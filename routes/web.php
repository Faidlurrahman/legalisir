<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegalisirController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminAuthController;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [LegalisirController::class, 'dashboard'])->name('dashboard');

// Form input legalisir
Route::get('/admin/formLegalisir', [LegalisirController::class, 'formLegalisir'])->name('formLegalisir');

// Proses simpan legalisir
Route::post('/admin/formLegalisir/store', [LegalisirController::class, 'store'])->name('formLegalisir.store');

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protect admin routes
Route::group(['middleware' => 'web'], function () {
    Route::get('/admin/dashboard', [LegalisirController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/data', function() {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\LegalisirController::class)->data(request());
    })->name('admin.data');
    Route::get('/admin/data/{id}/edit', function($id) {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\LegalisirController::class)->edit($id);
    })->name('admin.data.edit');
    Route::put('/admin/data/{id}', function($id) {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\LegalisirController::class)->update(request(), $id);
    })->name('admin.data.update');
    Route::delete('/admin/data/{id}', function($id) {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\LegalisirController::class)->delete($id);
    })->name('admin.data.delete');
    Route::post('/admin/data/{id}/selesai', [LegalisirController::class, 'setSelesai'])->name('admin.data.selesai');
    Route::post('/admin/data/{id}/toggle-status', [LegalisirController::class, 'toggleStatus'])->name('admin.data.toggleStatus');

    // Mark as finished (set status and finished_at)
    Route::post('/admin/data/{id}/finish', function($id) {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\LegalisirController::class)->finish(request(), $id);
    })->name('admin.data.finish');

    // Profile routes (tambahkan di bawah, masih dalam group)
    Route::get('/admin/profile', function() {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\AdminProfileController::class)->show(request());
    })->name('admin.profile');

    Route::put('/admin/profile', function() {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\AdminProfileController::class)->update(request());
    })->name('admin.profile.update');

    // Laporan Legalisir
    Route::get('/admin/laporan', function() {
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }
        return app(\App\Http\Controllers\LegalisirController::class)->laporan(request());
    })->name('admin.laporan');
});


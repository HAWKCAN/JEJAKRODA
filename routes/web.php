<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PolicyPublicController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\Manager\ManagerVehicleController;
use App\Http\Controllers\Manager\ManagerBookingController;
use App\Http\Controllers\Manager\ManagerReportController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\PolicyController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\SuperAdmin\SuperAdminBackupController;
use App\Http\Controllers\SuperAdmin\SuperAdminLogController;

// PUBLIK 
Route::get('/', [HomeController::class, 'index']);
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
Route::get('/policies', [PolicyPublicController::class, 'index']);
Route::get('/policies/{slug}', [PolicyPublicController::class, 'show']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);

// AUTH 
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// USER
Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    });
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/bookings/create/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/history', [BookingController::class, 'history'])->name('booking.history'); // history sebelum {id}
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::get('/payments/create', [PaymentController::class, 'create']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::post('/reviews', [ReviewController::class, 'store']);
});

// MANAGER
Route::middleware(['auth', 'isManager'])->prefix('manager')->group(function () {
    Route::get('/dashboard', function () {
        return view('manager.dashboard');
    });
    Route::resource('vehicles', ManagerVehicleController::class);
    Route::get('bookings', [ManagerBookingController::class, 'index']);
    Route::get('bookings/{id}', [ManagerBookingController::class, 'show']);
    Route::patch('bookings/{id}/confirm', [ManagerBookingController::class, 'confirm']);
    Route::patch('bookings/{id}/reject', [ManagerBookingController::class, 'reject']);
    Route::get('returns/create', [ReturnController::class, 'create']);
    Route::post('returns', [ReturnController::class, 'store']);
    Route::get('reports', [ManagerReportController::class, 'index']);
    Route::get('reports/export', [ManagerReportController::class, 'export']);
});

// SUPER ADMIN 
Route::middleware(['auth', 'isSuperAdmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
    ->name('superadmin.dashboard');
    Route::get('users', [SuperAdminUserController::class, 'index']);
    Route::get('users/{id}', [SuperAdminUserController::class, 'show']);
    Route::delete('users/{id}', [SuperAdminUserController::class, 'destroy']);
    Route::patch('users/{id}/verify', [SuperAdminUserController::class, 'verifyManager']);
    Route::resource('policies', PolicyController::class);
    Route::get('settings', [SettingController::class, 'index']);
    Route::patch('settings', [SettingController::class, 'update']);
    Route::get('backup', [SuperAdminBackupController::class, 'index']);
    Route::post('backup', [SuperAdminBackupController::class, 'run']);
    Route::get('logs', [SuperAdminLogController::class, 'index']);
});
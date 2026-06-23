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
use App\Http\Controllers\Manager\ReturnController;
use App\Http\Controllers\Manager\ManagerVehicleController;
use App\Http\Controllers\Manager\ManagerBookingController;
use App\Http\Controllers\Manager\ManagerReportController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\PolicyController;
use App\Http\Controllers\SuperAdmin\SettingController;
use App\Http\Controllers\SuperAdmin\SuperAdminBackupController;
use App\Http\Controllers\SuperAdmin\SuperAdminLogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Manager\ManagerVerificationController;
use App\Http\Controllers\Manager\ManagerSettingController;
use App\Http\Controllers\Manager\ManagerDashboardController;
// use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;

// ─── PUBLIK ─────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
// Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/policies', [PolicyPublicController::class, 'index'])->name('policies.index');
Route::get('/policies/{slug}', [PolicyPublicController::class, 'show'])->name('policies.show');
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);

// ─── AUTH ───────────────────────────────────────────────────────
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');

// ─── USER ───────────────────────────────────────────────────────
Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/bookings/create/{vehicle}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/payments/{booking}/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments/{booking}', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/reviews/{booking}', [ReviewController::class, 'store'])->name('reviews.store');
});

// ─── MANAGER ────────────────────────────────────────────────────
Route::middleware(['auth', 'isManager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('vehicles', ManagerVehicleController::class)->except(['show']);
    Route::patch('vehicles/{vehicle}/toggle-status', [ManagerVehicleController::class, 'toggleStatus'])->name('vehicles.toggleStatus');
    Route::get('/bookings', [ManagerBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [ManagerBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/confirm', [ManagerBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/reject', [ManagerBookingController::class, 'reject'])->name('bookings.reject');
    Route::post('/bookings/{booking}/verify-payment', [ManagerBookingController::class, 'verifyPayment'])->name('bookings.verifyPayment');
    Route::get('/returns/{booking}/create', [ReturnController::class, 'create'])->name('returns.create');
    Route::post('/returns/{booking}', [ReturnController::class, 'store'])->name('returns.store');
    Route::get('settings', [ManagerSettingController::class, 'index'])->name('settings.index');
    Route::patch('settings', [ManagerSettingController::class, 'update'])->name('settings.update');
    Route::get('/reports', [ManagerReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ManagerReportController::class, 'export'])->name('reports.export');
    Route::get('/verification', [ManagerVerificationController::class, 'edit'])->name('verification.edit');
    Route::post('/verification', [ManagerVerificationController::class, 'update'])->name('verification.update');
});

// ─── SUPER ADMIN ────────────────────────────────────────────────
Route::middleware(['auth', 'isSuperAdmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('users', [SuperAdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{id}', [SuperAdminUserController::class, 'show'])->name('users.show');
    Route::delete('users/{id}', [SuperAdminUserController::class, 'destroy'])->name('users.destroy');
    Route::patch('users/{id}/verify', [SuperAdminUserController::class, 'verifyManager'])->name('users.verify');

    Route::resource('policies', PolicyController::class);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('backup', [SuperAdminBackupController::class, 'index'])->name('backup.index');
    Route::post('backup', [SuperAdminBackupController::class, 'run'])->name('backup.run');
    Route::get('/backup/download/{filename}', [SuperAdminBackupController::class, 'download'])->name('backup.download');
    Route::delete('/backup/{filename}', [SuperAdminBackupController::class, 'destroy'])->name('backup.destroy');

    Route::get('logs', [SuperAdminLogController::class, 'index'])->name('logs.index');
});
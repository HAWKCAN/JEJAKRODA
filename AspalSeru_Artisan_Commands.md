# Aspal Seru — Artisan Commands
> Jalankan semua command ini dari root project Laravel.
> Urutan penting: Migration → Model → Controller → Request → Middleware

---

## ⚙️ SETUP AWAL

```bash
composer require maatwebsite/excel
composer require spatie/laravel-backup
composer require spatie/laravel-activitylog
composer require intervention/image
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan storage:link
```

---

## 📦 ANGGOTA 1 — Auth, Role, User & SOP

### Migration
```bash
php artisan make:migration create_users_table
php artisan make:migration add_role_phone_to_users_table
php artisan make:migration create_rental_owners_table
php artisan make:migration create_super_admin_settings_table
php artisan make:migration create_platform_policies_table
```

### Model
```bash
php artisan make:model User
php artisan make:model RentalOwner
php artisan make:model SuperAdminSetting
php artisan make:model PlatformPolicy
```

### Controller
```bash
php artisan make:controller AuthController
php artisan make:controller ProfileController
php artisan make:controller SuperAdmin/SuperAdminUserController
php artisan make:controller SuperAdmin/PolicyController
php artisan make:controller SuperAdmin/SettingController
```

### Request
```bash
php artisan make:request RegisterRequest
php artisan make:request LoginRequest
php artisan make:request PolicyRequest
php artisan make:request SettingRequest
```

### Middleware
```bash
php artisan make:middleware CheckRole
php artisan make:middleware IsSuperAdmin
php artisan make:middleware IsManager
```

### Notification
```bash
php artisan make:notification BookingNotification
php artisan make:notification PaymentNotification
php artisan make:notification ReturnNotification
```

---

## 🚗 ANGGOTA 2 — Katalog, Armada & Dashboard

### Migration
```bash
php artisan make:migration create_vehicles_table
php artisan make:migration create_reviews_table
```

### Model
```bash
php artisan make:model Vehicle
php artisan make:model Review
```

### Controller
```bash
php artisan make:controller VehicleController
php artisan make:controller ReviewController
php artisan make:controller Manager/ManagerVehicleController
php artisan make:controller SuperAdmin/SuperAdminDashboardController
```

### Request
```bash
php artisan make:request VehicleRequest
php artisan make:request ReviewRequest
```

---

## 📋 ANGGOTA 3 — Pemesanan, Pembayaran & Laporan

### Migration
```bash
php artisan make:migration create_bookings_table
php artisan make:migration create_payments_table
php artisan make:migration create_platform_fees_table
php artisan make:migration create_return_logs_table
```

### Model
```bash
php artisan make:model Booking
php artisan make:model Payment
php artisan make:model PlatformFee
php artisan make:model ReturnLog
```

### Controller
```bash
php artisan make:controller BookingController
php artisan make:controller PaymentController
php artisan make:controller ReturnController
php artisan make:controller Manager/ManagerBookingController
php artisan make:controller Manager/ManagerReportController
php artisan make:controller SuperAdmin/SuperAdminBackupController
```

### Request
```bash
php artisan make:request BookingRequest
php artisan make:request PaymentRequest
php artisan make:request ReturnRequest
```

---

## 📄 ANGGOTA 4 — Halaman Statis & Log

### Controller
```bash
php artisan make:controller HomeController
php artisan make:controller PageController
php artisan make:controller PolicyPublicController
php artisan make:controller SuperAdmin/SuperAdminLogController
```

---

## 🗄️ JALANKAN MIGRATION

```bash
php artisan migrate
```

### Kalau mau reset & isi ulang dengan data dummy:
```bash
php artisan migrate:fresh --seed
```

---

## 📁 Struktur Folder Views (buat manual)

```
resources/views/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── profile/
│   ├── show.blade.php
│   └── edit.blade.php
├── vehicles/
│   ├── index.blade.php
│   └── show.blade.php
├── bookings/
│   ├── create.blade.php
│   ├── show.blade.php
│   └── history.blade.php
├── payments/
│   └── create.blade.php
├── policies/
│   ├── index.blade.php
│   └── show.blade.php
├── pages/
│   ├── about.blade.php
│   └── contact.blade.php
├── manager/
│   ├── vehicles/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── bookings/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── returns/
│   │   └── create.blade.php
│   └── reports/
│       └── index.blade.php
└── superadmin/
    ├── dashboard.blade.php
    ├── users/
    │   └── index.blade.php
    ├── policies/
    │   └── index.blade.php
    ├── settings/
    │   └── index.blade.php
    ├── backup/
    │   └── index.blade.php
    └── logs/
        └── index.blade.php
```

---

## 🗺️ Tambah Middleware ke Kernel

Di `app/Http/Kernel.php`, tambahkan di `$routeMiddleware`:

```php
'checkRole'    => \App\Http\Middleware\CheckRole::class,
'isSuperAdmin' => \App\Http\Middleware\IsSuperAdmin::class,
'isManager'    => \App\Http\Middleware\IsManager::class,
```

---

## 📐 Kolom Migration — camelCase ke snake_case

> Laravel secara konvensi pakai **snake_case** untuk nama kolom di database,
> tapi variabel di PHP/Blade tetap pakai **camelCase**.
> Gunakan `$casts` dan accessor di Model untuk konversi otomatis.

| camelCase (PHP/Blade) | snake_case (Database) |
|---|---|
| `passwordHash` | `password_hash` |
| `phoneNumber` | `phone_number` |
| `rentalOwnerId` | `rental_owner_id` |
| `businessName` | `business_name` |
| `businessAddress` | `business_address` |
| `taxNumber` | `tax_number` |
| `verificationStatus` | `verification_status` |
| `plateNumber` | `plate_number` |
| `pricePerDay` | `price_per_day` |
| `imageUrl` | `image_url` |
| `startDate` | `start_date` |
| `endDate` | `end_date` |
| `totalDays` | `total_days` |
| `platformFeeAmount` | `platform_fee_amount` |
| `totalPrice` | `total_price` |
| `proofUrl` | `proof_url` |
| `paidAt` | `paid_at` |
| `feePercent` | `fee_percent` |
| `feeAmount` | `fee_amount` |
| `disbursedStatus` | `disbursed_status` |
| `returnedAt` | `returned_at` |
| `lateFee` | `late_fee` |
| `isActive` | `is_active` |
| `createdAt` | `created_at` |
| `updatedAt` | `updated_at` |

### Cara pakai di Model agar otomatis camelCase di PHP:

```php
// app/Models/Booking.php
protected $fillable = [
    'user_id',
    'vehicle_id',
    'start_date',
    'end_date',
    'total_days',
    'subtotal',
    'platform_fee_amount',
    'total_price',
    'status',
    'notes',
];

// Akses di Blade tetap snake_case via $booking->start_date
// atau buat accessor camelCase:
public function getStartDateAttribute($value)
{
    return $value; // bisa diformat di sini
}
```

---

## 🔗 Ringkasan Route Group (routes/web.php)

```php
// Publik
Route::get('/', [HomeController::class, 'index']);
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
Route::get('/policies', [PolicyPublicController::class, 'index']);
Route::get('/policies/{slug}', [PolicyPublicController::class, 'show']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);

// Auth
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'store']);
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);

// User
Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::get('/bookings/create', [BookingController::class, 'create']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::get('/bookings/history', [BookingController::class, 'history']);
    Route::get('/payments/create', [PaymentController::class, 'create']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::post('/reviews', [ReviewController::class, 'store']);
});

// Manager
Route::middleware(['auth', 'isManager'])->prefix('manager')->group(function () {
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

// Super Admin
Route::middleware(['auth', 'isSuperAdmin'])->prefix('superadmin')->group(function () {
    Route::get('dashboard', [SuperAdminDashboardController::class, 'index']);
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
```

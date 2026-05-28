

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
ssh -p 443 -R0:localhost:3306 tcp@a.pinggy.io

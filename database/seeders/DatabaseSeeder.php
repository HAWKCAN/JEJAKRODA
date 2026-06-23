<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Superadmin (Wajib 'superAdmin' sesuai ENUM database)
        User::create([
            'name' => 'Super Admin Aspal',
            'email' => 'superadmin@aspalseru.com',
            'password' => Hash::make('password123'),
            'role' => 'superAdmin',
        ]);

        // 2. Akun Manager
        User::create([
            'name' => 'Manager Toko',
            'email' => 'manager@aspalseru.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);

        // 3. Akun User Biasa
        User::create([
            'name' => 'Budi User',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->call([
            VehicleSeeder::class,
        ]);
    }
}
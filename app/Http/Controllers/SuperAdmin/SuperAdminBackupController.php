<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SuperAdminBackupController extends Controller
{
    /**
     * Halaman manajemen backup.
     */
    public function index()
    {
        return view('superadmin.backup.index');
    }

    /**
     * Jalankan backup database secara manual.
     */
    public function run()
    {
        try {
            // --only-db agar hanya backup database, bukan seluruh file project
            Artisan::call('backup:run', ['--only-db' => true]);

            return back()->with('success', 'Backup database berhasil dijalankan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }
}
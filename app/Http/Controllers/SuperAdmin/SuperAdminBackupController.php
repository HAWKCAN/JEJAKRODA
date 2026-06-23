<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\NativeBackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperAdminBackupController extends Controller
{
    protected NativeBackupService $backupService;

    public function __construct(NativeBackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    /**
     * Halaman manajemen backup.
     */
    public function index()
    {
        $backups = $this->backupService->list();

        return view('superadmin.backup.index', compact('backups'));
    }

    /**
     * Jalankan backup database secara manual (native PHP, tanpa shell exec).
     */
    public function run()
    {
        try {
            $filename = $this->backupService->run();

            return redirect()->route('superAdmin.backup.index')
                ->with('success', "Backup berhasil dibuat: {$filename}");

        } catch (\Exception $e) {
            return redirect()->route('superAdmin.backup.index')
                ->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    /**
     * Download file backup tertentu.
     */
    public function download(string $filename)
    {
        $path = 'backups/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File backup tidak ditemukan.');
        }

        return Storage::disk('local')->download($path);
    }

    /**
     * Hapus file backup tertentu.
     */
    public function destroy(string $filename)
    {
        $deleted = $this->backupService->delete($filename);

        if ($deleted) {
            return redirect()->route('superAdmin.backup.index')
                ->with('success', "Backup {$filename} berhasil dihapus.");
        }

        return redirect()->route('superAdmin.backup.index')
            ->with('error', 'File backup tidak ditemukan.');
    }
}
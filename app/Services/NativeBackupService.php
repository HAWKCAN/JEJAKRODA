<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NativeBackupService
{
    /**
     * Backup seluruh database ke file .sql murni pakai PDO,
     * tanpa proc_open/exec/shell_exec (untuk shared hosting yang membatasi itu).
     */
    public function run(): string
    {
        $database = DB::connection()->getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . $database;

        $sql = "-- Backup Database: {$database}\n";
        $sql .= "-- Generated: " . now()->format('Y-m-d H:i:s') . "\n";
        $sql .= "-- Method: Native PHP (PDO), no shell exec\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $tableRow) {
            $tableName = $tableRow->$tableKey;

            // ── Struktur tabel ──
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $createStatement = $createTable[0]->{'Create Table'};

            $sql .= "-- --------------------------------------------------------\n";
            $sql .= "-- Table structure for `{$tableName}`\n";
            $sql .= "-- --------------------------------------------------------\n\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createStatement . ";\n\n";

            // ── Data tabel (chunk agar tidak boros memori) ──
            $rowCount = DB::table($tableName)->count();

            if ($rowCount > 0) {
                $sql .= "-- Data for `{$tableName}`\n\n";

                DB::table($tableName)->orderBy(DB::raw('1'))->chunk(500, function ($rows) use (&$sql, $tableName) {
                    foreach ($rows as $row) {
                        $rowArray = (array) $row;
                        $columns = array_map(fn($col) => "`{$col}`", array_keys($rowArray));
                        $values = array_map(function ($value) {
                            if (is_null($value)) {
                                return 'NULL';
                            }
                            return DB::connection()->getPdo()->quote((string) $value);
                        }, array_values($rowArray));

                        $sql .= "INSERT INTO `{$tableName}` (" . implode(', ', $columns) . ") VALUES ("
                              . implode(', ', $values) . ");\n";
                    }
                });

                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        // ── Simpan ke storage/app/backups/ ──
        $filename = 'backup-' . Carbon::now()->format('Y-m-d-His') . '.sql';
        Storage::disk('local')->put('backups/' . $filename, $sql);

        return $filename;
    }

    /**
     * Daftar semua file backup yang tersimpan, terbaru di atas.
     */
    public function list(): array
    {
        $disk = Storage::disk('local');

        if (!$disk->exists('backups')) {
            return [];
        }

        $files = $disk->files('backups');
        $backups = [];

        foreach ($files as $file) {
            if (str_ends_with($file, '.sql')) {
                $backups[] = [
                    'filename' => basename($file),
                    'path'     => $file,
                    'size'     => $this->formatBytes($disk->size($file)),
                    'date'     => Carbon::createFromTimestamp($disk->lastModified($file))->format('d M Y, H:i'),
                    'timestamp'=> $disk->lastModified($file),
                ];
            }
        }

        usort($backups, fn($a, $b) => $b['timestamp'] - $a['timestamp']);

        return $backups;
    }

    /**
     * Hapus file backup tertentu.
     */
    public function delete(string $filename): bool
    {
        $path = 'backups/' . $filename;

        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->delete($path);
        }

        return false;
    }

    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
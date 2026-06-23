<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PlatformFee;
use App\Models\User;
use App\Models\RentalOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        // ── 1. Kartu Metrik Utama ──────────────────────────────────────────
        $totalTransaksi = Booking::whereIn('status', ['confirmed', 'completed'])->count();

        $totalFee = PlatformFee::whereHas('payment', function ($q) {
            $q->where('status', 'verified');
        })->sum('fee_amount');

        $totalRevenuePlatform = Payment::where('status', 'verified')->sum('amount');

        $totalManager = User::where('role', 'manager')->count();

        // ── 2. Grafik Fee Bulanan (12 bulan terakhir) ─────────────────────
        $feePerBulan = PlatformFee::select(
                DB::raw('YEAR(created_at)  as tahun'),
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(fee_amount)   as total')
            )
            ->whereHas('payment', fn($q) => $q->where('status', 'verified'))
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Isi 12 slot bulan, nilai 0 kalau kosong
        $bulanLabels = [];
        $feeData     = [];
        for ($i = 11; $i >= 0; $i--) {
            $tanggal     = now()->subMonths($i);
            $bulanLabels[] = $tanggal->translatedFormat('M Y');
            $key         = $tanggal->year . '-' . $tanggal->month;
            $row         = $feePerBulan->first(
                fn($r) => $r->tahun == $tanggal->year && $r->bulan == $tanggal->month
            );
            $feeData[] = $row ? (float) $row->total : 0;
        }

        // ── 3. Tabel Disbursement per Manager ────────────────────────────
        $tabelManager = RentalOwner::with('user')
            ->withCount('vehicles')
            ->get()
            ->map(function ($owner) {
                $totalBooking = Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $owner->id))
                    ->whereIn('status', ['confirmed', 'completed'])
                    ->count();

                $totalFeeOwner = PlatformFee::whereHas('payment', fn($q) => $q->where('status', 'verified'))
                    ->whereHas('payment.booking.vehicle', fn($q) => $q->where('rental_owner_id', $owner->id))
                    ->sum('fee_amount');

                $totalPendapatanOwner = Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $owner->id))
                    ->whereHas('payment', fn($q) => $q->where('status', 'verified'))
                    ->selectRaw('SUM(subtotal - platform_fee_amount) as net')
                    ->value('net') ?? 0;

                return [
                    'id'                  => $owner->id,
                    'nama'                => $owner->user->name ?? '-',
                    'bisnis'              => $owner->business_name,
                    'status'              => $owner->verification_status,
                    'total_kendaraan'     => $owner->vehicles_count,
                    'total_booking'       => $totalBooking,
                    'total_fee'           => $totalFeeOwner,
                    'total_pendapatan'    => $totalPendapatanOwner,
                ];
            });
        // ── 4. Transaksi Terbaru ──────────────────────────────────────────
        $transaksiTerbaru = Booking::with(['user', 'vehicle', 'payment'])
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->latest()
            ->take(8)
            ->get();

        return view('superadmin.dashboard', compact(
            'totalTransaksi',
            'totalFee',
            'totalRevenuePlatform',
            'totalManager',
            'bulanLabels',
            'feeData',
            'tabelManager',
            'transaksiTerbaru',
        ));
    }
}

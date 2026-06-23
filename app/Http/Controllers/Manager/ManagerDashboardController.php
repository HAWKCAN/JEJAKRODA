<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $rentalOwner = Auth::user()->rentalOwner;

        if (!$rentalOwner) {
            return view('manager.dashboard', [
                'rentalOwner'      => null,
                'totalVehicles'    => 0,
                'totalBookings'    => 0,
                'pendingBookings'  => 0,
                'totalRevenue'     => 0,
                'bulanLabels'      => [],
                'revenueData'      => [],
                'pesananTerbaru'   => collect(),
                'kendaraanLaris'   => collect(),
            ]);
        }

        $ownerId = $rentalOwner->id;

        // ── 1. Metrik utama ──
        $totalVehicles = Vehicle::where('rental_owner_id', $ownerId)->count();

        $totalBookings = Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $ownerId))
            ->whereIn('status', ['confirmed', 'completed'])
            ->count();

        $pendingBookings = Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $ownerId))
            ->where('status', 'pending')
            ->count();

        // Pendapatan bersih: subtotal dikurangi platform fee
        $totalRevenue = Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $ownerId))
            ->whereIn('status', ['confirmed', 'completed'])
            ->whereHas('payment', fn($q) => $q->where('status', 'verified'))
            ->selectRaw('SUM(subtotal - platform_fee_amount) as net')
            ->value('net') ?? 0;

        // ── 2. Grafik pendapatan 6 bulan terakhir ──
        $revenuePerBulan = Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $ownerId))
            ->whereHas('payment', fn($q) => $q->where('status', 'verified'))
            ->select(
                DB::raw('YEAR(bookings.created_at) as tahun'),
                DB::raw('MONTH(bookings.created_at) as bulan'),
                DB::raw('SUM(subtotal - platform_fee_amount) as total')
            )
            ->where('bookings.created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $bulanLabels = [];
        $revenueData = [];
        for ($i = 5; $i >= 0; $i--) {
            $tanggal = now()->subMonths($i);
            $bulanLabels[] = $tanggal->translatedFormat('M Y');
            $row = $revenuePerBulan->first(
                fn($r) => $r->tahun == $tanggal->year && $r->bulan == $tanggal->month
            );
            $revenueData[] = $row ? (float) $row->total : 0;
        }

        // ── 3. Pesanan terbaru ──
        $pesananTerbaru = Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $ownerId))
            ->with(['user', 'vehicle'])
            ->latest()
            ->take(6)
            ->get();

        // ── 4. Kendaraan paling laris ──
        $kendaraanLaris = Vehicle::where('rental_owner_id', $ownerId)
            ->withCount(['bookings as total_booking' => function ($q) {
                $q->whereIn('status', ['confirmed', 'completed']);
            }])
            ->orderByDesc('total_booking')
            ->take(5)
            ->get();

        return view('manager.dashboard', compact(
            'rentalOwner',
            'totalVehicles',
            'totalBookings',
            'pendingBookings',
            'totalRevenue',
            'bulanLabels',
            'revenueData',
            'pesananTerbaru',
            'kendaraanLaris',
        ));
    }
}
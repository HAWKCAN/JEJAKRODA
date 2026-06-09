<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ReturnLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    /**
     * Tampilkan form pencatatan pengembalian kendaraan.
     */
    public function create(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return redirect()->route('manager.bookings.index')
                ->with('error', 'Pengembalian hanya bisa dicatat untuk booking berstatus "confirmed".');
        }

        $booking->load(['user', 'vehicle']);

        return view('manager.returns.create', compact('booking'));
    }

    /**
     * Simpan data pengembalian dan hitung denda otomatis per jam.
     *
     * Rumus denda:
     *   late_fee = jam_terlambat × (price_per_day ÷ 24)
     * Artinya: setiap jam keterlambatan dikenakan tarif 1/24 dari harga sewa per hari.
     */
    public function store(Request $request, Booking $booking)
    {
        $request->validate([
            'returned_at' => 'required|date',
            'condition'   => 'required|string|max:1000',
        ]);

        $returnedAt = Carbon::parse($request->returned_at);
        // Batas akhir pengembalian = akhir hari tanggal end_date
        $dueAt = Carbon::parse($booking->end_date)->endOfDay();

        // Hitung denda jika terlambat
        $lateFee = 0;
        if ($returnedAt->gt($dueAt)) {
            // ceil() agar hitungan per jam penuh (misal 1 jam 10 menit = 2 jam)
            $hoursLate  = (int) ceil($dueAt->diffInMinutes($returnedAt) / 60);
            $hourlyRate = $booking->vehicle->price_per_day / 24;
            $lateFee    = $hoursLate * $hourlyRate;
        }

        ReturnLog::create([
            'booking_id'  => $booking->id,
            'returned_at' => $returnedAt,
            'late_fee'    => $lateFee,
            'condition'   => $request->condition,
        ]);

        // Update status booking dan ketersediaan kendaraan
        $booking->update(['status' => 'completed']);
        $booking->vehicle->update(['status' => 'available']);

        $message = "Pengembalian booking #{$booking->id} berhasil dicatat.";
        if ($lateFee > 0) {
            $message .= ' Denda keterlambatan: Rp ' . number_format($lateFee, 0, ',', '.');
        }

        return redirect()->route('manager.bookings.index')->with('success', $message);
    }
}
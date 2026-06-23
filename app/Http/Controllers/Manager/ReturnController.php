<?php

namespace App\Http\Controllers\Manager; 

use App\Http\Controllers\Controller; 
use App\Models\Booking;
use App\Models\ReturnLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\ReturnNotification;

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

        // Tambah: pastikan sudah ada payment verified
        if (!$booking->payment || $booking->payment->status !== 'verified') {
            return redirect()->route('manager.bookings.index')
                ->with('error', 'Pembayaran belum diverifikasi.');
        }

        $booking->load(['user', 'vehicle']);
        return view('manager.returns.create', compact('booking'));
    }

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
        // Notif ke user
        $booking->user->notify(new ReturnNotification(
            'Kendaraan Dikembalikan',
            "Pengembalian booking #{$booking->id} berhasil dicatat." . ($lateFee > 0 ? ' Denda: Rp ' . number_format($lateFee, 0, ',', '.') : ''),
            url('/bookings/' . $booking->id)
        ));
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
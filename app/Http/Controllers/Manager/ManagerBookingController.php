<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ManagerBookingController extends Controller
{
    /**
     * Daftar semua booking (prioritas: pending di atas).
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'vehicle'])
            ->orderByRaw("FIELD(status, 'pending', 'confirmed', 'completed', 'rejected')")
            ->latest()
            ->paginate(15);

        return view('manager.bookings.index', compact('bookings'));
    }

    /**
     * Detail booking beserta informasi user, kendaraan, payment, dan pengembalian.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'vehicle', 'payment.platformFee', 'returnLog']);

        return view('manager.bookings.show', compact('booking'));
    }

    /**
     * Konfirmasi booking: status → confirmed, kendaraan → rented.
     */
    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        $booking->update(['status' => 'confirmed']);
        $booking->vehicle->update(['status' => 'rented']);

        return redirect()->route('manager.bookings.index')
            ->with('success', "Booking #{$booking->id} berhasil dikonfirmasi.");
    }

    /**
     * Tolak booking: status → rejected, simpan alasan penolakan.
     */
    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'notes' => 'required|string|max:500',
        ]);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        $booking->update([
            'status' => 'rejected',
            'notes'  => $request->notes,
        ]);

        return redirect()->route('manager.bookings.index')
            ->with('success', "Booking #{$booking->id} berhasil ditolak.");
    }
}
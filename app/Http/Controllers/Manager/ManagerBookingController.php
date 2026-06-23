<?php

namespace App\Http\Controllers\Manager;

use App\Models\Booking;
use App\Models\RentalOwner;
use Illuminate\Http\Request;
use App\Notifications\BookingNotification;
use App\Http\Controllers\Controller;

class ManagerBookingController extends Controller
{
    // ── Helper: ambil RentalOwner milik manager yang login ──────
    private function getOwner(): RentalOwner
    {
        $owner = RentalOwner::where('user_id', auth()->id())->first();

        if (!$owner) {
            abort(403, 'Akun manager belum terdaftar sebagai rental owner.');
        }

        return $owner;
    }

    /**
     * Daftar booking — HANYA untuk kendaraan milik manager yang login.
     * Prioritas: pending di atas.
     */
    public function index()
    {
        $owner = $this->getOwner();

        $bookings = Booking::with(['user', 'vehicle'])
            ->whereHas('vehicle', function ($q) use ($owner) {
                $q->where('rental_owner_id', $owner->id);
            })
            ->orderByRaw("FIELD(status, 'pending', 'confirmed', 'completed', 'rejected')")
            ->latest()
            ->paginate(15);

        return view('manager.bookings.index', compact('bookings'));
    }

    /**
     * Helper: pastikan booking yang diakses benar-benar milik
     * kendaraan manager yang login. Kalau bukan, lempar 404 —
     * bukan 403 — supaya manager lain tidak tahu booking itu
     * "ada tapi bukan miliknya" (mencegah information leakage).
     */
    private function authorizeBooking(Booking $booking): void
    {
        $owner = $this->getOwner();

        if ($booking->vehicle->rental_owner_id !== $owner->id) {
            abort(404);
        }
    }

    /**
     * Detail booking beserta informasi user, kendaraan, payment, dan pengembalian.
     */
    public function show(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->load(['user', 'vehicle', 'payment.platformFee', 'returnLog']);

        return view('manager.bookings.show', compact('booking'));
    }

    /**
     * Konfirmasi booking: status → confirmed, kendaraan → rented.
     */
    public function confirm(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking ini sudah diproses sebelumnya.');
        }

        $booking->update(['status' => 'confirmed']);
        $booking->user->notify(new BookingNotification(
            'Booking Dikonfirmasi ✓',
            "Booking #{$booking->id} kamu telah dikonfirmasi. Silakan lakukan pembayaran.",
            url('/bookings/' . $booking->id)
        ));
        $booking->vehicle->update(['status' => 'rented']);

        return redirect()->route('manager.bookings.index')
            ->with('success', "Booking #{$booking->id} berhasil dikonfirmasi.");
    }

    /**
     * Verifikasi pembayaran: status payment → verified.
     */
    public function verifyPayment(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if (!$booking->payment) {
            return back()->with('error', 'Belum ada pembayaran untuk booking ini.');
        }

        if ($booking->payment->status !== 'pending') {
            return back()->with('error', 'Pembayaran ini sudah diproses sebelumnya.');
        }

        $booking->payment->update(['status' => 'verified']);

        $booking->user->notify(new \App\Notifications\PaymentNotification(
            'Pembayaran Diverifikasi ✓',
            "Pembayaran booking #{$booking->id} telah diverifikasi. Kendaraan siap diambil.",
            url('/bookings/' . $booking->id)
        ));

        return redirect()->route('manager.bookings.show', $booking)
            ->with('success', "Pembayaran booking #{$booking->id} berhasil diverifikasi.");
    }

    /**
     * Tolak booking: status → rejected, simpan alasan penolakan.
     */
    public function reject(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);

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
        $booking->user->notify(new BookingNotification(
            'Booking Ditolak',
            "Booking #{$booking->id} kamu ditolak. Alasan: {$request->notes}",
            url('/bookings/' . $booking->id)
        ));

        return redirect()->route('manager.bookings.index')
            ->with('success', "Booking #{$booking->id} berhasil ditolak.");
    }
}
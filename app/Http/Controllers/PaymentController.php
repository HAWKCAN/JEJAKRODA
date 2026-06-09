<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PlatformFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    const PLATFORM_FEE_PERCENT = 5;

    /**
     * Tampilkan form pembayaran untuk booking yang sudah dikonfirmasi.
     */
    public function create(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        if ($booking->status !== 'confirmed') {
            return redirect()->route('bookings.history')
                ->with('error', 'Booking harus dikonfirmasi manager sebelum melakukan pembayaran.');
        }

        if ($booking->payment) {
            return redirect()->route('bookings.history')
                ->with('error', 'Pembayaran untuk booking ini sudah pernah dilakukan.');
        }

        $booking->load('vehicle');

        return view('payments.create', compact('booking'));
    }

    /**
     * Simpan pembayaran + otomatis buat record PlatformFee.
     */
    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        $request->validate([
            'method' => 'required|string|in:transfer,cash,qris',
            'proof'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Upload bukti pembayaran ke storage/public/payments/
        $proofPath = $request->file('proof')->store('payments', 'public');

        // Buat record payment
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'method'     => $request->method,
            'amount'     => $booking->total_price,
            'status'     => 'pending',
            'proof_url'  => $proofPath,
            'paid_at'    => now(),
        ]);

        // Otomatis buat record PlatformFee saat payment dibuat
        PlatformFee::create([
            'payment_id'      => $payment->id,
            'fee_percent'     => self::PLATFORM_FEE_PERCENT,
            'fee_amount'      => $booking->platform_fee_amount,
            'disbursed_status' => false,
        ]);

        return redirect()->route('bookings.history')
            ->with('success', 'Pembayaran berhasil dikirim! Menunggu verifikasi dari manager.');
    }
}
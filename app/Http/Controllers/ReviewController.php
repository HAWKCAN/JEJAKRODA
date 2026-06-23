<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * POST /reviews/{booking}
     * Hanya bisa submit ulasan jika booking milik user dan statusnya completed
     */
    public function store(Request $request, Booking $booking)
    {
        // Pastikan booking milik user yang login
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Pastikan booking sudah completed
        if ($booking->status !== 'completed') {
            return back()->with('error', 'Kamu hanya bisa memberikan ulasan setelah booking selesai.');
        }

        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // Cek sudah pernah review kendaraan ini
        $sudahReview = Review::where('user_id', auth()->id())
            ->where('vehicle_id', $booking->vehicle_id)
            ->exists();

        if ($sudahReview) {
            return back()->with('error', 'Kamu sudah pernah memberikan ulasan untuk kendaraan ini.');
        }

        Review::create([
            'user_id'    => auth()->id(),
            'vehicle_id' => $booking->vehicle_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Ulasan berhasil dikirim! Terima kasih 🎉');
    }
}
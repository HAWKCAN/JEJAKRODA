<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Platform fee dihardcode 5% sesuai spesifikasi
    const PLATFORM_FEE_PERCENT = 5;

    /**
     * Tampilkan form pemesanan untuk kendaraan tertentu.
     */
    public function create(Vehicle $vehicle)
    {
        if ($vehicle->status !== 'available') {
            return redirect()->back()
                ->with('error', 'Kendaraan ini sedang tidak tersedia untuk disewa.');
        }

        return view('bookings.create', compact('vehicle'));
    }

    /**
     * Simpan pemesanan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
            'notes'      => 'nullable|string|max:500',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        if ($vehicle->status !== 'available') {
            return back()->with('error', 'Maaf, kendaraan ini sudah tidak tersedia.');
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        $totalDays = max(1, $startDate->diffInDays($endDate));

        $subtotal            = $totalDays * $vehicle->price_per_day;
        $platformFeeAmount   = $subtotal * (self::PLATFORM_FEE_PERCENT / 100);
        $totalPrice          = $subtotal + $platformFeeAmount;

        Booking::create([
            'user_id'             => Auth::id(),
            'vehicle_id'          => $vehicle->id,
            'start_date'          => $request->start_date,
            'end_date'            => $request->end_date,
            'total_days'          => $totalDays,
            'subtotal'            => $subtotal,
            'platform_fee_amount' => $platformFeeAmount,
            'total_price'         => $totalPrice,
            'status'              => 'pending',
            'notes'               => $request->notes,
        ]);

        return redirect()->route('bookings.history')
            ->with('success', 'Pemesanan berhasil dibuat! Menunggu konfirmasi dari manager.');
    }

    /**
     * Detail booking milik user yang sedang login.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        $booking->load(['vehicle', 'payment', 'returnLog']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Riwayat semua booking milik user yang sedang login.
     */
    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['vehicle', 'payment'])
            ->latest()
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }
}
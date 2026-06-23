<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Review;
use App\Models\SuperAdminSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\BookingNotification;

class BookingController extends Controller
{
    public function create(Vehicle $vehicle)
    {
        if ($vehicle->status === 'available') {
            return view('user.bookings.create', compact('vehicle'));
        } else {
            return redirect()->back()
                ->with('error', 'Kendaraan ini sedang tidak tersedia untuk disewa.');
        }
    }

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

        $vehicle->loadMissing('rentalOwner');
        if ($vehicle->rentalOwner && $vehicle->rentalOwner->operating_hours) {
            [$jamBuka, $jamTutup] = array_map('trim', explode('-', $vehicle->rentalOwner->operating_hours));
            $sekarang = now()->format('H:i');

            if ($sekarang < $jamBuka || $sekarang > $jamTutup) {
                return back()->with('error', "Toko sedang tutup. Jam operasional: {$vehicle->rentalOwner->operating_hours}. Silakan booking kembali saat jam operasional.");
            }
        }

   
        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        $totalDays = max(1, $startDate->diffInDays($endDate));

        // Ambil persentase fee dari settings, bukan hardcode
        // $platformFeePercent = (float) SuperAdminSetting::getValue('platformFeePercent', 5);
        $platformFeePercent = 5;

        $subtotal          = $totalDays * $vehicle->price_per_day;
        $platformFeeAmount = $subtotal * ($platformFeePercent / 100);

        // Pelanggan bayar subtotal saja — fee dipotong dari pendapatan manager
        $totalPrice = $subtotal;

        $booking = Booking::create([
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

        // Notif ke pelanggan
        auth()->user()->notify(new BookingNotification(
            'Booking Berhasil Dibuat',
            'Booking kamu sedang menunggu konfirmasi manager.',
            url('/bookings/' . $booking->id)
        ));

        // Notif hanya ke manager pemilik kendaraan ini, bukan semua manager
        $vehicle->loadMissing('rentalOwner.user');
        if ($vehicle->rentalOwner && $vehicle->rentalOwner->user) {
            $vehicle->rentalOwner->user->notify(new BookingNotification(
                'Booking Baru Masuk',
                auth()->user()->name . ' membuat booking baru. Segera konfirmasi.',
                url('/manager/bookings/' . $booking->id)
            ));
        }

        return redirect()->route('bookings.history')
            ->with('success', 'Pemesanan berhasil dibuat! Menunggu konfirmasi dari manager.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        $booking->load(['vehicle', 'payment', 'returnLog']);

        $sudahReview = Review::where('user_id', Auth::id())
            ->where('vehicle_id', $booking->vehicle_id)
            ->exists();

        return view('user.bookings.show', compact('booking', 'sudahReview'));
    }

    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['vehicle', 'payment'])
            ->latest()
            ->paginate(10);

        return view('user.bookings.history', compact('bookings'));
    }
}
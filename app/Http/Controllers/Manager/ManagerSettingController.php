<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerSettingController extends Controller
{
    public function index()
    {
        $rentalOwner = Auth::user()->rentalOwner;

        // Pecah operating_hours yang tersimpan jadi 2 variabel untuk isi form
        $jamBuka = null;
        $jamTutup = null;
        if ($rentalOwner && $rentalOwner->operating_hours) {
            $parts = explode('-', $rentalOwner->operating_hours);
            $jamBuka  = trim($parts[0] ?? '');
            $jamTutup = trim($parts[1] ?? '');
        }

        return view('manager.settings.index', compact('rentalOwner', 'jamBuka', 'jamTutup'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'jam_buka'              => 'nullable|date_format:H:i',
            'jam_tutup'             => 'nullable|date_format:H:i|after:jam_buka',
            'whatsapp_number'       => 'nullable|string|max:20',
            'auto_confirm_booking'  => 'nullable|boolean',

            // Data bank (tidak perlu approval, tidak memengaruhi verification_status)
            'bank_name'             => 'nullable|string|max:255',
            'bank_account_number'   => 'nullable|string|max:50',
            'bank_account_holder'   => 'nullable|string|max:255',
        ]);

        // Gabungkan jam operasional jadi format konsisten "08:00 - 20:00"
        $operatingHours = null;
        if ($request->jam_buka && $request->jam_tutup) {
            $operatingHours = $request->jam_buka . ' - ' . $request->jam_tutup;
        }

        Auth::user()->rentalOwner->update([
            'operating_hours'      => $operatingHours,
            'whatsapp_number'      => $request->whatsapp_number,
            'auto_confirm_booking' => $request->boolean('auto_confirm_booking'),

            'bank_name'            => $request->bank_name,
            'bank_account_number'  => $request->bank_account_number,
            'bank_account_holder'  => $request->bank_account_holder,
        ]);

        return back()->with('success', 'Pengaturan toko berhasil disimpan.');
    }
}
<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\RentalOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagerVerificationController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        // Cek apakah manager ini sudah pernah mengirim data verifikasi sebelumnya
        $rentalOwner = RentalOwner::where('user_id', $user->id)->first();

        // KUNCI BIAR GA CRASH: Jika belum pernah kirim (data null), buat objek tiruan dengan status 'pending'
        if (!$rentalOwner) {
            $rentalOwner = (object) [
                'verification_status' => 'pending', // Status default sebelum diverifikasi admin
                'business_name'       => '',
                'business_address'    => '',
                'tax_number'          => '',
                'nib'                 => '',
                'ktp_image'           => null,
                'rejection_reason'    => null,
            ];
        }

        return view('manager.verification.index', compact('rentalOwner'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'business_name'    => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'tax_number'       => 'nullable|string|max:255',
            'nib'              => 'required|string|max:255',
            'ktp_image'        => 'nullable|image|max:2048',
        ], [
            'business_name.required'    => 'Nama Usaha Wajib Diisi.',
            'business_address.required' => 'Alamat Usaha Wajib Diisi.',
            'nib.required'              => 'NIB Wajib Diisi.',
            'ktp_image.image'          => 'File Harus Berupa Gambar.',
            'ktp_image.max'            => 'Ukuran Maksimal 2MB.',
        ]);

        $user = auth()->user();

        // Ambil rentalOwner, atau buat baru kalau manager belum pernah punya data sama sekali
        $rentalOwner = RentalOwner::firstOrNew(['user_id' => $user->id]);

        // Wajib upload KTP saat pertama kali mengisi (rentalOwner baru / belum punya ktp_image)
        if (!$rentalOwner->exists && !$request->hasFile('ktp_image')) {
            return back()
                ->withErrors(['ktp_image' => 'Foto KTP Wajib Diupload.'])
                ->withInput();
        }

        $data = [
            'business_name'        => $request->business_name,
            'business_address'     => $request->business_address,
            'tax_number'           => $request->tax_number,
            'nib'                  => $request->nib,
            'verification_status'  => 'pending',
            'rejection_reason'     => null,
        ];

        // Upload ulang foto KTP kalau ada file baru
        if ($request->hasFile('ktp_image')) {
            // Hapus file lama dulu kalau ada, biar storage tidak menumpuk
            if ($rentalOwner->ktp_image) {
                Storage::disk('public')->delete($rentalOwner->ktp_image);
            }
            $data['ktp_image'] = $request->file('ktp_image')->store('ktp', 'public');
        }

        $rentalOwner->fill($data);
        $rentalOwner->save();

        return back()->with('success', 'Dokumen berhasil dikirim. Menunggu verifikasi superadmin.');
    }
}
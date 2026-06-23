<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Models\RentalOwner;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagerVehicleController extends Controller
{
    // ── Helper: ambil RentalOwner milik manager yg login ─────────
    private function getOwner(): RentalOwner
    {
        $owner = RentalOwner::where('user_id', auth()->id())->first();

        if (!$owner) {
            abort(403, 'Akun manager belum terdaftar sebagai rental owner.');
        }

        return $owner;
    }

    // ── Helper: resize & simpan foto dengan GD ───────────────────
    private function uploadImage($file): string
    {
        $ext      = strtolower($file->getClientOriginalExtension());
        $filename = 'vehicle_' . uniqid() . '_' . time() . '.jpg';
        $savePath = storage_path('app/public/vehicles/' . $filename);

        // Pastikan folder ada
        if (!is_dir(storage_path('app/public/vehicles'))) {
            mkdir(storage_path('app/public/vehicles'), 0755, true);
        }

        // Baca gambar dengan GD
        $src = match ($ext) {
            'jpg', 'jpeg' => imagecreatefromjpeg($file->getRealPath()),
            'png'         => imagecreatefrompng($file->getRealPath()),
            'webp'        => imagecreatefromwebp($file->getRealPath()),
            default       => imagecreatefromjpeg($file->getRealPath()),
        };

        $origW = imagesx($src);
        $origH = imagesy($src);

        // Target: max 800x600, pertahankan rasio
        $maxW = 800;
        $maxH = 600;
        $ratio = min($maxW / $origW, $maxH / $origH);

        $newW = (int) round($origW * $ratio);
        $newH = (int) round($origH * $ratio);

        $dst = imagecreatetruecolor($newW, $newH);

        // Preserve transparency untuk PNG
        if ($ext === 'png') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

        // Simpan sebagai JPEG kualitas 85
        imagejpeg($dst, $savePath, 85);

        imagedestroy($src);
        imagedestroy($dst);

        return 'vehicles/' . $filename; // path relatif dari storage/public
    }

    // ── index ─────────────────────────────────────────────────────
    public function index()
    {
        $owner    = $this->getOwner();
        $vehicles = Vehicle::where('rental_owner_id', $owner->id)
            ->latest()
            ->paginate(12);

        return view('manager.vehicles.index', compact('vehicles', 'owner'));
    }

    // ── create ────────────────────────────────────────────────────
    public function create()
    {
        $this->getOwner(); // pastikan owner ada
        return view('manager.vehicles.create');
    }

    // ── store ─────────────────────────────────────────────────────
    public function store(VehicleRequest $request)
    {
        $owner    = $this->getOwner();
        $data     = $request->validated();
        $imageUrl = null;

        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadImage($request->file('image'));
        }

        Vehicle::create([
            'rental_owner_id' => $owner->id,
            'name'            => $data['name'],
            'type'            => $data['type'],
            'plate_number'    => strtoupper($data['plate_number']),
            'price_per_day'   => $data['price_per_day'],
            'location'        => $data['location'],
            'status'          => 'available',
            'image_url'       => $imageUrl,
        ]);

        return redirect()
            ->route('manager.vehicles.index')
            ->with('success', 'Kendaraan berhasil ditambahkan!');
    }

    // ── edit ──────────────────────────────────────────────────────
    public function edit(string $id)
    {
        $owner   = $this->getOwner();
        $vehicle = Vehicle::where('rental_owner_id', $owner->id)
            ->findOrFail($id);

        return view('manager.vehicles.edit', compact('vehicle'));
    }

    // ── update ────────────────────────────────────────────────────
    public function update(VehicleRequest $request, string $id)
    {
        $owner   = $this->getOwner();
        $vehicle = Vehicle::where('rental_owner_id', $owner->id)
            ->findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Hapus foto lama
            if ($vehicle->image_url) {
                Storage::disk('public')->delete($vehicle->image_url);
            }
            $data['image_url'] = $this->uploadImage($request->file('image'));
        }

        $vehicle->update([
            'name'          => $data['name'],
            'type'          => $data['type'],
            'plate_number'  => strtoupper($data['plate_number']),
            'price_per_day' => $data['price_per_day'],
            'location'      => $data['location'],
            'image_url'     => $data['image_url'] ?? $vehicle->image_url,
        ]);

        return redirect()
            ->route('manager.vehicles.index')
            ->with('success', 'Kendaraan berhasil diperbarui!');
    }

    // ── toggleStatus ──────────────────────────────────────────────
    public function toggleStatus(string $id)
    {
        $owner   = $this->getOwner();
        $vehicle = Vehicle::where('rental_owner_id', $owner->id)
            ->findOrFail($id);

        // Tidak boleh toggle kalau sedang disewa
        if ($vehicle->status === 'rented') {
            return back()->withErrors(['status' => 'Kendaraan sedang disewa, status tidak bisa diubah.']);
        }

        $vehicle->update([
            'status' => $vehicle->status === 'available' ? 'inactive' : 'available',
        ]);

        return back()->with('success', 'Status kendaraan berhasil diperbarui.');
    }

    // ── destroy ───────────────────────────────────────────────────
    public function destroy(string $id)
    {
        $owner   = $this->getOwner();
        $vehicle = Vehicle::where('rental_owner_id', $owner->id)
            ->findOrFail($id);

        if ($vehicle->status === 'rented') {
            return back()->withErrors(['delete' => 'Kendaraan sedang disewa, tidak bisa dihapus.']);
        }

        if ($vehicle->image_url) {
            Storage::disk('public')->delete($vehicle->image_url);
        }

        $vehicle->delete();

        return back()->with('success', 'Kendaraan berhasil dihapus.');
    }
}
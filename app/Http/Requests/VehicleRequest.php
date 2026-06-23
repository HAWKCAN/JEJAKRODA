<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isManager();
    }

    public function rules(): array
    {
        $vehicleId = $this->route('vehicle'); // null saat store, ada saat update

        return [
            'name'          => ['required', 'string', 'max:100'],
            'type'          => ['required', 'in:motor,mobil'],
            'plate_number'  => [
                'required', 'string', 'max:20',
                'unique:vehicles,plate_number' . ($vehicleId ? ",$vehicleId" : ''),
            ],
            'price_per_day' => ['required', 'numeric', 'min:10000', 'max:10000000'],
            'location'      => ['required', 'string', 'max:100'],
            'status'        => ['sometimes', 'in:available,rented,inactive'],
            'image'         => [
                $vehicleId ? 'nullable' : 'nullable', // foto opsional di create & edit
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:3072', // 3 MB
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Nama kendaraan wajib diisi.',
            'type.required'         => 'Tipe kendaraan wajib dipilih.',
            'type.in'               => 'Tipe harus motor atau mobil.',
            'plate_number.required' => 'Nomor plat wajib diisi.',
            'plate_number.unique'   => 'Nomor plat sudah terdaftar.',
            'price_per_day.required'=> 'Harga per hari wajib diisi.',
            'price_per_day.min'     => 'Harga minimal Rp 10.000.',
            'location.required'     => 'Lokasi wajib diisi.',
            'image.image'           => 'File harus berupa gambar.',
            'image.mimes'           => 'Format gambar: jpg, jpeg, png, webp.',
            'image.max'             => 'Ukuran gambar maksimal 3 MB.',
        ];
    }
}
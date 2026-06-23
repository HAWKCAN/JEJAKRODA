<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        return [
            'platformFeePercent' => 'required|numeric|min:0|max:100',
            'lateFeePerHour'     => 'required|numeric|min:0',
            'maxBookingDays'     => 'required|integer|min:1',
            'minBookingDays'     => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'platformFeePercent.required' => 'Persentase fee wajib diisi.',
            'platformFeePercent.max'      => 'Persentase fee maksimal 100.',
            'lateFeePerHour.required'     => 'Denda keterlambatan wajib diisi.',
            'maxBookingDays.required'     => 'Maksimal hari sewa wajib diisi.',
            'minBookingDays.required'     => 'Minimal hari sewa wajib diisi.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'role' => 'sometimes|in:user,manager',

            'business_name' => 'exclude_if:role,user|required|string',
            'business_address' => 'exclude_if:role,user|required|string',
            'tax_number' => 'exclude_if:role,user|nullable|string',

            // 'business_name' => 'required_if:role,manager|string|max:255',
            // 'business_address' => 'required_if:role,manager|string|max:255',
            // 'tax_number' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return[
            'name.required' => 'Nama Wajib Diisi.',
            'email.required' => 'Email Wajib Diisi.',
            'email.unique' => 'Email Sudah Terdaftar.',
            'password.required' => 'Password Wajib Diisi.',
            'password.min' => 'Password Minimal 8 Karakter.',
            'password.confirmed' => 'Konfirmasi Password Tidak Cocok.',
            'phone_number.required' => 'Nomor Telepon Wajib Diisi.',

            'business_name.required_if' => 'Nama Usaha Wajib Diisi.',
            'business_address.required_if' => 'Alamat Usaha Wajib Diisi.',
        ];
    }
}
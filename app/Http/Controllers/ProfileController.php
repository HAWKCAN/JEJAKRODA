<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(){
        return view('user.profile.show');
    }


    public function edit(){
        return view('user.profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:500',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
        ]);
        $user->update([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'address'      => $request->address,
        ]);
        return redirect('/profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RentalOwner;
use App\Models\User;
use Illuminate\Http\Request;
class SuperAdminUserController extends Controller
{    
    // Tampilkan semua user dengan filter role dan pencarian nama/email
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q
                ->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        return view('superadmin.users.index', compact('users'));
    }
    // Tampilkan detail user
    public function show($id){
        $user = User::with('rentalOwner')->findOrFail($id);
        return view('superadmin.users.show',compact('user'));
    }

    // Hapus user
    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return back()->with('error', 'Tidak bisa menghapus diri sendiri.');
        }
        User::findOrFail($id)->delete(); // fix: findOrdFail → findOrFail
        return back()->with('success', 'User berhasil dihapus.');
    }


    // Verifikasi manager
    public function verifyManager(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:verified,rejected']);

        $rentalOwner = RentalOwner::whereHas('user', fn($q) => $q->where('id', $id))
            ->firstOrFail();

        $rentalOwner->update(['verification_status' => $request->status]); // fix typo

        $pesan = $request->status === 'verified'
            ? 'Manager berhasil diverifikasi.'
            : 'Manager berhasil ditolak.';

        return back()->with('success', $pesan);
    }



}

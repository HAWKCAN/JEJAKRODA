<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\RentalOwner;
use Illuminate\Http\Request;

class SuperAdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->with('rentalOwner')->latest()->paginate(15);

        return view('superadmin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('rentalOwner')->findOrFail($id);
        return view('superadmin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    public function verifyManager(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:verified,rejected']);

        $rentalOwner = RentalOwner::whereHas('user', fn($q) => $q->where('id', $id))
            ->firstOrFail();

        $rentalOwner->update(['verification_status' => $request->status]);

        $pesan = $request->status === 'verified'
            ? 'Manager berhasil diverifikasi.'
            : 'Manager berhasil ditolak.';

        return back()->with('success', $pesan);
    }
}
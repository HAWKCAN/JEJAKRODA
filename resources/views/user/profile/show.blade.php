@extends('layouts.app')
@section('title', 'Profil Saya — Aspal Seru')

@section('content')
<main class="max-w-4xl mx-auto px-4 md:px-8 py-6 md:py-10">

    <!-- Notifikasi Sukses Update -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="mb-6 md:mb-8 text-center md:text-left">
        <h2 class="text-2xl md:text-3xl font-extrabold text-[#162740]">Profil Saya</h2>
        <p class="text-sm font-medium text-[#64748B] mt-1">Kelola informasi data diri dan akun Anda.</p>
    </div>

    <!-- Card Profil -->
    <div class="bg-white rounded-2xl border border-[#E2E8F0] shadow-sm overflow-hidden">
        
        <div class="p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 border-b border-[#E2E8F0]">
            <div class="w-24 h-24 rounded-full flex items-center justify-center text-3xl font-extrabold text-white bg-[#162740] ring-4 ring-[#F8FAFC] shadow-md">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            
            <div class="text-center md:text-left flex-1">
                <h3 class="text-xl md:text-2xl font-extrabold text-[#1E293B]">{{ auth()->user()->name }}</h3>
                <p class="text-sm font-medium text-[#64748B] mt-0.5">{{ auth()->user()->email }}</p>
                <div class="mt-3 flex justify-center md:justify-start">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#EFF6FF] text-[#0EA5E9] border border-[#BAE6FD]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0EA5E9]"></span> Member Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Data Diri (Read Only) -->
        <div class="p-6 md:p-8">
            <h4 class="text-base font-bold text-[#162740] mb-5">Informasi Pribadi</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">Nama Lengkap</label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] text-[#1E293B] font-medium text-sm rounded-xl px-4 py-3 outline-none cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">Alamat Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] text-[#1E293B] font-medium text-sm rounded-xl px-4 py-3 outline-none cursor-not-allowed">
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">Nomor Telepon</label>
                    <input type="text" value="{{ auth()->user()->phone_number ?? 'Belum ditambahkan' }}" disabled
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] {{ auth()->user()->phone_number ? 'text-[#1E293B]' : 'text-[#94A3B8] italic' }} font-medium text-sm rounded-xl px-4 py-3 outline-none cursor-not-allowed">
                </div>

                <!-- Tanggal Gabung -->
                <div>
                    <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">Bergabung Sejak</label>
                    <input type="text" value="{{ auth()->user()->created_at->format('d M Y') }}" disabled
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] text-[#1E293B] font-medium text-sm rounded-xl px-4 py-3 outline-none cursor-not-allowed">
                </div>

                <!-- Alamat Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">Alamat Lengkap</label>
                    <textarea disabled rows="3"
                        class="w-full bg-[#F8FAFC] border border-[#E2E8F0] {{ auth()->user()->address ? 'text-[#1E293B]' : 'text-[#94A3B8] italic' }} font-medium text-sm rounded-xl px-4 py-3 outline-none cursor-not-allowed resize-none">{{ auth()->user()->address ?? 'Belum ditambahkan' }}</textarea>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-[#E2E8F0] flex justify-end">
                <a href="/profile/edit" class="w-full md:w-auto text-center bg-[#0EA5E9] hover:bg-[#0284C7] text-white px-8 py-2.5 rounded-xl font-bold text-sm transition-colors shadow-sm">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- Tombol Logout Khusus Mobile -->
    <div class="mt-6 md:hidden mb-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-white border-2 border-[#FECACA] text-[#EF4444] hover:bg-red-50 font-bold text-sm px-4 py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar dari Akun
            </button>
        </form>
    </div>

</main>
@endsection
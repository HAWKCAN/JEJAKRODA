@extends('layouts.app')
@section('title', 'Edit Profil — Aspal Seru')

@section('content')
<main class="max-w-3xl mx-auto px-4 md:px-8 py-6 md:py-10">

    <div class="mb-6 md:mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#162740]">Edit Profil</h2>
            <p class="text-sm font-medium text-[#64748B] mt-1">Perbarui data diri Anda di bawah ini.</p>
        </div>
        <a href="/profile" class="hidden md:inline-flex items-center gap-2 text-sm font-bold text-[#64748B] hover:text-[#162740] transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-[#E2E8F0] shadow-sm overflow-hidden">
        
        <form action="/profile/update" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 md:p-8 space-y-6">
                
                <!-- Nama -->
                <div>
                    <label for="name" class="block text-[13px] font-bold text-[#162740] mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', auth()->user()->name) }}" 
                           required autofocus
                           class="w-full bg-white border-2 border-[#E2E8F0] focus:border-[#0EA5E9] focus:ring-4 focus:ring-[#0EA5E9]/10 text-[#1E293B] font-medium text-sm rounded-xl px-4 py-3 outline-none transition-all">
                    @error('name') <p class="text-red-500 text-xs font-semibold mt-1.5">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[13px] font-bold text-[#162740] mb-2">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" 
                           value="{{ old('email', auth()->user()->email) }}" 
                           required
                           class="w-full bg-white border-2 border-[#E2E8F0] focus:border-[#0EA5E9] focus:ring-4 focus:ring-[#0EA5E9]/10 text-[#1E293B] font-medium text-sm rounded-xl px-4 py-3 outline-none transition-all">
                    @error('email') <p class="text-red-500 text-xs font-semibold mt-1.5">{{ $message }}</p> @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="phone_number" class="block text-[13px] font-bold text-[#162740] mb-2">Nomor Telepon</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 rounded-l-xl border-2 border-r-0 border-[#E2E8F0] bg-[#F8FAFC] text-[#64748B] font-bold text-sm">
                            +62
                        </span>
                        <input type="text" id="phone_number" name="phone_number" 
                               value="{{ old('phone_number', auth()->user()->phone_number) }}" 
                               placeholder="81234567890"
                               class="w-full bg-white border-2 border-[#E2E8F0] focus:border-[#0EA5E9] focus:ring-4 focus:ring-[#0EA5E9]/10 text-[#1E293B] font-medium text-sm rounded-r-xl px-4 py-3 outline-none transition-all">
                    </div>
                    @error('phone_number') <p class="text-red-500 text-xs font-semibold mt-1.5">{{ $message }}</p> @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label for="address" class="block text-[13px] font-bold text-[#162740] mb-2">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3"
                              placeholder="Masukkan alamat lengkap (Jalan, RT/RW, Kelurahan, dll)"
                              class="w-full bg-white border-2 border-[#E2E8F0] focus:border-[#0EA5E9] focus:ring-4 focus:ring-[#0EA5E9]/10 text-[#1E293B] font-medium text-sm rounded-xl px-4 py-3 outline-none transition-all resize-none">{{ old('address', auth()->user()->address) }}</textarea>
                    @error('address') <p class="text-red-500 text-xs font-semibold mt-1.5">{{ $message }}</p> @enderror
                </div>

            </div>

            <!-- Tombol Aksi -->
            <div class="bg-[#F8FAFC] px-6 py-5 border-t border-[#E2E8F0] flex flex-col-reverse md:flex-row items-center justify-end gap-3">
                <a href="/profile" class="w-full md:w-auto px-6 py-2.5 rounded-xl font-bold text-sm text-[#64748B] hover:bg-[#E2E8F0] transition-colors text-center">
                    Batal
                </a>
                <button type="submit" class="w-full md:w-auto bg-[#162740] hover:bg-[#0F1A2A] text-white px-8 py-2.5 rounded-xl font-bold text-sm transition-colors shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</main>
@endsection
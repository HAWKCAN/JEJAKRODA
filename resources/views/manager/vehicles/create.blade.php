@extends('layouts.manager')

@section('title', 'Tambah Kendaraan — Aspal Seru')
@section('page-title', 'Tambah Kendaraan')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-[#162740]">Informasi Kendaraan</h2>
            <p class="text-xs text-slate-400 mt-0.5">Isi data kendaraan yang akan didaftarkan.</p>
        </div>

        <form method="POST" action="{{ route('manager.vehicles.store') }}"
              enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Nama Kendaraan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="cth. Honda Beat 2023"
                       class="w-full px-4 py-2.5 rounded-xl border text-sm outline-none
                              bg-slate-50 text-slate-800 transition-colors
                              focus:border-sky-400 focus:bg-white
                              {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200' }}">
                @error('name')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipe --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Tipe <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-3">
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="type" value="motor"
                               class="sr-only peer" {{ old('type') === 'motor' ? 'checked' : '' }}>
                        <div class="flex items-center justify-center gap-2 py-3 rounded-xl border-2
                                    text-sm font-semibold transition-all
                                    border-slate-200 text-slate-500 bg-slate-50
                                    peer-checked:border-sky-500 peer-checked:text-sky-600 peer-checked:bg-sky-50">
                            <span class="text-xl">🏍️</span> Motor
                        </div>
                    </label>
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="type" value="mobil"
                               class="sr-only peer" {{ old('type') === 'mobil' ? 'checked' : '' }}>
                        <div class="flex items-center justify-center gap-2 py-3 rounded-xl border-2
                                    text-sm font-semibold transition-all
                                    border-slate-200 text-slate-500 bg-slate-50
                                    peer-checked:border-sky-500 peer-checked:text-sky-600 peer-checked:bg-sky-50">
                            <span class="text-xl">🚗</span> Mobil
                        </div>
                    </label>
                </div>
                @error('type')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Plat + Lokasi --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Nomor Plat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="plate_number" value="{{ old('plate_number') }}"
                           placeholder="cth. R 1234 AB"
                           class="w-full px-4 py-2.5 rounded-xl border text-sm outline-none
                                  bg-slate-50 text-slate-800 uppercase transition-colors
                                  focus:border-sky-400 focus:bg-white
                                  {{ $errors->has('plate_number') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('plate_number')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           placeholder="cth. Purwokerto"
                           class="w-full px-4 py-2.5 rounded-xl border text-sm outline-none
                                  bg-slate-50 text-slate-800 transition-colors
                                  focus:border-sky-400 focus:bg-white
                                  {{ $errors->has('location') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('location')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Harga --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Harga per Hari <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
                    <input type="number" name="price_per_day" value="{{ old('price_per_day') }}"
                           placeholder="75000" min="10000"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border text-sm outline-none
                                  bg-slate-50 text-slate-800 transition-colors
                                  focus:border-sky-400 focus:bg-white
                                  {{ $errors->has('price_per_day') ? 'border-red-400' : 'border-slate-200' }}">
                </div>
                @error('price_per_day')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Foto --}}
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Foto Kendaraan <span class="text-slate-400">(opsional, maks. 3 MB)</span>
                </label>
                <div id="drop-zone"
                     class="relative border-2 border-dashed border-slate-200 rounded-xl
                            bg-slate-50 hover:border-sky-400 hover:bg-sky-50/30 transition-colors
                            text-center cursor-pointer overflow-hidden">
                    <input type="file" name="image" id="image-input" accept="image/*"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10"
                           onchange="previewImage(event)">
                    <div id="upload-placeholder" class="py-8 px-4">
                        <div class="text-3xl mb-2">📷</div>
                        <p class="text-sm font-semibold text-slate-500">Klik atau drag foto ke sini</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, WebP — maks. 3 MB</p>
                    </div>
                    <img id="image-preview" class="hidden w-full h-48 object-cover" alt="Preview">
                </div>
                @error('image')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3 pt-2">
                <a href="{{ route('manager.vehicles.index') }}"
                   class="flex-1 text-center py-3 rounded-xl text-sm font-semibold
                          bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 py-3 rounded-xl text-sm font-bold text-white
                               bg-sky-500 hover:bg-sky-600 transition-colors shadow-sm">
                    Simpan Kendaraan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('upload-placeholder');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
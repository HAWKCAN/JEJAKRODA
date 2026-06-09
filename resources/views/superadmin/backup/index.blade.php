@extends('layouts.app')

@section('title', 'Backup Database')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Backup Database</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola backup database aplikasi secara manual</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
            <div class="mb-4 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-semibold">Backup Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="font-semibold">Backup Gagal</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Card Utama --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            {{-- Ilustrasi / Banner --}}
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 px-6 py-8 text-white text-center">
                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold">Backup Database</h2>
                <p class="text-indigo-200 text-sm mt-1">Simpan salinan database untuk keamanan data</p>
            </div>

            <div class="p-6 space-y-5">

                {{-- Info --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-800">
                    <p class="font-semibold mb-2">ℹ️ Tentang Fitur Backup</p>
                    <ul class="list-disc list-inside space-y-1 text-xs text-blue-700">
                        <li>Backup hanya menyimpan database (tanpa file media)</li>
                        <li>File backup tersimpan di folder <code class="bg-blue-100 px-1 rounded">storage/app/backup</code></li>
                        <li>Proses backup mungkin memakan waktu beberapa saat</li>
                        <li>Disarankan melakukan backup secara berkala</li>
                    </ul>
                </div>

                {{-- Tombol Backup --}}
                <form action="{{ route('superAdmin.backup.run') }}" method="POST"
                      onsubmit="return confirmBackup()">
                    @csrf
                    <button type="submit" id="backup-btn"
                            class="w-full flex items-center justify-center gap-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                                   text-white font-semibold py-3.5 rounded-xl transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Jalankan Backup Sekarang
                    </button>
                </form>

                {{-- Peringatan --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
                    <p class="font-semibold">⚠️ Perhatian</p>
                    <p class="text-xs text-amber-700 mt-1">
                        Pastikan konfigurasi backup sudah diatur di <code class="bg-amber-100 px-1 rounded">config/backup.php</code>
                        dan package <code class="bg-amber-100 px-1 rounded">spatie/laravel-backup</code> sudah terinstall.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmBackup() {
        const confirmed = confirm('Jalankan backup database sekarang?');
        if (confirmed) {
            document.getElementById('backup-btn').innerHTML =
                '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Sedang Memproses...';
            document.getElementById('backup-btn').disabled = true;
        }
        return confirmed;
    }
</script>
@endpush
@endsection
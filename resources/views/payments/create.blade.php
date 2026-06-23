@extends('layouts.app')

@section('title', 'Pembayaran Booking #' . $booking->id)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('bookings.history') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Riwayat
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Pembayaran</h1>
            <p class="text-gray-500 text-sm mt-1">Booking <span class="font-medium text-indigo-600">#{{ $booking->id }}</span> — {{ $booking->vehicle->name }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- Ringkasan Booking --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-6">
                    <h3 class="font-semibold text-gray-800 mb-4 text-sm uppercase tracking-wide text-gray-400">Ringkasan Pemesanan</h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Kendaraan</p>
                            <p class="font-semibold text-gray-900 mt-0.5">{{ $booking->vehicle->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $booking->vehicle->plate_number }}</p>
                        </div>
                        <div class="border-t pt-3 space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Periode</span>
                                <span class="text-right text-xs font-medium">
                                    {{ $booking->start_date->format('d M Y') }}<br>
                                    s/d {{ $booking->end_date->format('d M Y') }}
                                </span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Total Hari</span>
                                <span class="font-medium">{{ $booking->total_days }} hari</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Biaya Platform (5%)</span>
                                <span class="font-medium text-orange-500">+ Rp {{ number_format($booking->platform_fee_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between font-bold text-gray-900 bg-indigo-50 rounded-xl px-3 py-2.5">
                            <span>Total Bayar</span>
                            <span class="text-indigo-700">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Pembayaran --}}
            <div class="lg:col-span-3">
                <form action="{{ route('payments.store', $booking) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                        <h3 class="font-semibold text-gray-800 text-lg border-b pb-3">Detail Pembayaran</h3>

                        {{-- Metode Pembayaran --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach(['transfer' => ['label' => 'Transfer Bank', 'icon' => '🏦'], 'cash' => ['label' => 'Tunai', 'icon' => '💵'], 'qris' => ['label' => 'QRIS', 'icon' => '📱']] as $value => $opt)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="method" value="{{ $value }}"
                                           class="peer sr-only"
                                           {{ old('method') === $value ? 'checked' : ($value === 'transfer' && !old('method') ? 'checked' : '') }}>
                                    <div class="border-2 border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 rounded-xl p-3 text-center transition-all">
                                        <span class="text-2xl block mb-1">{{ $opt['icon'] }}</span>
                                        <span class="text-xs font-medium text-gray-700">{{ $opt['label'] }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('method')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div>
                            @error('method')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Info Rekening Bank (Ditampilkan via JS jika Transfer dipilih) --}}
                        <div id="bank-info-section" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm">
                            <h4 class="font-semibold text-blue-800 mb-2">💳 Informasi Rekening Tujuan</h4>
                            <div class="space-y-1 text-blue-700 text-xs">
                                <p>Bank: <span class="font-bold text-sm">BCA</span></p>
                                <p>No. Rekening: <span class="font-bold text-sm">1234 5678 90</span></p>
                                <p>Atas Nama: <span class="font-bold text-sm">Manager / Aspal Seru</span></p>
                                <p class="mt-2 text-blue-600 italic">* Silakan transfer tepat sesuai dengan Total Bayar ke rekening di atas sebelum mengunggah bukti.</p>
                            </div>
                        </div>

                        {{-- Upload Bukti --}}
                        <div>
                            <label for="proof" class="block text-sm font-medium text-gray-700 mb-1">
                                Bukti Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-400 mb-2">Format: JPG, PNG, atau PDF. Maks. 2MB.</p>

                            <label for="proof"
                                   class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 hover:border-indigo-400 rounded-xl cursor-pointer bg-gray-50 hover:bg-indigo-50 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-indigo-400 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p id="file-label" class="text-sm text-gray-500 group-hover:text-indigo-500">
                                    <span class="font-medium">Klik untuk upload</span> atau drag & drop
                                </p>
                                <input id="proof" name="proof" type="file"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       class="sr-only">
                            </label>

                            @error('proof')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Informasi penting --}}
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
                            <p class="font-semibold mb-1">⚠️ Perhatian</p>
                            <ul class="list-disc list-inside space-y-1 text-xs text-amber-700">
                                <li>Pastikan jumlah transfer sesuai dengan total yang tertera</li>
                                <li>Bukti pembayaran akan diverifikasi oleh manager</li>
                                <li>Konfirmasi akan dikirimkan setelah verifikasi selesai</li>
                            </ul>
                        </div>

                        <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                            Kirim Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview nama file yang dipilih
    document.getElementById('proof').addEventListener('change', function () {
        const label = document.getElementById('file-label');
        if (this.files && this.files[0]) {
            label.innerHTML = '<span class="font-medium text-indigo-600">' + this.files[0].name + '</span>';
        }
    });

    // Toggle Info Rekening Bank
    document.addEventListener('DOMContentLoaded', function() {
        const paymentRadios = document.querySelectorAll('input[name="method"]');
        const bankInfoSection = document.getElementById('bank-info-section');

        function toggleBankInfo() {
            // Cari radio button yang sedang dipilih
            const selectedMethod = document.querySelector('input[name="method"]:checked');
            
            // Jika yang dipilih adalah 'transfer', hilangkan class 'hidden'
            if (selectedMethod && selectedMethod.value === 'transfer') {
                bankInfoSection.classList.remove('hidden');
            } else {
                bankInfoSection.classList.add('hidden');
            }
        }

        // Jalankan sekali saat halaman pertama kali dimuat
        toggleBankInfo();

        // Tambahkan event listener ketika pilihan diubah
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', toggleBankInfo);
        });
    });
</script>
@endpush
@endsection
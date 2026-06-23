@extends('layouts.app')

@section('title', 'Detail Booking #' . $booking->id)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('bookings.history') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Riwayat
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Detail Booking <span class="text-indigo-600">#{{ $booking->id }}</span></h1>
            </div>
            @php
                $badge = [
                    'pending'   => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                    'confirmed' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'rejected'  => 'bg-red-100 text-red-700 border-red-200',
                    'completed' => 'bg-green-100 text-green-700 border-green-200',
                ][$booking->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
            @endphp
            <span class="px-4 py-1.5 rounded-full text-sm font-semibold border {{ $badge }}">
                {{ $booking->status_label }}
            </span>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Info Kendaraan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">K</span>
                        Informasi Kendaraan
                    </h3>
                    <div class="flex gap-4">
                        @if($booking->vehicle->image_url)
                            <img src="{{ $booking->vehicle->image_url }}" alt="{{ $booking->vehicle->name }}"
                                 class="w-24 h-20 object-cover rounded-xl flex-shrink-0">
                        @else
                            <div class="w-24 h-20 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 10l1.5-4h13L21 10M3 10h18M3 10v4a1 1 0 001 1h1M21 10v4a1 1 0 01-1 1h-1"/>
                                </svg>
                            </div>
                        @endif
                        <div class="grid grid-cols-2 gap-3 text-sm flex-1">
                            <div><p class="text-gray-400 text-xs mb-0.5">Nama</p><p class="font-medium text-gray-800">{{ $booking->vehicle->name }}</p></div>
                            <div><p class="text-gray-400 text-xs mb-0.5">Jenis</p><p class="font-medium text-gray-800">{{ ucfirst($booking->vehicle->type) }}</p></div>
                            <div><p class="text-gray-400 text-xs mb-0.5">Plat Nomor</p><p class="font-medium text-gray-800">{{ $booking->vehicle->plate_number }}</p></div>
                            <div><p class="text-gray-400 text-xs mb-0.5">Lokasi</p><p class="font-medium text-gray-800">{{ $booking->vehicle->location }}</p></div>
                        </div>
                    </div>
                </div>

                {{-- Info Sewa --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">S</span>
                        Detail Sewa
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-gray-400 text-xs mb-0.5">Tanggal Mulai</p><p class="font-medium text-gray-800">{{ $booking->start_date->format('d M Y') }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Tanggal Selesai</p><p class="font-medium text-gray-800">{{ $booking->end_date->format('d M Y') }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Total Hari</p><p class="font-medium text-gray-800">{{ $booking->total_days }} hari</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Tgl Pemesanan</p><p class="font-medium text-gray-800">{{ $booking->created_at->format('d M Y, H:i') }}</p></div>
                    </div>
                    @if($booking->notes)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-gray-400 text-xs mb-1">Catatan</p>
                            <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- Info Pembayaran --}}
                @if($booking->payment)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold">$</span>
                        Informasi Pembayaran
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-gray-400 text-xs mb-0.5">Metode</p><p class="font-medium text-gray-800">{{ $booking->payment->method_label }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Jumlah</p><p class="font-medium text-gray-800">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</p></div>
                        <div>
                            <p class="text-gray-400 text-xs mb-0.5">Status Pembayaran</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->payment->status === 'verified' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $booking->payment->status === 'verified' ? 'Terverifikasi ✓' : 'Menunggu Verifikasi' }}
                            </span>
                        </div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Dibayar Pada</p><p class="font-medium text-gray-800">{{ $booking->payment->paid_at?->format('d M Y, H:i') ?? '-' }}</p></div>
                    </div>
                    @if($booking->payment->proof_url)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <a href="{{ Storage::url($booking->payment->proof_url) }}" target="_blank"
                               class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat Bukti Pembayaran
                            </a>
                        </div>
                    @endif
                </div>
                @endif

                {{-- Info Pengembalian --}}
                @if($booking->returnLog)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">R</span>
                        Informasi Pengembalian
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-gray-400 text-xs mb-0.5">Dikembalikan</p><p class="font-medium text-gray-800">{{ $booking->returnLog->returned_at->format('d M Y, H:i') }}</p></div>
                        <div>
                            <p class="text-gray-400 text-xs mb-0.5">Denda</p>
                            <p class="font-medium {{ $booking->returnLog->late_fee > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $booking->returnLog->late_fee > 0 ? 'Rp ' . number_format($booking->returnLog->late_fee, 0, ',', '.') : 'Tidak ada denda' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-gray-400 text-xs mb-1">Kondisi Kendaraan</p>
                        <p class="text-sm text-gray-700 bg-gray-50 rounded-lg p-3">{{ $booking->returnLog->condition }}</p>
                    </div>
                </div>
                @endif

                {{-- Form Review --}}
                @if($booking->status === 'completed' && !$sudahReview)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center text-xs font-bold">★</span>
                        Beri Ulasan
                    </h3>
                    <form action="{{ route('reviews.store', $booking) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            {{-- Rating --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                <div class="flex gap-2" id="star-container">
                                    @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating({{ $i }})"
                                            class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition-colors"
                                            data-value="{{ $i }}">★</button>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                                @error('rating')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Komentar --}}
                            <div>
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">
                                    Komentar <span class="text-gray-400 font-normal">(opsional)</span>
                                </label>
                                <textarea id="comment" name="comment" rows="3"
                                          placeholder="Ceritakan pengalaman sewa kendaraan ini..."
                                          class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent resize-none">{{ old('comment') }}</textarea>
                            </div>

                            <button type="submit"
                                    class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
                @elseif($booking->status === 'completed' && $sudahReview)
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 text-center">
                    <p class="text-yellow-700 font-semibold text-sm">★ Kamu sudah memberikan ulasan untuk kendaraan ini</p>
                </div>
                @endif

            </div>

            {{-- Kolom Kanan --}}
            <div class="space-y-5">

                {{-- Rincian Biaya --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Rincian Biaya</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Platform (5%)</span>
                            <span class="font-medium text-orange-600">Rp {{ number_format($booking->platform_fee_amount, 0, ',', '.') }}</span>
                        </div>
                        @if($booking->returnLog && $booking->returnLog->late_fee > 0)
                        <div class="flex justify-between text-gray-600">
                            <span>Denda Keterlambatan</span>
                            <span class="font-medium text-red-600">Rp {{ number_format($booking->returnLog->late_fee, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between font-bold text-gray-900 pt-2.5 border-t border-gray-100 text-base">
                            <span>Total</span>
                            <span class="text-indigo-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Timeline Status --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Status Pemesanan</h3>
                    <div class="space-y-3">
                        @php
                            $steps = [
                                ['label' => 'Booking Dibuat', 'done' => true],
                                ['label' => 'Dikonfirmasi Manager', 'done' => in_array($booking->status, ['confirmed', 'completed'])],
                                ['label' => 'Pembayaran Dikirim', 'done' => $booking->payment !== null],
                                ['label' => 'Pembayaran Diverifikasi', 'done' => $booking->payment && $booking->payment->status === 'verified'],
                                ['label' => 'Selesai', 'done' => $booking->status === 'completed'],
                            ];
                        @endphp
                        @foreach($steps as $step)
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 text-xs font-bold
                                {{ $step['done'] ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                                {{ $step['done'] ? '✓' : '○' }}
                            </div>
                            <span class="text-sm {{ $step['done'] ? 'text-gray-800 font-medium' : 'text-gray-400' }}">
                                {{ $step['label'] }}
                            </span>
                        </div>
                        @endforeach

                        @if($booking->status === 'rejected')
                        <div class="mt-2 bg-red-50 rounded-xl p-3">
                            <p class="text-xs font-semibold text-red-700">Booking Ditolak</p>
                            @if($booking->notes)
                            <p class="text-xs text-red-600 mt-1">Alasan: {{ $booking->notes }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Tombol Bayar --}}
                @if($booking->status === 'confirmed' && !$booking->payment)
                <a href="{{ route('payments.create', $booking) }}"
                   class="flex items-center justify-center gap-2 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    Bayar Sekarang
                </a>
                @endif

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function setRating(value) {
    document.getElementById('rating-input').value = value;
    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.classList.toggle('text-yellow-400', parseInt(btn.dataset.value) <= value);
        btn.classList.toggle('text-gray-300', parseInt(btn.dataset.value) > value);
    });
}
// Restore old rating
const oldRating = {{ old('rating', 0) }};
if (oldRating > 0) setRating(oldRating);
</script>
@endpush
@endsection
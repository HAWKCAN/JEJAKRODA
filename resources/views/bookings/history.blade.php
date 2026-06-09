@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Pemesanan</h1>
                <p class="text-gray-500 text-sm mt-1">Pantau status semua pemesanan kendaraan Anda</p>
            </div>
        </div>

        {{-- Alert --}}
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
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm0-4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabel / Daftar Booking --}}
        @if($bookings->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-gray-500 font-medium">Belum ada pemesanan</p>
                <p class="text-gray-400 text-sm mt-1">Mulai pesan kendaraan untuk perjalanan Anda</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($bookings as $booking)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        {{-- Info Kendaraan --}}
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                @if($booking->vehicle->type === 'motor')
                                    <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-7 8H3a1 1 0 000 2h2v-2zm16 0h-2v2h2a1 1 0 000-2zM7 12a5 5 0 0110 0H7z"/>
                                    </svg>
                                @else
                                    <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 10l1.5-4h13L21 10M3 10h18M3 10v4a1 1 0 001 1h1M21 10v4a1 1 0 01-1 1h-1"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $booking->vehicle->name }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->vehicle->plate_number }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $booking->start_date->format('d M Y') }} — {{ $booking->end_date->format('d M Y') }}
                                    <span class="font-medium">({{ $booking->total_days }} hari)</span>
                                </p>
                            </div>
                        </div>

                        {{-- Status & Aksi --}}
                        <div class="flex flex-col items-start sm:items-end gap-2">
                            @php
                                $colors = [
                                    'pending'   => 'bg-yellow-100 text-yellow-700',
                                    'confirmed' => 'bg-blue-100 text-blue-700',
                                    'rejected'  => 'bg-red-100 text-red-700',
                                    'completed' => 'bg-green-100 text-green-700',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$booking->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $booking->status_label }}
                            </span>
                            <p class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </p>

                            {{-- Tombol bayar jika sudah confirmed tapi belum bayar --}}
                            @if($booking->status === 'confirmed' && !$booking->payment)
                                <a href="{{ route('payments.create', $booking) }}"
                                   class="inline-flex items-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    Bayar Sekarang
                                </a>
                            @endif

                            @if($booking->status === 'confirmed' && $booking->payment)
                                <span class="text-xs text-gray-400 italic">Menunggu verifikasi pembayaran</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
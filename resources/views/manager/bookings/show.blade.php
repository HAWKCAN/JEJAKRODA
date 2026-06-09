@extends('layouts.app')

@section('title', 'Detail Booking #' . $booking->id)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('manager.bookings.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri (2/3) --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Info Kendaraan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">K</span>
                        Informasi Kendaraan
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-gray-400 text-xs mb-0.5">Nama</p><p class="font-medium text-gray-800">{{ $booking->vehicle->name }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Jenis</p><p class="font-medium text-gray-800">{{ ucfirst($booking->vehicle->type) }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Plat Nomor</p><p class="font-medium text-gray-800">{{ $booking->vehicle->plate_number }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Lokasi</p><p class="font-medium text-gray-800">{{ $booking->vehicle->location }}</p></div>
                    </div>
                </div>

                {{-- Info Pelanggan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">P</span>
                        Informasi Pelanggan
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><p class="text-gray-400 text-xs mb-0.5">Nama</p><p class="font-medium text-gray-800">{{ $booking->user->name }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Email</p><p class="font-medium text-gray-800">{{ $booking->user->email }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">No. HP</p><p class="font-medium text-gray-800">{{ $booking->user->phone_number ?? '-' }}</p></div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Tgl Booking</p><p class="font-medium text-gray-800">{{ $booking->created_at->format('d M Y, H:i') }}</p></div>
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
                        <div><p class="text-gray-400 text-xs mb-0.5">Status</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->payment->status === 'verified' ? 'bg-green-100 text-green-700' : ($booking->payment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($booking->payment->status) }}
                            </span>
                        </div>
                        <div><p class="text-gray-400 text-xs mb-0.5">Dibayar Pada</p><p class="font-medium text-gray-800">{{ $booking->payment->paid_at?->format('d M Y, H:i') ?? '-' }}</p></div>
                    </div>
                    @if($booking->payment->proof_url)
                        <div class="mt-3">
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
                        <div><p class="text-gray-400 text-xs mb-0.5">Denda</p>
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
            </div>

            {{-- Kolom Kanan: Ringkasan & Aksi --}}
            <div class="space-y-5">

                {{-- Ringkasan Biaya --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Rincian Biaya</h3>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Periode Sewa</span>
                            <span class="font-medium">{{ $booking->start_date->format('d M') }} - {{ $booking->end_date->format('d M Y') }}</span>
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
                            <span class="font-medium text-orange-600">Rp {{ number_format($booking->platform_fee_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-gray-900 pt-2.5 border-t border-gray-100 text-base">
                            <span>Total</span>
                            <span class="text-indigo-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Panel Aksi Manager --}}
                @if($booking->status === 'pending')
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-4">
                    <h3 class="font-semibold text-gray-800">Tindakan</h3>

                    {{-- Konfirmasi --}}
                    <form action="{{ route('manager.bookings.confirm', $booking) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors"
                                onclick="return confirm('Konfirmasi booking ini?')">
                            ✓ Konfirmasi Booking
                        </button>
                    </form>

                    {{-- Tolak --}}
                    <div>
                        <button type="button" onclick="document.getElementById('reject-form').classList.toggle('hidden')"
                                class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-2.5 rounded-xl text-sm transition-colors border border-red-200">
                            ✕ Tolak Booking
                        </button>

                        <form id="reject-form" action="{{ route('manager.bookings.reject', $booking) }}" method="POST"
                              class="hidden mt-3 space-y-3">
                            @csrf
                            <textarea name="notes" rows="3" placeholder="Tuliskan alasan penolakan..." required
                                      class="w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-red-400 focus:border-transparent resize-none"></textarea>
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                                Kirim Penolakan
                            </button>
                        </form>
                    </div>
                </div>
                @endif

                @if($booking->status === 'confirmed' && !$booking->returnLog)
                <a href="{{ route('manager.returns.create', $booking) }}"
                   class="flex items-center justify-center w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors">
                    Catat Pengembalian
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
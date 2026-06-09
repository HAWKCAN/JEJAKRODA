@extends('layouts.app')

@section('title', 'Manajemen Booking')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Booking</h1>
            <p class="text-gray-500 text-sm mt-1">Konfirmasi atau tolak permintaan pemesanan dari pelanggan</p>
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

        {{-- Tabel Booking --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Pelanggan</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Kendaraan</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Periode</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Total</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-5 py-4 text-sm text-gray-400 font-mono">#{{ $booking->id }}</td>
                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->user->phone_number ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $booking->vehicle->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->vehicle->plate_number }}</p>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-600">
                                {{ $booking->start_date->format('d M Y') }}<br>
                                <span class="text-gray-400">s/d {{ $booking->end_date->format('d M Y') }}</span>
                                <span class="text-xs text-indigo-600 font-medium ml-1">({{ $booking->total_days }}h)</span>
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-gray-900">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4">
                                @php
                                    $badge = [
                                        'pending'   => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'rejected'  => 'bg-red-100 text-red-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                    ][$booking->status] ?? 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ $booking->status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('manager.bookings.show', $booking) }}"
                                       class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                        Detail
                                    </a>

                                    @if($booking->status === 'pending')
                                        <form action="{{ route('manager.bookings.confirm', $booking) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 text-xs font-medium text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors"
                                                    onclick="return confirm('Konfirmasi booking #{{ $booking->id }}?')">
                                                Konfirmasi
                                            </button>
                                        </form>
                                    @endif

                                    @if($booking->status === 'confirmed' && !$booking->returnLog)
                                        <a href="{{ route('manager.returns.create', $booking) }}"
                                           class="inline-flex items-center gap-1 text-xs font-medium text-orange-600 hover:text-orange-800 bg-orange-50 hover:bg-orange-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Kembalikan
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-gray-400 text-sm">
                                Belum ada data booking
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
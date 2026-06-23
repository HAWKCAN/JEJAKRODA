@extends('layouts.manager')

@section('title', 'Laporan Pendapatan')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Pendapatan</h1>
                <p class="text-gray-500 text-sm mt-1">Rekap transaksi kendaraan yang telah selesai</p>
            </div>
            <a href="{{ route('manager.reports.export', request()->all()) }}"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
            <form method="GET" action="{{ route('manager.reports.index') }}"
                  class="flex flex-wrap items-end gap-3">

                {{-- Preset --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Filter Cepat</label>
                    <div class="flex rounded-xl overflow-hidden border border-gray-200">
                        @foreach(['all' => 'Semua', 'daily' => 'Hari Ini', 'monthly' => 'Bulan Ini'] as $val => $label)
                            <a href="{{ route('manager.reports.index', ['filter' => $val]) }}"
                               class="px-4 py-2 text-sm font-medium transition-colors
                                      {{ request('filter', 'all') === $val
                                          ? 'bg-indigo-600 text-white'
                                          : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Range Tanggal --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="rounded-xl border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="rounded-xl border border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-xl text-sm transition-colors">
                    Terapkan
                </button>
            </form>
        </div>

       {{-- Kartu Ringkasan --}}
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $bookings->count() }}</p>
                <p class="text-xs text-gray-400 mt-0.5">booking terverifikasi</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Subtotal Kotor</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">
                    Rp {{ number_format($totalSubtotal, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">sebelum potongan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Potongan Platform</p>
                <p class="text-2xl font-bold text-orange-600 mt-1">
                    Rp {{ number_format($totalFee, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">total fee terkumpul</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pendapatan Bersih</p>
                <p class="text-2xl font-bold text-green-600 mt-1">
                    Rp {{ number_format($totalBersih, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">subtotal - fee platform</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>
        {{-- Grafik Bulanan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
            <h3 class="font-semibold text-gray-800 mb-4">Grafik Pendapatan {{ now()->year }}</h3>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Detail Transaksi</h3>
                <span class="text-sm text-gray-400">{{ $bookings->count() }} data</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Pelanggan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Kendaraan</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Periode</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Subtotal</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Fee (5%)</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-5 py-3.5 text-sm text-gray-400 font-mono">#{{ $booking->id }}</td>
                            <td class="px-5 py-3.5 text-sm font-medium text-gray-900">{{ $booking->user->name }}</td>
                            <td class="px-5 py-3.5 text-sm text-gray-600">{{ $booking->vehicle->name }}</td>
                            <td class="px-5 py-3.5 text-xs text-gray-500">
                                {{ $booking->start_date->format('d M') }} — {{ $booking->end_date->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5 text-sm text-right text-gray-700">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-sm text-right text-orange-500">Rp {{ number_format($booking->platform_fee_amount, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-sm text-right font-semibold text-green-700">
                                Rp {{ number_format($booking->subtotal - $booking->platform_fee_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-gray-400 text-sm">
                                Tidak ada data untuk filter yang dipilih
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const chartData = @json($chartData);

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartData,
                backgroundColor: 'rgba(99, 102, 241, 0.15)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: val => 'Rp ' + (val / 1000000).toFixed(1) + 'jt'
                    },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush
@endsection
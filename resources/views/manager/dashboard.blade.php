@extends('layouts.manager')

@section('title', 'Dashboard — Aspal Seru')

@push('styles')
<style>
    .metric-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem; }
    @media (max-width:1024px) { .metric-grid { grid-template-columns:repeat(2,1fr); } }
    @media (max-width:640px)  { .metric-grid { grid-template-columns:1fr; } }
    .metric-card { background:#fff; border-radius:.75rem; padding:1.25rem; border:1px solid #E2E8F0; }
    .metric-icon { width:2.4rem; height:2.4rem; border-radius:.5rem; display:flex; align-items:center; justify-content:center; margin-bottom:.85rem; }
    .metric-icon svg { width:1.1rem; height:1.1rem; }
    .metric-label { font-size:.73rem; font-weight:600; color:#64748B; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem; }
    .metric-value { font-size:1.6rem; font-weight:800; color:#162740; line-height:1.1; }
    .metric-sub { font-size:.72rem; color:#94A3B8; margin-top:.3rem; }
    .content-grid { display:grid; grid-template-columns:1fr 380px; gap:1rem; margin-bottom:1.5rem; }
    @media (max-width:1100px) { .content-grid { grid-template-columns:1fr; } }
    .card { background:#fff; border-radius:.75rem; border:1px solid #E2E8F0; overflow:hidden; }
    .card-header { padding:1rem 1.25rem; border-bottom:1px solid #F1F5F9; display:flex; align-items:center; justify-content:space-between; }
    .card-title { font-size:.9rem; font-weight:700; color:#162740; }
    .card-body { padding:1.25rem; }
    .chart-wrap { position:relative; height:240px; }
    .item-list { display:flex; flex-direction:column; gap:.5rem; }
    .item-row { display:flex; align-items:center; gap:.75rem; padding:.6rem .75rem; border-radius:.5rem; transition:background .15s; }
    .item-row:hover { background:#F8FAFC; }
    .item-avatar { width:2rem; height:2rem; border-radius:50%; background:#162740; color:#fff; font-size:.7rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .item-name { font-size:.82rem; font-weight:600; color:#1E293B; }
    .item-desc { font-size:.72rem; color:#94A3B8; }
    .item-amount { margin-left:auto; font-size:.82rem; font-weight:700; color:#162740; white-space:nowrap; }
    .status-pill { font-size:.62rem; font-weight:700; padding:.15rem .5rem; border-radius:99px; }
    .status-pending { background:#FEF9C3; color:#CA8A04; }
    .status-confirmed { background:#DBEAFE; color:#1D4ED8; }
    .status-completed { background:#DCFCE7; color:#16A34A; }
    .status-rejected { background:#FEE2E2; color:#DC2626; }
    .rank-badge { width:1.5rem; height:1.5rem; border-radius:.4rem; background:#F1F5F9; color:#64748B; font-size:.7rem; font-weight:700; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
</style>
@endpush

@section('content')

{{-- Banner Verifikasi --}}
@php
    $statusVerifikasi = $rentalOwner ? $rentalOwner->verification_status : 'pending';
    $hasNib = $rentalOwner ? $rentalOwner->nib : null;
@endphp

@if($statusVerifikasi === 'pending' && !$hasNib)
<div style="background:#FEF9C3;border:1px solid #FDE68A;border-radius:.75rem;padding:1rem 1.25rem;
            margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
    <p style="font-size:.83rem;color:#92400E;font-weight:500;">
        Akun Anda belum diverifikasi. Lengkapi dokumen untuk mulai menyewakan kendaraan.
    </p>
    <a href="{{ route('manager.verification.edit') }}"
       style="background:#0EA5E9;color:#fff;padding:.5rem 1rem;border-radius:.5rem;
              font-size:.78rem;font-weight:600;text-decoration:none;white-space:nowrap;">
        Lengkapi Sekarang
    </a>
</div>
@elseif($statusVerifikasi === 'pending')
<div style="background:#FEF9C3;border:1px solid #FDE68A;border-radius:.75rem;padding:1rem 1.25rem;
            margin-bottom:1.25rem;font-size:.83rem;color:#92400E;">
    Dokumen verifikasi sedang diperiksa oleh admin. Mohon tunggu konfirmasi.
</div>
@elseif($statusVerifikasi === 'rejected')
<div style="background:#FEE2E2;border:1px solid #FCA5A5;border-radius:.75rem;padding:1rem 1.25rem;
            margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
    <p style="font-size:.83rem;color:#991B1B;font-weight:500;">
        Verifikasi ditolak. Periksa dan kirim ulang dokumen Anda.
    </p>
    <a href="{{ route('manager.verification.edit') }}"
       style="background:#0EA5E9;color:#fff;padding:.5rem 1rem;border-radius:.5rem;
              font-size:.78rem;font-weight:600;text-decoration:none;white-space:nowrap;">
        Kirim Ulang
    </a>
</div>
@endif

{{-- 4 Metrik Utama --}}
<div class="metric-grid">

    <div class="metric-card">
        <div class="metric-icon" style="background:#EFF6FF;color:#0EA5E9;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 10l1.5-4h13L21 10M3 10h18M3 10v4a1 1 0 001 1h1M21 10v4a1 1 0 01-1 1h-1"/>
            </svg>
        </div>
        <div class="metric-label">Total Armada</div>
        <div class="metric-value">{{ $totalVehicles }}</div>
        <div class="metric-sub">Kendaraan terdaftar</div>
    </div>

    <div class="metric-card">
        <div class="metric-icon" style="background:#F0FDF4;color:#22C55E;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div class="metric-label">Total Booking</div>
        <div class="metric-value">{{ number_format($totalBookings) }}</div>
        <div class="metric-sub">Confirmed & completed</div>
    </div>

    <div class="metric-card">
        <div class="metric-icon" style="background:#FFFBEB;color:#F59E0B;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="metric-label">Menunggu Konfirmasi</div>
        <div class="metric-value">{{ $pendingBookings }}</div>
        <div class="metric-sub">Pesanan baru masuk</div>
    </div>

    <div class="metric-card">
        <div class="metric-icon" style="background:#F5F3FF;color:#8B5CF6;">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a4 4 0 00-8 0v2M5 9h14l1 12H4L5 9z"/>
            </svg>
        </div>
        <div class="metric-label">Pendapatan Bersih</div>
        <div class="metric-value" style="font-size:1.3rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="metric-sub">Setelah potongan platform</div>
    </div>

</div>

{{-- Chart + Pesanan Terbaru --}}
<div class="content-grid">

    <div class="card">
        <div class="card-header">
            <span class="card-title">Pendapatan Bersih per Bulan</span>
            <span style="font-size:.72rem;color:#94A3B8;">6 bulan terakhir</span>
        </div>
        <div class="card-body">
            <div class="chart-wrap">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span class="card-title">Pesanan Terbaru</span>
            <a href="{{ route('manager.bookings.index') }}" style="font-size:.72rem;color:#0EA5E9;font-weight:600;text-decoration:none;">Lihat semua</a>
        </div>
        <div class="card-body" style="padding:.75rem;">
            <div class="item-list">
                @forelse($pesananTerbaru as $p)
                <a href="{{ route('manager.bookings.show', $p) }}" class="item-row" style="text-decoration:none;">
                    <div class="item-avatar">{{ strtoupper(substr($p->user->name ?? '?', 0, 1)) }}</div>
                    <div style="min-width:0;">
                        <div class="item-name">{{ $p->user->name ?? '-' }}</div>
                        <div class="item-desc" style="display:flex;align-items:center;gap:.35rem;">
                            <span class="status-pill status-{{ $p->status }}">{{ ucfirst($p->status) }}</span>
                            <span>{{ $p->vehicle->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="item-amount">Rp {{ number_format($p->total_price, 0, ',', '.') }}</div>
                </a>
                @empty
                <p style="font-size:.8rem;color:#94A3B8;text-align:center;padding:1rem 0;">Belum ada pesanan</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- Kendaraan Paling Laris --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">Kendaraan Paling Laris</span>
        <a href="{{ route('manager.vehicles.index') }}" style="font-size:.72rem;color:#0EA5E9;font-weight:600;text-decoration:none;">Kelola armada</a>
    </div>
    <div class="card-body" style="padding:.75rem;">
        <div class="item-list">
            @forelse($kendaraanLaris as $i => $v)
            <div class="item-row">
                <div class="rank-badge">{{ $i + 1 }}</div>
                <div style="min-width:0;">
                    <div class="item-name">{{ $v->name }}</div>
                    <div class="item-desc">{{ ucfirst($v->type) }} · {{ $v->plate_number }}</div>
                </div>
                <div class="item-amount">{{ $v->total_booking }} booking</div>
            </div>
            @empty
            <p style="font-size:.8rem;color:#94A3B8;text-align:center;padding:1rem 0;">Belum ada data booking kendaraan</p>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
(function () {
    const labels = @json($bulanLabels);
    const data   = @json($revenueData);

    const ctx = document.getElementById('revenueChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, 'rgba(14,165,233,.25)');
    gradient.addColorStop(1, 'rgba(14,165,233,.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Pendapatan Bersih (Rp)',
                data,
                borderColor: '#0EA5E9',
                borderWidth: 2.5,
                backgroundColor: gradient,
                fill: true,
                tension: .4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0EA5E9',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94A3B8' } },
                y: {
                    grid: { color: '#F1F5F9' },
                    ticks: {
                        font: { size: 11 }, color: '#94A3B8',
                        callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1) + 'jt' : v >= 1000 ? (v/1000).toFixed(0) + 'rb' : v),
                    }
                }
            }
        }
    });
})();
</script>
@endpush
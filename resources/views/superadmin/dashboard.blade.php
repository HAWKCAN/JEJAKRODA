@extends('layouts.superAdmin')

@section('title', 'Dashboard — Super Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* ── Metric Cards ── */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1024px) { .metric-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .metric-grid { grid-template-columns: 1fr; } }

    .metric-card {
        background: #fff;
        border-radius: .75rem;
        padding: 1.25rem;
        border: 1px solid #E2E8F0;
        position: relative;
        overflow: hidden;
        transition: box-shadow .2s;
    }
    .metric-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.07); }
    .metric-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
    }
    .metric-card.blue::before   { background: #0EA5E9; }
    .metric-card.green::before  { background: #22C55E; }
    .metric-card.violet::before { background: #8B5CF6; }
    .metric-card.amber::before  { background: #F59E0B; }

    .metric-icon {
        width: 2.4rem; height: 2.4rem;
        border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .85rem;
    }
    .metric-icon svg { width: 1.1rem; height: 1.1rem; }
    .metric-icon.blue   { background: #EFF6FF; color: #0EA5E9; }
    .metric-icon.green  { background: #F0FDF4; color: #22C55E; }
    .metric-icon.violet { background: #F5F3FF; color: #8B5CF6; }
    .metric-icon.amber  { background: #FFFBEB; color: #F59E0B; }

    .metric-label { font-size: .73rem; font-weight: 600; color: #64748B;
                    text-transform: uppercase; letter-spacing: .05em; margin-bottom: .3rem; }
    .metric-value { font-size: 1.6rem; font-weight: 800; color: #162740; line-height: 1.1; }
    .metric-sub   { font-size: .72rem; color: #94A3B8; margin-top: .3rem; }

    /* ── Content grid ── */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1100px) { .content-grid { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .card {
        background: #fff;
        border-radius: .75rem;
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }
    .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #F1F5F9;
        display: flex; align-items: center; justify-content: space-between;
    }
    .card-title { font-size: .9rem; font-weight: 700; color: #162740; }
    .card-body  { padding: 1.25rem; }

    /* ── Chart ── */
    .chart-wrap { position: relative; height: 240px; }

    /* ── Tabel Manager ── */
    .manager-table { width: 100%; border-collapse: collapse; }
    .manager-table th {
        font-size: .68rem; font-weight: 700; color: #64748B;
        text-transform: uppercase; letter-spacing: .05em;
        padding: .6rem .85rem; background: #F8FAFC;
        text-align: left; border-bottom: 1px solid #E2E8F0;
    }
    .manager-table td {
        padding: .75rem .85rem;
        font-size: .82rem; color: #1E293B;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }
    .manager-table tr:last-child td { border-bottom: none; }
    .manager-table tr:hover td { background: #F8FAFC; }

    .badge {
        display: inline-flex; align-items: center;
        padding: .2rem .6rem; border-radius: 99px;
        font-size: .67rem; font-weight: 700;
    }
    .badge-verified { background: #DCFCE7; color: #16A34A; }
    .badge-pending  { background: #FEF9C3; color: #CA8A04; }
    .badge-rejected { background: #FEE2E2; color: #DC2626; }

    .disbursed-ok   { color: #16A34A; font-weight: 700; }
    .disbursed-wait { color: #F59E0B; font-weight: 700; }

    /* ── Transaksi terbaru ── */
    .tx-list { display: flex; flex-direction: column; gap: .5rem; }
    .tx-item {
        display: flex; align-items: center; gap: .75rem;
        padding: .6rem .75rem; border-radius: .5rem;
        transition: background .15s;
    }
    .tx-item:hover { background: #F8FAFC; }
    .tx-avatar {
        width: 2rem; height: 2rem; border-radius: 50%;
        background: #162740; color: #fff;
        font-size: .7rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .tx-name  { font-size: .82rem; font-weight: 600; color: #1E293B; }
    .tx-desc  { font-size: .72rem; color: #94A3B8; }
    .tx-amount{ margin-left:auto; font-size: .82rem; font-weight: 700; color: #162740; white-space:nowrap; }

    .status-pill {
        font-size: .62rem; font-weight: 700;
        padding: .15rem .5rem; border-radius: 99px;
    }
    .status-pending   { background: #FEF9C3; color: #CA8A04; }
    .status-confirmed { background: #DBEAFE; color: #1D4ED8; }
    .status-completed { background: #DCFCE7; color: #16A34A; }
    .status-rejected  { background: #FEE2E2; color: #DC2626; }
</style>
@endpush

@section('content')

{{-- ── 4 Metrik Utama ── --}}
<div class="metric-grid">

    <div class="metric-card blue">
        <div class="metric-icon blue">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div class="metric-label">Total Transaksi</div>
        <div class="metric-value">{{ number_format($totalTransaksi) }}</div>
        <div class="metric-sub">Booking confirmed & completed</div>
    </div>

    <div class="metric-card green">
        <div class="metric-icon green">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="metric-label">Total Fee Terkumpul</div>
        <div class="metric-value">Rp {{ number_format($totalFee, 0, ',', '.') }}</div>
        <div class="metric-sub">Dari payment verified</div>
    </div>

    <div class="metric-card violet">
        <div class="metric-icon violet">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <div class="metric-label">Revenue Platform</div>
        <div class="metric-value">Rp {{ number_format($totalRevenuePlatform, 0, ',', '.') }}</div>
        <div class="metric-sub">Total payment masuk</div>
    </div>

    <div class="metric-card amber">
        <div class="metric-icon amber">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="metric-label">Total Manager</div>
        <div class="metric-value">{{ number_format($totalManager) }}</div>
        <div class="metric-sub">Rental owner terdaftar</div>
    </div>

</div>

{{-- ── Chart + Transaksi Terbaru ── --}}
<div class="content-grid">

    {{-- Grafik Fee Bulanan --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Fee Platform per Bulan</span>
            <span style="font-size:.72rem;color:#94A3B8;">12 bulan terakhir</span>
        </div>
        <div class="card-body">
            <div class="chart-wrap">
                <canvas id="feeChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Transaksi Terbaru</span>
            <a href="{{ url('superadmin/users') }}" style="font-size:.72rem;color:#0EA5E9;font-weight:600;">Lihat semua</a>
        </div>
        <div class="card-body" style="padding:.75rem;">
            <div class="tx-list">
                @forelse($transaksiTerbaru as $tx)
                <div class="tx-item">
                    <div class="tx-avatar">
                        {{ strtoupper(substr($tx->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div style="min-width:0;">
                        <div class="tx-name">{{ $tx->user->name ?? '-' }}</div>
                        <div class="tx-desc" style="display:flex;align-items:center;gap:.35rem;">
                            <span class="status-pill status-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span>
                            <span>{{ $tx->start_date->format('d M') }}</span>
                        </div>
                    </div>
                    <div class="tx-amount">Rp {{ number_format($tx->total_price, 0, ',', '.') }}</div>
                </div>
                @empty
                <p style="font-size:.8rem;color:#94A3B8;text-align:center;padding:1rem 0;">
                    Belum ada transaksi
                </p>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ── Tabel Disbursement per Manager ── --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">Pendapatan per Manager</span>
        <span style="font-size:.72rem;color:#94A3B8;">{{ count($tabelManager) }} manager</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="manager-table">
            <thead>
                <tr>
                    <th>Manager</th>
                    <th>Bisnis</th>
                    <th>Status</th>
                    <th>Kendaraan</th>
                    <th>Booking</th>
                    <th>Fee Platform</th>
                    <th>Pendapatan Manager</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tabelManager as $row)
                <tr>
                    <td><div style="font-weight:600;">{{ $row['nama'] }}</div></td>
                    <td>{{ $row['bisnis'] }}</td>
                    <td>
                        <span class="badge badge-{{ $row['status'] === 'verified' ? 'verified' : ($row['status'] === 'rejected' ? 'rejected' : 'pending') }}">
                            {{ ucfirst($row['status']) }}
                        </span>
                    </td>
                    <td style="text-align:center;">{{ $row['total_kendaraan'] }}</td>
                    <td style="text-align:center;">{{ $row['total_booking'] }}</td>
                    <td class="disbursed-ok">Rp {{ number_format($row['total_fee'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row['total_pendapatan'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#94A3B8;padding:2rem;">
                        Belum ada data manager
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const labels = @json($bulanLabels);
    const data   = @json($feeData);

    const ctx = document.getElementById('feeChart').getContext('2d');

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0,   'rgba(14,165,233,.25)');
    gradient.addColorStop(1,   'rgba(14,165,233,.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Fee Platform (Rp)',
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
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' Rp ' + Number(ctx.parsed.y).toLocaleString('id-ID'),
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#94A3B8',
                    }
                },
                y: {
                    grid: { color: '#F1F5F9', drawBorder: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#94A3B8',
                        callback: v => 'Rp ' + (v >= 1000000
                            ? (v/1000000).toFixed(1) + 'jt'
                            : v >= 1000 ? (v/1000).toFixed(0) + 'rb' : v),
                    }
                }
            }
        }
    });
})();
</script>
@endpush

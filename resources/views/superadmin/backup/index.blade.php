@extends('layouts.superAdmin')

@section('title', 'Backup Database')
@section('page-title', 'Backup Database')

@push('styles')
<style>
    :root {
        --navy: #162740;
        --sky:  #0EA5E9;
        --sky-dk: #0284C7;
        --green: #22C55E;
        --amber: #F59E0B;
        --red:  #DC2626;
        --muted: #64748B;
        --border: #E2E8F0;
    }
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

    .metric-card {
        background: #fff;
        border-radius: .75rem;
        padding: 1.25rem;
        border: 1px solid #E2E8F0;
        position: relative;
        overflow: hidden;
    }
    .metric-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
    }
    .metric-card.blue::before  { background: #0EA5E9; }
    .metric-card.green::before { background: #22C55E; }
    .metric-icon {
        width: 2.4rem; height: 2.4rem;
        border-radius: .5rem;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: .85rem;
    }
    .metric-icon svg { width: 1.1rem; height: 1.1rem; }
    .metric-icon.blue  { background: #EFF6FF; color: #0EA5E9; }
    .metric-icon.green { background: #F0FDF4; color: #22C55E; }
    .metric-label { font-size: .73rem; font-weight: 600; color: #64748B;
                    text-transform: uppercase; letter-spacing: .05em; margin-bottom: .3rem; }
    .metric-value { font-size: 1.5rem; font-weight: 800; color: #162740; line-height: 1.1; }
    .metric-sub   { font-size: .72rem; color: #94A3B8; margin-top: .3rem; }

    .backup-table { width: 100%; border-collapse: collapse; }
    .backup-table th {
        font-size: .68rem; font-weight: 700; color: #64748B;
        text-transform: uppercase; letter-spacing: .05em;
        padding: .6rem .85rem; background: #F8FAFC;
        text-align: left; border-bottom: 1px solid #E2E8F0;
    }
    .backup-table td {
        padding: .75rem .85rem;
        font-size: .82rem; color: #1E293B;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }
    .backup-table tr:last-child td { border-bottom: none; }
    .backup-table tr:hover td { background: #F8FAFC; }

    .btn-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 2rem; height: 2rem; border-radius: .5rem;
        border: 1px solid var(--border); background: #fff;
        cursor: pointer; transition: background .15s;
    }
    .btn-icon:hover { background: #F1F5F9; }
    .btn-icon.danger:hover { background: #FEF2F2; border-color: #FECACA; }

    .info-box {
        border-radius: .75rem;
        padding: 1rem;
        font-size: .8rem;
        border: 1px solid;
    }
    .info-box.blue    { background: #EFF6FF; border-color: #BAE6FD; color: #0284C7; }
    .info-box.amber   { background: #FFFBEB; border-color: #FDE68A; color: #F59E0B; }
    .info-box.success { background: #F0FDF4; border-color: #BBF7D0; color: #22C55E; }
    .info-box.danger  { background: #FEF2F2; border-color: #FECACA; color: #DC2626; }
</style>
@endpush

@section('content')

{{-- ── Metrik Ringkas ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="metric-card blue">
        <div class="metric-icon blue">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div class="metric-label">Total Backup</div>
        <div class="metric-value">{{ count($backups) }}</div>
        <div class="metric-sub">File backup tersimpan</div>
    </div>

    <div class="metric-card green">
        <div class="metric-icon green">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="metric-label">Backup Terakhir</div>
        <div class="metric-value" style="font-size:1.1rem;">{{ $backups[0]['date'] ?? 'Belum ada' }}</div>
        <div class="metric-sub">{{ $backups[0]['filename'] ?? '-' }}</div>
    </div>
</div>

{{-- ── Alert ── --}}
@if(session('success'))
<div class="info-box success mb-4">
    <strong>Backup Berhasil</strong> — {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="info-box danger mb-4">
    <strong>Backup Gagal</strong> — {{ session('error') }}
</div>
@endif

{{-- ── Aksi Backup ── --}}
<div class="card mb-6">
    <div class="card-header">
        <span class="card-title">Jalankan Backup</span>
        <span style="font-size:.72rem;color:#94A3B8;">Database only</span>
    </div>
    <div class="card-body">
        <div class="info-box blue mb-4">
            Backup hanya menyimpan database (tanpa file media). File tersimpan di server dan dapat diunduh dari tabel riwayat di bawah.
        </div>

        <form action="{{ route('superadmin.backup.run') }}" method="POST" onsubmit="return confirmBackup()">
            @csrf
            <button type="submit" id="backup-btn"
                    style="background:var(--sky);"
                    class="w-full flex items-center justify-center gap-2.5 hover:opacity-90
                           text-white font-semibold py-3 rounded-xl transition-opacity text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                </svg>
                Jalankan Backup Sekarang
            </button>
        </form>

        <div class="info-box amber mt-4">
            <strong>Perhatian</strong> — proses backup berjalan langsung di server dan bisa memakan waktu beberapa detik hingga menit, tergantung ukuran database.
        </div>
    </div>
</div>

{{-- ── Riwayat Backup ── --}}
<div class="card">
    <div class="card-header">
        <span class="card-title">Riwayat Backup</span>
        <span style="font-size:.72rem;color:#94A3B8;">{{ count($backups) }} file</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="backup-table">
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Ukuran</th>
                    <th>Tanggal</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($backups as $backup)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <svg class="w-4 h-4" style="color:#94A3B8;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span style="font-weight:600;">{{ $backup['filename'] }}</span>
                        </div>
                    </td>
                    <td>{{ $backup['size'] }}</td>
                    <td>{{ $backup['date'] }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex;justify-content:flex-end;gap:.4rem;">
                            <a href="{{ route('superadmin.backup.download', $backup['filename']) }}"
                               class="btn-icon" title="Download">
                                <svg class="w-4 h-4" style="color:#0EA5E9;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </a>
                            <form action="{{ route('superadmin.backup.destroy', $backup['filename']) }}" method="POST"
                                  onsubmit="return confirm('Hapus backup ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon danger" title="Hapus">
                                    <svg class="w-4 h-4" style="color:#DC2626;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;color:#94A3B8;padding:2rem;">
                        Belum ada backup yang dijalankan
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
    function confirmBackup() {
        const confirmed = confirm('Jalankan backup database sekarang?');
        if (confirmed) {
            const btn = document.getElementById('backup-btn');
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Sedang Memproses...';
            btn.disabled = true;
        }
        return confirmed;
    }
</script>
@endpush
@extends('layouts.superAdmin')

@section('title', 'Log Aktivitas — Super Admin')
@section('page-title', 'Log Aktivitas Sistem')

@section('content')

<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Waktu</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">User</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Aksi</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Tipe</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr style="border-bottom:1px solid #F1F5F9;">
                    <td style="padding:.75rem 1rem;font-size:.78rem;color:#64748B;">
                        {{ $log->created_at->format('d M Y, H:i') }}
                    </td>
                    <td style="padding:.75rem 1rem;font-size:.83rem;color:#1E293B;">
                        {{ $log->causer->name ?? 'Sistem' }}
                    </td>
                    <td style="padding:.75rem 1rem;font-size:.83rem;color:#1E293B;">
                        {{ $log->description }}
                    </td>
                    <td style="padding:.75rem 1rem;">
                        <span style="background:#F1F5F9;color:#475569;font-size:.67rem;
                                     font-weight:700;padding:.2rem .6rem;border-radius:99px;">
                            {{ $log->log_name }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:2rem;color:#94A3B8;font-size:.85rem;">
                        Belum ada aktivitas tercatat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
    <div style="padding:.85rem 1rem;border-top:1px solid #F1F5F9;">
        {{ $logs->links() }}
    </div>
    @endif

</div>

@endsection
@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div style="max-width:680px;margin:2rem auto;padding:0 1rem;">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
        <span style="font-size:1rem;font-weight:700;color:#162740;">Semua Notifikasi</span>
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit"
                style="background:#F1F5F9;color:#475569;border:none;border-radius:.5rem;
                       padding:.4rem .85rem;font-size:.75rem;font-weight:600;cursor:pointer;">
                Tandai Semua Dibaca
            </button>
        </form>
    </div>

    <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
        @forelse($notifications as $notif)
        @php
            $data = $notif->data;
            $typeColor = match($data['type'] ?? 'system') {
                'booking' => ['bg'=>'#DBEAFE','color'=>'#1D4ED8','icon'=>'📋'],
                'payment' => ['bg'=>'#DCFCE7','color'=>'#16A34A','icon'=>'💰'],
                'return'  => ['bg'=>'#FEF9C3','color'=>'#CA8A04','icon'=>'🔄'],
                default   => ['bg'=>'#F1F5F9','color'=>'#64748B','icon'=>'🔔'],
            };
        @endphp
        <a href="{{ $data['url'] ?? '#' }}"
           style="display:flex;gap:.85rem;align-items:flex-start;padding:1rem 1.25rem;
                  border-bottom:1px solid #F1F5F9;text-decoration:none;
                  background:{{ $notif->read_at ? '#fff' : '#F8FAFF' }};
                  transition:background .15s;">

            {{-- Icon --}}
            <div style="width:2.2rem;height:2.2rem;border-radius:50%;flex-shrink:0;
                        background:{{ $typeColor['bg'] }};
                        display:flex;align-items:center;justify-content:center;font-size:.9rem;">
                {{ $typeColor['icon'] }}
            </div>

            {{-- Isi --}}
            <div style="flex:1;min-width:0;">
                <div style="font-size:.85rem;font-weight:{{ $notif->read_at ? '600' : '700' }};
                            color:#1E293B;margin-bottom:.2rem;">
                    {{ $data['title'] ?? '-' }}
                </div>
                <div style="font-size:.78rem;color:#475569;margin-bottom:.3rem;">
                    {{ $data['message'] ?? '-' }}
                </div>
                <div style="font-size:.7rem;color:#94A3B8;">
                    {{ $notif->created_at->diffForHumans() }}
                </div>
            </div>

            {{-- Unread dot --}}
            @if(!$notif->read_at)
            <div style="width:.5rem;height:.5rem;border-radius:50%;
                        background:#0EA5E9;flex-shrink:0;margin-top:.4rem;"></div>
            @endif

        </a>
        @empty
        <div style="padding:3rem;text-align:center;color:#94A3B8;font-size:.85rem;">
            🔔 Belum ada notifikasi
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($notifications->hasPages())
    <div style="margin-top:1rem;">
        {{ $notifications->links() }}
    </div>
    @endif

</div>
@endsection
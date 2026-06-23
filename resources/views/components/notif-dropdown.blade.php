@php $wrapperId = $wrapperId ?? 'notif-wrapper'; @endphp

<div id="notif-dd-{{ $wrapperId }}"
    style="display:none;position:absolute;right:0;top:calc(100% + .5rem);
           width:320px;background:#fff;border:1px solid #E2E8F0;
           border-radius:.75rem;box-shadow:0 8px 24px rgba(0,0,0,.1);
           z-index:999;overflow:hidden;">

    <div style="padding:.85rem 1rem;border-bottom:1px solid #F1F5F9;
                display:flex;align-items:center;justify-content:space-between;">
        <span style="font-size:.85rem;font-weight:700;color:#162740;">
            Notifikasi
            @if($unread > 0)
            <span style="background:#EF4444;color:#fff;font-size:.6rem;
                         padding:.1rem .4rem;border-radius:99px;margin-left:.3rem;">
                {{ $unread }}
            </span>
            @endif
        </span>
        @if($unread > 0)
        <form method="POST" action="{{ route('notifications.readAll') }}" style="display:inline;">
            @csrf
            <button type="submit"
                style="background:none;border:none;color:#0EA5E9;
                       font-size:.72rem;font-weight:600;cursor:pointer;">
                Tandai semua dibaca
            </button>
        </form>
        @endif
    </div>

    <div style="max-height:320px;overflow-y:auto;">
        @forelse($notifList as $notif)
        @php
            $data = $notif->data;
            $icon = match($data['type'] ?? 'system') {
                'booking' => '📋',
                'payment' => '💰',
                'return'  => '🔄',
                default   => '🔔',
            };
        @endphp
        <a href="{{ $data['url'] ?? '#' }}"
           style="display:flex;gap:.75rem;align-items:flex-start;
                  padding:.85rem 1rem;border-bottom:1px solid #F1F5F9;
                  text-decoration:none;
                  background:{{ $notif->read_at ? '#fff' : '#F8FAFF' }};">
            <span style="font-size:1rem;flex-shrink:0;margin-top:.1rem;">{{ $icon }}</span>
            <div style="min-width:0;flex:1;">
                <div style="font-size:.78rem;font-weight:{{ $notif->read_at ? '600' : '700' }};
                            color:#1E293B;margin-bottom:.15rem;">
                    {{ $data['title'] ?? '-' }}
                </div>
                <div style="font-size:.72rem;color:#64748B;
                            white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $data['message'] ?? '-' }}
                </div>
                <div style="font-size:.68rem;color:#94A3B8;margin-top:.2rem;">
                    {{ $notif->created_at->diffForHumans() }}
                </div>
            </div>
            @if(!$notif->read_at)
            <div style="width:.4rem;height:.4rem;border-radius:50%;
                        background:#0EA5E9;flex-shrink:0;margin-top:.4rem;"></div>
            @endif
        </a>
        @empty
        <div style="padding:2rem;text-align:center;color:#94A3B8;font-size:.8rem;">
            Belum ada notifikasi
        </div>
        @endforelse
    </div>

    <a href="{{ route('notifications.index') }}"
       style="display:block;padding:.75rem;text-align:center;
              font-size:.78rem;font-weight:600;color:#0EA5E9;
              text-decoration:none;border-top:1px solid #F1F5F9;background:#FAFAFA;">
        Lihat semua notifikasi →
    </a>
</div>
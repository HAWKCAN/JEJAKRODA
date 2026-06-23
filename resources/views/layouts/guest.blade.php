
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aspal Seru — Sewa Kendaraan Purwokerto')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ── Warna utama (hex tetap) ── */
        :root {
            --navy:   #162740;
            --sky:    #0EA5E9;
            --sky-dk: #0284C7;
            --slate:  #F8FAFC;
            --text:   #1E293B;
            --muted:  #64748B;
            --border: #E2E8F0;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            padding-bottom: 5rem; /* ruang bottom nav mobile */
        }
        .no-scroll::-webkit-scrollbar { display: none; }
        .no-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body>

    {{--  MOBILE --}}
    <div class="md:hidden sticky top-0 z-40">
        <div class="flex justify-between items-center px-4 py-3 shadow-md"
             style="background:#162740;">
            <h1 class="font-extrabold text-lg text-white">Aspal Seru</h1>
            <div class="flex flex-col gap-1.5 cursor-pointer">
                <span class="block w-6 h-0.5 rounded" style="background:rgba(255,255,255,.8);"></span>
                <span class="block w-6 h-0.5 rounded" style="background:rgba(255,255,255,.8);"></span>
                <span class="block w-4 h-0.5 rounded ml-auto" style="background:rgba(255,255,255,.8);"></span>
            </div>
        </div>

        {{-- Search + filter chip — hanya muncul di halaman katalog --}}
        @hasSection('show-search')
        <div class="px-4 py-3 border-b shadow-sm" style="background:#FFFFFF; border-color:#E2E8F0;">
            <p class="text-xs mb-2" style="color:#64748B;">Beranda / Katalog</p>
            <div class="flex gap-2 mb-3">
                <input type="text" placeholder="Cari kendaraan..."
                       class="flex-1 rounded-lg px-4 py-2 text-sm outline-none border"
                       style="background:#F8FAFC; border-color:#E2E8F0;">
                <button class="px-5 py-2 rounded-lg text-sm font-semibold text-white"
                        style="background:#0EA5E9;">Cari</button>
            </div>
            <div class="flex gap-2 overflow-x-auto pb-1 no-scroll">
                <button class="px-4 py-1.5 rounded-full text-xs font-semibold text-white whitespace-nowrap"
                        style="background:#0EA5E9;">Semua</button>
                <button class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border"
                        style="border-color:#CBD5E1; color:#64748B;">Motor</button>
                <button class="px-4 py-1.5 rounded-full text-xs font-medium whitespace-nowrap border"
                        style="border-color:#CBD5E1; color:#64748B;">Mobil</button>
            </div>
        </div>
        @endif
    </div>


    {{-- DESKTOP: GUEST --}}
    <nav class="hidden md:flex justify-between items-center px-8 py-4 border-b"
         style="background:#FFFFFF; border-color:#E2E8F0;">
        <div class="flex items-center gap-12">
            <div>
                <h1 class="font-extrabold text-2xl leading-tight" style="color:#162740;">Aspal Seru</h1>
                <p class="text-[10px] font-bold tracking-[.2em] uppercase" style="color:#0EA5E9;">Purwokerto</p>
            </div>
            <div class="flex gap-8 text-sm font-semibold" style="color:#64748B;">
                <a href="/" class="border-b-2 pb-0.5" style="color:#162740; border-color:#162740;">Katalog</a>
                <a href="#cara-sewa" class="hover:opacity-80 transition-opacity">Cara Sewa</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" placeholder="Cari kendaraan, tipe..."
                       class="rounded-full pl-4 pr-10 py-2 text-sm w-64 outline-none border"
                       style="background:#F1F5F9; border-color:transparent;">
                <span class="absolute right-3 top-1.5 text-xl font-bold" style="color:#0EA5E9;">⌕</span>
            </div>
            <a href="{{ route('login') }}"
               class="text-sm font-semibold hover:opacity-75 transition-opacity"
               style="color:#1E293B;">Masuk</a>
            <a href="{{ route('register') }}"
               class="text-sm font-semibold px-5 py-2 rounded-md text-white shadow-sm"
               style="background:#162740;">Daftar</a>
            <a href="{{ route('login') }}"
               class="text-sm font-semibold px-5 py-2 rounded-md text-white shadow-sm"
               style="background:#0EA5E9;">+ Sewa Kini</a>
        </div>
    </nav>


    {{--  ISI HALAMAN --}}
    @yield('content')


    {{--  MOBILE:  GUEST --}}
    <nav class="md:hidden fixed bottom-0 left-0 right-0 flex justify-around py-3 px-2 z-50 border-t"
         style="background:#FFFFFF; border-color:#E2E8F0; box-shadow:0 -4px 6px -1px rgba(0,0,0,.05);">

        <a href="/" class="flex flex-col items-center gap-1 px-5 py-1.5 rounded-xl" style="background:#EFF6FF;">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="#0EA5E9">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7A1 1 0 003 11h1v7a1 1 0 001 1h4v-5h2v5h4a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-7-7z"/>
            </svg>
            <span class="text-[10px] font-bold" style="color:#0EA5E9;">Beranda</span>
        </a>

        <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 px-5 py-1.5" style="color:#94A3B8;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            <span class="text-[10px] font-medium">Masuk</span>
        </a>

        <a href="{{ route('register') }}" class="flex flex-col items-center gap-1 px-5 py-1.5" style="color:#94A3B8;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            <span class="text-[10px] font-medium">Daftar</span>
        </a>

    </nav>

    @stack('scripts')
</body>
</html>
@php
    $unread = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
    $notifList = auth()->check() ? auth()->user()->notifications()->latest()->take(5)->get() : collect();
@endphp

<div style="position:relative;" id="notif-wrapper">

    {{-- Bell Button --}}
    <button onclick="toggleNotif(event)"
        style="background:none;border:none;cursor:pointer;
               position:relative;padding:.4rem;
               display:flex;align-items:center;">
        <svg width="20" height="20" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11
                     a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5
                     m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @if($unread > 0)
        <span style="position:absolute;top:0;right:0;
                     background:#EF4444;color:#fff;
                     font-size:.55rem;font-weight:700;
                     padding:.1rem .3rem;border-radius:99px;
                     min-width:.9rem;text-align:center;line-height:1.4;">
            {{ $unread > 9 ? '9+' : $unread }}
        </span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div id="notif-dropdown"
        style="display:none;position:absolute;right:0;top:calc(100% + .5rem);
               width:320px;background:#fff;border:1px solid #E2E8F0;
               border-radius:.75rem;box-shadow:0 8px 24px rgba(0,0,0,.1);
               z-index:999;overflow:hidden;">

        {{-- Header --}}
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
            <form method="POST" action="{{ route('notifications.readAll') }}"
                  style="display:inline;">
                @csrf
                <button type="submit"
                    style="background:none;border:none;color:#0EA5E9;
                           font-size:.72rem;font-weight:600;cursor:pointer;">
                    Tandai semua dibaca
                </button>
            </form>
            @endif
        </div>

        {{-- List --}}
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
                      background:{{ $notif->read_at ? '#fff' : '#F8FAFF' }};
                      transition:background .15s;">
                <span style="font-size:1rem;flex-shrink:0;margin-top:.1rem;">
                    {{ $icon }}
                </span>
                <div style="min-width:0;">
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

        {{-- Footer --}}
        <a href="{{ route('notifications.index') }}"
           style="display:block;padding:.75rem;text-align:center;
                  font-size:.78rem;font-weight:600;color:#0EA5E9;
                  text-decoration:none;border-top:1px solid #F1F5F9;
                  background:#FAFAFA;">
            Lihat semua notifikasi →
        </a>

    </div>
</div>

<script>
function toggleNotif(e) {
    e.stopPropagation();
    const dd = document.getElementById('notif-dropdown');
    dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
}
// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('notif-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('notif-dropdown').style.display = 'none';
    }
});
</script>
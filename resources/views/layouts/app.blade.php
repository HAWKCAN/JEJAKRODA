@php 
    $styleaktif = 'text-[#162740] border-b-2 border-b-[#162740] pb-1 hover:text-[#4677bf] transition-colors';
    $stylepasif = 'text-[#64748B] hover:opacity-80 transition-opacity';
    $styleprofilaktif = 'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white ring-2 ring-offset-2 ring-[#162740] transition-all';
    $styleprofilpasif = 'w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white hover:opacity-80 transition-all';

@endphp


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard — Aspal Seru')</title>
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

    {{--   MOBILE:  USER  --}}
    <div class="md:hidden sticky top-0 z-40">
        <div class="flex justify-between items-center px-4 py-3 shadow-md"
             style="background:#162740;">
            <div>
                <h1 class="font-extrabold text-base text-white">Aspal Seru</h1>
                <p class="text-[11px]" style="color:#7DD3FC;">
                    Halo, {{ auth()->user()->name }} 👋
                </p>
            </div>
            {{-- Notif bell dengan badge --}}
            <div class="relative cursor-pointer">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute -top-1 -right-1 w-4 h-4 text-[9px] font-bold text-white rounded-full flex items-center justify-center"
                      style="background:#EF4444;">2</span>
            </div>
        </div>

        {{-- Search + filter chip — opsional per halaman --}}
        @hasSection('show-search')
        <div class="px-4 py-3 border-b shadow-sm" style="background:#FFFFFF; border-color:#E2E8F0;">
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


    {{--  DESKTOP: USER  --}}
    <nav class="hidden md:flex justify-between items-center px-8 py-4 border-b"
         style="background:#FFFFFF; border-color:#E2E8F0;">
        <div class="flex items-center gap-12">
            <div>
                <h1 class="font-extrabold text-2xl leading-tight" style="color:#162740;">Aspal Seru</h1>
                <p class="text-[10px] font-bold tracking-[.2em] uppercase" style="color:#0EA5E9;">Purwokerto</p>
            </div>
            <div class="flex gap-8 text-sm font-semibold" style="color:#64748B;">
                <a href="/dashboard" class="{{ request()->is('dashboard') ? $styleaktif : $stylepasif }}">Katalog</a>
                <a href="/riwayat"   class="{{ request()->is('riwayat') ? $styleaktif : $stylepasif }}">Riwayat</a>
                <a href="#kontak"    class="{{ request()->is('kontak') ? $styleaktif : $stylepasif }}">Kontak</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" placeholder="Cari kendaraan, tipe..."
                       class="rounded-full pl-4 pr-10 py-2 text-sm w-64 outline-none border"
                       style="background:#F1F5F9; border-color:transparent;">
                <span class="absolute right-3 top-1.5 text-xl font-bold" style="color:#0EA5E9;">⌕</span>
            </div>

            {{-- Notif bell --}}
            <div class="relative cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="#64748B" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 text-[8px] font-bold text-white rounded-full flex items-center justify-center"
                      style="background:#EF4444;">2</span>
            </div>

            {{-- Avatar inisial + nama user --}}
            <div class="flex items-center gap-2 cursor-pointer">
                
            <a href="/profile">
                <div class="{{ request()->is('profile') ? $styleprofilaktif : $styleprofilpasif }}"
                     style="background:#162740;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </a>
                <span class="text-sm font-semibold" style="color:#1E293B;">{{ auth()->user()->name }}</span>
                <span style="color:#94A3B8;">▾</span>
            </div>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-sm font-semibold px-5 py-2 rounded-md border hover:opacity-75 transition-opacity"
                        style="color:#EF4444; border-color:#FECACA;">
                    Keluar
                </button>
            </form>
        </div>
    </nav>


    {{-- ISI HALAMAN --}}
    @yield('content')


    {{-- MOBILE--}}
 <nav class="md:hidden fixed bottom-0 left-0 right-0 flex justify-around py-3 px-2 z-50 border-t bg-white"
     style="border-color:#E2E8F0; box-shadow:0 -4px 6px -1px rgba(0,0,0,.05);">

    <a href="/dashboard"
       class="flex flex-col items-center gap-1 px-5 py-1.5 rounded-xl transition-colors {{ request()->is('dashboard') ? 'bg-[#EFF6FF] text-[#0EA5E9]' : 'text-[#94A3B8] hover:bg-slate-50' }}">
        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7A1 1 0 003 11h1v7a1 1 0 001 1h4v-5h2v5h4a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-7-7z"/>
        </svg>
        <span class="text-[10px] {{ request()->is('dashboard') ? 'font-bold' : 'font-medium' }}">Beranda</span>
    </a>

    <a href="/booking" 
       class="flex flex-col items-center gap-1 px-5 py-1.5 rounded-xl transition-colors {{ request()->is('booking') ? 'bg-[#EFF6FF] text-[#0EA5E9]' : 'text-[#94A3B8] hover:bg-slate-50' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <span class="text-[10px] {{ request()->is('booking') ? 'font-bold' : 'font-medium' }}">Pesan</span>
    </a>

    <a href="/riwayat" 
       class="flex flex-col items-center gap-1 px-5 py-1.5 rounded-xl transition-colors {{ request()->is('riwayat') ? 'bg-[#EFF6FF] text-[#0EA5E9]' : 'text-[#94A3B8] hover:bg-slate-50' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="text-[10px] {{ request()->is('riwayat') ? 'font-bold' : 'font-medium' }}">Riwayat</span>
    </a>

    <a href="/profile" 
       class="flex flex-col items-center gap-1 px-5 py-1.5 rounded-xl transition-colors {{ request()->is('profile') ? 'bg-[#EFF6FF] text-[#0EA5E9]' : 'text-[#94A3B8] hover:bg-slate-50' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        <span class="text-[10px] {{ request()->is('profile') ? 'font-bold' : 'font-medium' }}">Profil</span>
    </a>

</nav>

    @stack('scripts')
</body>
</html>
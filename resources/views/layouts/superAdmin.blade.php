<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin — Aspal Seru')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:  '#162740',
                        sky:   '#0EA5E9',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Hal yang tidak bisa dilakukan Tailwind CDN */
        #sidebar { transition: transform .25s ease; }
        .nav-item { border-left: 3px solid transparent; transition: all .15s; }
        .nav-item.active { border-left-color: #0EA5E9; }
        .notif-dot::after {
            content: '';
            position: absolute;
            top: -2px; right: -2px;
            width: .6rem; height: .6rem;
            background: #EF4444;
            border-radius: 50%;
            border: 2px solid white;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 font-sans text-slate-800">

{{-- ── SIDEBAR ── --}}
<aside id="sidebar"
       class="fixed top-0 left-0 z-50 flex flex-col w-60 min-h-screen bg-navy
              -translate-x-full md:translate-x-0">

    {{-- Logo --}}
    <div class="px-5 pt-6 pb-4 border-b border-white/10">
        <h1 class="text-lg font-extrabold text-white">Aspal Seru</h1>
        <p class="text-[10px] font-bold uppercase tracking-[.2em] text-sky-300 mt-0.5">Super Admin</p>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto py-4">

        <p class="px-5 pt-1 pb-2 text-[10px] font-bold uppercase tracking-[.15em] text-white/30">Utama</p>
        <a href="{{ url('superadmin/dashboard') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('superadmin/dashboard') ? 'active bg-sky/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <p class="px-5 pt-4 pb-2 text-[10px] font-bold uppercase tracking-[.15em] text-white/30">Manajemen</p>
        <a href="{{ url('superadmin/users') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('superadmin/users*') ? 'active bg-sky/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Pengguna
        </a>
        <a href="{{ url('superadmin/policies') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('superadmin/policies*') ? 'active bg-sky/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Kebijakan
        </a>

        <p class="px-5 pt-4 pb-2 text-[10px] font-bold uppercase tracking-[.15em] text-white/30">Sistem</p>
   
        <a href="{{ route('superadmin.logs.index') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('superadmin/logs*') ? 'active bg-sky/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Log Aktivitas
        </a>
        <a href="{{ url('superadmin/backup') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('superadmin/backup*') ? 'active bg-sky/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
            </svg>
            Backup
        </a>
            <a href="{{ route('superadmin.settings.index') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('superadmin/settings*') ? 'active bg-sky/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Pengaturan
        </a>
    </nav>

    {{-- Footer user --}}
    <div class="px-5 py-4 border-t border-white/10">
        <div class="flex items-center gap-2.5 mb-3">
            <div class="w-8 h-8 rounded-full bg-sky flex items-center justify-center
                        text-xs font-bold text-white shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-[13px] font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-sky-300">Super Admin</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full py-2 rounded-lg bg-red-500/15 text-red-300
                           text-[13px] font-semibold border-none cursor-pointer
                           hover:bg-red-500/25 transition-colors">
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Overlay mobile --}}
<div id="sidebar-overlay"
     class="hidden fixed inset-0 bg-black/40 z-40"
     onclick="closeSidebar()"></div>

{{-- ── MAIN WRAPPER ── --}}
<div class="md:ml-60 min-h-screen flex flex-col">

    {{-- Topbar --}}
    <header class="sticky top-0 z-30 bg-white border-b border-slate-200
                   flex items-center justify-between px-4 md:px-7 py-3.5">
        <div class="flex items-center gap-3">
            <button class="md:hidden p-1 bg-transparent border-none cursor-pointer"
                    onclick="openSidebar()">
                <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-[17px] font-bold text-navy">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative notif-dot cursor-pointer">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <span class="text-[13px] font-semibold text-navy hidden sm:block">
                {{ auth()->user()->name }}
            </span>
        </div>
    </header>

    {{-- Page content --}}
    <main class="flex-1 p-4 md:p-7">
        @yield('content')
    </main>
</div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.remove('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.remove('hidden');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.add('hidden');
    }
</script>
@stack('scripts')
</body>
</html>
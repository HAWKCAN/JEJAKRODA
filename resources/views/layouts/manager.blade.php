<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manager — Aspal Seru')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        #sidebar { transition: transform .25s ease; }
        .nav-item { border-left: 3px solid transparent; transition: all .15s; }
        .nav-item.active { border-left-color: #0EA5E9; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800">

{{-- ── SIDEBAR ── --}}
<aside id="sidebar"
       class="fixed top-0 left-0 z-50 flex flex-col w-60 min-h-screen bg-[#162740]
              -translate-x-full md:translate-x-0">

    <div class="px-5 pt-6 pb-4 border-b border-white/10">
        <h1 class="text-lg font-extrabold text-white">Aspal Seru</h1>
        <p class="text-[10px] font-bold uppercase tracking-[.2em] text-sky-300 mt-0.5">Manager</p>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <p class="px-5 pt-1 pb-2 text-[10px] font-bold uppercase tracking-[.15em] text-white/30">Utama</p>

        <a href="{{ url('manager/dashboard') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('manager/dashboard') ? 'active bg-[#0EA5E9]/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <p class="px-5 pt-4 pb-2 text-[10px] font-bold uppercase tracking-[.15em] text-white/30">Armada</p>

        <a href="{{ route('manager.vehicles.index') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('manager/vehicles*') ? 'active bg-[#0EA5E9]/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
            </svg>
            Armada Saya
        </a>

        <p class="px-5 pt-4 pb-2 text-[10px] font-bold uppercase tracking-[.15em] text-white/30">Transaksi</p>

        <a href="{{ route('manager.bookings.index') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('manager/bookings*') ? 'active bg-[#0EA5E9]/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Booking
        </a>

         <a href="{{ route('manager.reports.index') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('manager/reports*') ? 'active bg-[#0EA5E9]/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Laporan
        </a>
    
        <a href="{{ route('manager.verification.edit') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('manager/verification*') ? 'active bg-[#0EA5E9]/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M6 20a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6z"/>
            </svg>
            Verifikasi Akun
        </a>
        <a href="{{ route('policies.index') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('policies*') ? 'active bg-[#0EA5E9]/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            SOP
        </a>
         <p class="px-5 pt-4 pb-2 text-[10px] font-bold uppercase tracking-[.15em] text-white/30">Sistem</p>

        <a href="{{ route('manager.settings.index') }}"
           class="nav-item flex items-center gap-2.5 px-5 py-2.5 text-[13px] font-medium
                  text-white/65 no-underline hover:text-white hover:bg-white/5
                  {{ request()->is('manager/settings*') ? 'active bg-[#0EA5E9]/15 !text-white !font-bold' : '' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Pengaturan Toko
        </a>
        
    </nav>

    <div class="px-5 py-4 border-t border-white/10">
        <div class="flex items-center gap-2.5 mb-3">
            <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center
                        text-xs font-bold text-white shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-[13px] font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-sky-300">Manager</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full py-2 rounded-lg bg-red-500/15 text-red-300 text-[13px]
                           font-semibold border-none cursor-pointer hover:bg-red-500/25 transition-colors">
                Keluar
            </button>
        </form>
    </div>
</aside>

<div id="sidebar-overlay"
     class="hidden fixed inset-0 bg-black/40 z-40"
     onclick="closeSidebar()"></div>

{{-- ── MAIN ── --}}
<div class="md:ml-60 min-h-screen flex flex-col">

    <header class="sticky top-0 z-30 bg-white border-b border-slate-200
                   flex items-center justify-between px-4 md:px-7 py-3.5">
        <div class="flex items-center gap-3">
            <button class="md:hidden p-1 bg-transparent border-none cursor-pointer"
                    onclick="openSidebar()">
                <svg class="w-6 h-6 text-[#162740]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-[17px] font-bold text-[#162740]">@yield('page-title', 'Dashboard')</span>
        </div>
        <span class="text-[13px] font-semibold text-[#162740] hidden sm:block">
            {{ auth()->user()->name }}
        </span>
    </header>

    <main class="flex-1 p-4 md:p-7">
        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-green-50 text-green-700 border border-green-200">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-lg text-sm bg-red-50 text-red-600 border border-red-200">
            <p class="font-semibold mb-1">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin — Aspal Seru')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:   #162740;
            --sky:    #0EA5E9;
            --sky-dk: #0284C7;
            --slate:  #F8FAFC;
            --text:   #1E293B;
            --muted:  #64748B;
            --border: #E2E8F0;
            --sidebar-w: 240px;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F1F5F9;
            color: var(--text);
            margin: 0;
        }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--navy);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: transform .25s ease;
        }
        .sidebar-logo {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-logo h1 { font-size: 1.2rem; font-weight: 800; color: #fff; margin: 0; }
        .sidebar-logo p  { font-size: .65rem; font-weight: 700; letter-spacing: .2em;
                           text-transform: uppercase; color: #7DD3FC; margin: .15rem 0 0; }
        .sidebar-badge   { font-size: .6rem; font-weight: 700; background: #EF4444;
                           color: #fff; padding: .15rem .45rem; border-radius: 99px;
                           margin-left: auto; }

        nav.sidebar-nav  { flex: 1; padding: 1rem 0; overflow-y: auto; }
        .nav-section     { padding: .25rem 1.25rem .5rem;
                           font-size: .6rem; font-weight: 700; letter-spacing: .15em;
                           text-transform: uppercase; color: rgba(255,255,255,.3); }
        .nav-item {
            display: flex; align-items: center; gap: .65rem;
            padding: .6rem 1.25rem;
            color: rgba(255,255,255,.65);
            font-size: .83rem; font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .15s;
        }
        .nav-item:hover   { color: #fff; background: rgba(255,255,255,.06); }
        .nav-item.active  { color: #fff; background: rgba(14,165,233,.15);
                            border-left-color: var(--sky); font-weight: 700; }
        .nav-item svg     { width: 1rem; height: 1rem; flex-shrink: 0; }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: .65rem; margin-bottom: .75rem;
        }
        .sidebar-avatar {
            width: 2rem; height: 2rem; border-radius: 50%;
            background: var(--sky); color: #fff;
            font-size: .75rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-user-name  { font-size: .8rem; font-weight: 600; color: #fff; }
        .sidebar-user-role  { font-size: .65rem; color: #7DD3FC; }

        /* ── Main wrapper ── */
        #main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top bar ── */
        #topbar {
            position: sticky; top: 0; z-index: 40;
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: .85rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-title { font-size: 1.05rem; font-weight: 700; color: var(--navy); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-notif { position: relative; cursor: pointer; }
        .topbar-notif svg { width: 1.25rem; height: 1.25rem; color: var(--muted); }
        .notif-dot { position: absolute; top: -2px; right: -2px;
                     width: .7rem; height: .7rem; background: #EF4444;
                     border-radius: 50%; border: 2px solid #fff; }

        /* ── Content ── */
        #page-content { flex: 1; padding: 1.75rem; }

        /* ── Mobile sidebar toggle ── */
        @media (max-width: 767px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-wrapper { margin-left: 0; }
            #topbar { padding: .75rem 1rem; }
            #page-content { padding: 1rem; }
        }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.4); z-index: 49;
        }
        .sidebar-overlay.show { display: block; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ── --}}
<aside id="sidebar">
    <div class="sidebar-logo">
        <h1>Aspal Seru</h1>
        <p>Super Admin</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Utama</div>
        <a href="{{ url('superadmin/dashboard') }}"
           class="nav-item {{ request()->is('superadmin/dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <div class="nav-section" style="margin-top:.5rem;">Manajemen</div>
        <a href="{{ url('superadmin/users') }}"
           class="nav-item {{ request()->is('superadmin/users*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Pengguna
        </a>
        <a href="{{ url('superadmin/policies') }}"
           class="nav-item {{ request()->is('superadmin/policies*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Kebijakan
        </a>

        <div class="nav-section" style="margin-top:.5rem;">Sistem</div>
        <a href="{{ url('superadmin/settings') }}"
           class="nav-item {{ request()->is('superadmin/settings*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Pengaturan
        </a>
        <a href="{{ url('superadmin/logs') }}"
           class="nav-item {{ request()->is('superadmin/logs*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Log Aktivitas
        </a>
        <a href="{{ url('superadmin/backup') }}"
           class="nav-item {{ request()->is('superadmin/backup*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
            </svg>
            Backup
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Super Admin</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
                width:100%; padding:.5rem; border-radius:.4rem;
                background:rgba(239,68,68,.15); color:#FCA5A5;
                font-size:.78rem; font-weight:600; border:none; cursor:pointer;
                transition: background .15s;
            " onmouseover="this.style.background='rgba(239,68,68,.25)'"
               onmouseout="this.style.background='rgba(239,68,68,.15)'">
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Overlay mobile --}}
<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ── MAIN WRAPPER ── --}}
<div id="main-wrapper">

    {{-- Top bar --}}
    <header id="topbar">
        <div style="display:flex;align-items:center;gap:.75rem;">
            {{-- Hamburger mobile --}}
            <button class="md:hidden" onclick="openSidebar()" style="
                background:none; border:none; cursor:pointer; padding:.25rem;
            ">
                <svg style="width:1.4rem;height:1.4rem;color:#162740;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-notif">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="notif-dot"></span>
            </div>
            <div style="font-size:.8rem;font-weight:600;color:#162740;">
                {{ auth()->user()->name }}
            </div>
        </div>
    </header>

    {{-- Page content --}}
    <main id="page-content">
        @yield('content')
    </main>
</div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.add('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('show');
    }
</script>
@stack('scripts')
</body>
</html>

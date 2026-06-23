@extends('layouts.guest')

@section('title', 'Aspal Seru — Sewa Kendaraan Purwokerto')

{{-- Aktifkan search bar mobile di layout --}}
@section('show-search') @endsection


@section('content')

    {{-- ── Hero (desktop only) ── --}}
    <section class="hidden md:flex h-[420px]" style="background:#162740;">
        <div class="w-1/2 px-24 flex flex-col justify-center">
            <h2 class="text-5xl font-extrabold leading-tight mb-5 text-white">
                Sewa Kendaraan<br>
                <span style="color:#0EA5E9;">Tanpa Ribet.</span>
            </h2>
            <p class="text-sm font-light mb-10 w-4/5" style="color:#CBD5E1;">
                Motor &amp; Mobil berkualitas di Purwokerto — siap antar, siap jalan.
            </p>
            <div class="flex gap-4">
                <a href="#katalog"
                   class="px-8 py-3 rounded-md text-sm font-semibold text-white shadow-md"
                   style="background:#0EA5E9;">Lihat Katalog</a>
                <a href="#cara-sewa"
                   class="px-8 py-3 rounded-md text-sm font-semibold text-white border"
                   style="background:rgba(255,255,255,.08); border-color:rgba(255,255,255,.15);">
                    Cara Sewa &rarr;
                </a>
            </div>
        </div>
        {{-- Galeri 3 kendaraan asli dari database --}}
        <div class="w-1/2 px-20 flex gap-4 items-center">
            @php
                $heights = ['h-64', 'h-80', 'h-64'];
            @endphp
            @forelse($heroVehicles as $index => $vehicle)
                <div class="w-1/3 {{ $heights[$index] ?? 'h-64' }} rounded-xl overflow-hidden relative group">
                    <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->name }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <p class="text-white text-xs font-bold truncate">{{ $vehicle->name }}</p>
                        <p class="text-sky-300 text-[10px] font-semibold">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}/hari</p>
                    </div>
                </div>
            @empty
                {{-- Fallback kalau belum ada kendaraan dengan gambar --}}
                <div class="w-1/3 h-64 rounded-xl" style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);"></div>
                <div class="w-1/3 h-80 rounded-xl" style="background:rgba(255,255,255,.1);  border:1px solid rgba(255,255,255,.15);"></div>
                <div class="w-1/3 h-64 rounded-xl" style="background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);"></div>
            @endforelse
        </div>
    </section>

    {{-- ── Stats bar (desktop only) — data asli dari database ── --}}
    <div class="hidden md:flex justify-center gap-20 items-center py-7 border-b"
         style="background:#FFFFFF; border-color:#E2E8F0;">
        <div class="text-center">
            <div class="text-3xl font-extrabold" style="color:#162740;">{{ $stats['armada'] }}+</div>
            <div class="text-[11px] font-semibold uppercase tracking-widest mt-1" style="color:#94A3B8;">Armada</div>
        </div>
        <div class="w-px h-10" style="background:#E2E8F0;"></div>
        <div class="text-center">
            <div class="text-3xl font-extrabold" style="color:#162740;">{{ $stats['pelanggan'] }}</div>
            <div class="text-[11px] font-semibold uppercase tracking-widest mt-1" style="color:#94A3B8;">Pelanggan</div>
        </div>
        <div class="w-px h-10" style="background:#E2E8F0;"></div>
        <div class="text-center">
            <div class="text-3xl font-extrabold" style="color:#162740;">{{ $stats['rating'] > 0 ? $stats['rating'] : '-' }}</div>
            <div class="text-[11px] font-semibold uppercase tracking-widest mt-1" style="color:#94A3B8;">Rating</div>
        </div>
        <div class="w-px h-10" style="background:#E2E8F0;"></div>
        <div class="text-center">
            <div class="text-3xl font-extrabold" style="color:#162740;">{{ $stats['berdiri'] }}</div>
            <div class="text-[11px] font-semibold uppercase tracking-widest mt-1" style="color:#94A3B8;">Berdiri</div>
        </div>
    </div>

    {{-- ── Cara Sewa (component terpisah) ── --}}
    @include('components.cara-sewa', ['sopCaraSewa' => $sopCaraSewa])

    {{-- ── Katalog ── --}}
    <main id="katalog" class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10">

        {{-- Tab filter + sort (desktop) --}}
        <div class="hidden md:flex justify-between items-center border-b pb-4 mb-8"
             style="border-color:#E2E8F0;">
            <div class="flex gap-8 text-sm font-bold tracking-wide" style="color:#94A3B8;">
                <a href="#" class="pb-4 -mb-[18px] border-b-2" style="color:#0EA5E9; border-color:#0EA5E9;">SEMUA</a>
                <a href="#" class="hover:opacity-70 transition-opacity">MOTOR</a>
                <a href="#" class="hover:opacity-70 transition-opacity">MOBIL</a>
                <a href="#" class="hover:opacity-70 transition-opacity">MATIC</a>
                <a href="#" class="hover:opacity-70 transition-opacity">MANUAL</a>
            </div>
            <div class="flex items-center gap-1.5 text-xs font-medium cursor-pointer hover:opacity-70"
                 style="color:#64748B;">
                Urutkan: Harga Terendah <span class="font-bold" style="color:#0EA5E9;">▾</span>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">

            {{-- Kartu kendaraan — GUEST: tombol Pesan redirect ke login --}}
            @forelse($vehicles as $vehicle)
            <div class="rounded-xl flex flex-col overflow-hidden border shadow-sm hover:shadow-md transition-shadow"
                 style="background:#FFFFFF; border-color:#E2E8F0;">
                <div class="h-32 md:h-44 w-full" style="background:#F1F5F9;">
                    @if($vehicle->image_url)
                        <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-3 md:p-5 flex flex-col flex-grow">
                    <h3 class="font-bold text-sm md:text-base" style="color:#1E293B;">{{ $vehicle->name }}</h3>
                    <p class="hidden md:block text-[10px] font-semibold uppercase tracking-wider mt-1.5" style="color:#94A3B8;">
                        {{ strtoupper($vehicle->type) }} · {{ $vehicle->location }}
                    </p>
                    <div class="mt-2 md:mt-4">
                        <span class="font-bold text-sm md:text-xl" style="color:#0EA5E9;">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-[10px] md:text-xs" style="color:#64748B;">/ hari</span>
                    </div>
                    <p class="md:hidden text-[10px] mt-0.5" style="color:#94A3B8;">{{ ucfirst($vehicle->type) }}</p>
                    <div class="mt-auto pt-4 md:pt-6 flex justify-between items-center">
                        <span class="hidden md:flex items-center gap-1.5 text-[11px] font-semibold px-2.5 py-1 rounded-md"
                              style="background:#F0FDF4; color:#16A34A;">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:#22C55E;"></span> Tersedia
                        </span>
                        <a href="{{ route('login') }}"
                           class="w-full md:w-auto text-center text-xs md:text-sm font-semibold px-4 py-2 rounded-lg text-white shadow-sm"
                           style="background:#0EA5E9;">
                            Pesan <span class="md:hidden">Sekarang</span><span class="hidden md:inline">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-sm py-10" style="color:#94A3B8;">
                Belum ada kendaraan tersedia.
            </div>
            @endforelse

        </div>{{-- /grid --}}
    </main>

@endsection
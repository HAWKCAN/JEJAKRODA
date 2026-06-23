@extends('layouts.app')
@section('title', 'Dashboard — Aspal Seru')
@section('show-search') @endsection

@section('content')


    {{-- ── Widget Pesanan Aktif ── --}}
    <section class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-sm font-bold uppercase tracking-widest" style="color:#94A3B8;">Pesanan Aktif</h2>
            <a href="/bookings/history" class="text-xs font-semibold" style="color:#0EA5E9;">Lihat Semua →</a>
        </div>

        @if(isset($pesananAktif) && count($pesananAktif) > 0)
            <div class="flex gap-4 overflow-x-auto pb-2 no-scroll">
                @foreach($pesananAktif as $pesanan)
                <a href="{{ route('bookings.show', $pesanan) }}"
                   class="min-w-[240px] rounded-xl p-4 border flex-shrink-0 hover:shadow-md transition-shadow"
                   style="background:#EFF6FF; border-color:#BAE6FD;">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-bold uppercase tracking-wide" style="color:#0284C7;">
                            {{ $pesanan->vehicle->name ?? '-' }}
                        </span>
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full text-white"
                              style="background:#0EA5E9;">
                            {{ $pesanan->status_label }}
                        </span>
                    </div>
                    <p class="text-xs" style="color:#64748B;">
                        {{ $pesanan->start_date->format('d M Y') }} — {{ $pesanan->end_date->format('d M Y') }}
                    </p>
                    <p class="text-sm font-bold mt-1" style="color:#0EA5E9;">
                        Rp {{ number_format($pesanan->total_price, 0, ',', '.') }}
                    </p>
                    @if($pesanan->status === 'confirmed' && !$pesanan->payment)
                        <span class="mt-2 inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full"
                              style="background:#EEF2FF; color:#6366F1;">Belum Bayar</span>
                    @elseif($pesanan->payment && $pesanan->payment->status === 'pending')
                        <span class="mt-2 inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full"
                              style="background:#FEF9C3; color:#CA8A04;">Menunggu Verifikasi</span>
                    @endif
                </a>
                @endforeach
            </div>
        @else
            <div class="rounded-xl p-5 border text-center text-sm"
                 style="background:#F8FAFC; border-color:#E2E8F0; color:#94A3B8;">
                Belum ada pesanan aktif. Yuk sewa kendaraan sekarang!
            </div>
        @endif
    </section>

    {{-- ── Katalog ── --}}
    <main id="katalog" class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-8">

        <div class="hidden md:flex justify-between items-center border-b pb-4 mb-8"
             style="border-color:#E2E8F0;">
            @php
                $type = request('type');
            @endphp

            <div class="flex gap-8 text-sm font-bold tracking-wide text-slate-400">
                <a href="{{ route('dashboard') }}" 
                class="pb-4 -mb-[18px] border-b-2 {{ !$type ? 'text-sky-500 border-sky-500' : 'border-transparent' }}">
                SEMUA
                </a>
                
                <a href="{{ route('dashboard', ['type' => 'motor']) }}" 
                class="hover:opacity-70 transition-opacity {{ $type === 'motor' ? 'text-sky-500' : '' }}">
                MOTOR
                </a>
                
                <a href="{{ route('dashboard', ['type' => 'mobil']) }}" 
                class="hover:opacity-70 transition-opacity {{ $type === 'mobil' ? 'text-sky-500' : '' }}">
                MOBIL
                </a>
            </div>
         
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
   @forelse($vehicles as $vehicle)
@php
    $detailUrl = url('/vehicles/' . $vehicle->id);
@endphp
<div class="rounded-xl flex flex-col overflow-hidden border shadow-sm hover:shadow-md transition-shadow"
     style="background:#FFFFFF; border-color:#E2E8F0;">

    {{-- Gambar — link ke detail --}}
    <a href="{{ $detailUrl }}">
        <div class="h-32 md:h-44 w-full" style="background:#F1F5F9;">
            @if($vehicle->image_url)
                <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
            @endif
        </div>
    </a>

    <div class="p-3 md:p-5 flex flex-col flex-grow">

        {{-- Judul — link ke detail --}}
        <a href="{{ $detailUrl }}" class="hover:opacity-75 transition-opacity">
            <h3 class="font-bold text-sm md:text-base" style="color:#1E293B;">{{ $vehicle->name }}</h3>
        </a>

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
            <a href="{{ route('bookings.create', $vehicle->id) }}"
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
        </div>

        <div class="mt-8">
            {{ $vehicles->links() }}
        </div>
    </main>

@endsection
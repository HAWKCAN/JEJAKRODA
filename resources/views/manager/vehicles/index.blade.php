@extends('layouts.manager')

@section('title', 'Armada Saya — Aspal Seru')
@section('page-title', 'Armada Saya')

@section('content')

{{-- Header + tombol tambah --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <p class="text-sm text-slate-500">{{ $owner->business_name }}</p>
    </div>
    <a href="{{ route('manager.vehicles.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white
              bg-sky-500 hover:bg-sky-600 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Kendaraan
    </a>
</div>

{{-- Stats row --}}
<div class="grid grid-cols-3 gap-3 mb-6">
    @php
        $totalAll      = $vehicles->total();
        $totalAvail    = $vehicles->getCollection()->where('status','available')->count();
        $totalInactive = $vehicles->getCollection()->where('status','inactive')->count();
    @endphp
    <div class="bg-white rounded-xl border border-slate-200 px-4 py-3 text-center">
        <p class="text-2xl font-extrabold text-[#162740]">{{ $totalAll }}</p>
        <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide mt-0.5">Total</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 px-4 py-3 text-center">
        <p class="text-2xl font-extrabold text-green-600">{{ $totalAvail }}</p>
        <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide mt-0.5">Tersedia</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 px-4 py-3 text-center">
        <p class="text-2xl font-extrabold text-slate-400">{{ $totalInactive }}</p>
        <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wide mt-0.5">Nonaktif</p>
    </div>
</div>

{{-- Grid kendaraan --}}
@if($vehicles->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($vehicles as $v)
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">

        {{-- Gambar --}}
        @if($v->image_url)
            <img src="{{ Storage::url($v->image_url) }}" alt="{{ $v->name }}"
                 class="w-full h-40 object-cover">
        @else
            <div class="w-full h-40 flex items-center justify-center text-5xl
                        {{ $v->type === 'mobil' ? 'bg-sky-50' : 'bg-green-50' }}">
                {{ $v->type === 'mobil' ? '🚗' : '🏍️' }}
            </div>
        @endif

        <div class="p-4">
            {{-- Nama + status badge --}}
            <div class="flex items-start justify-between gap-2 mb-1">
                <h3 class="font-bold text-sm text-slate-800 leading-tight">{{ $v->name }}</h3>
                @php
                    $badgeClass = match($v->status) {
                        'available' => 'bg-green-100 text-green-700',
                        'rented'    => 'bg-blue-100 text-blue-700',
                        'inactive'  => 'bg-slate-100 text-slate-500',
                        default     => 'bg-slate-100 text-slate-500',
                    };
                    $badgeLabel = match($v->status) {
                        'available' => 'Tersedia',
                        'rented'    => 'Disewa',
                        'inactive'  => 'Nonaktif',
                        default     => $v->status,
                    };
                @endphp
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 {{ $badgeClass }}">
                    {{ $badgeLabel }}
                </span>
            </div>

            <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-2">
                {{ strtoupper($v->type) }} · {{ $v->plate_number }}
            </p>

            <p class="text-base font-extrabold text-sky-500 mb-3">
                Rp {{ number_format($v->price_per_day, 0, ',', '.') }}
                <span class="text-xs font-normal text-slate-400">/ hari</span>
            </p>

            {{-- Aksi --}}
            <div class="flex items-center gap-2 pt-3 border-t border-slate-100">

                {{-- Edit --}}
                <a href="{{ route('manager.vehicles.edit', $v->id) }}"
                   class="flex-1 text-center text-xs font-semibold py-2 rounded-lg
                          bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors">
                    Edit
                </a>

                {{-- Toggle status --}}
                @if($v->status !== 'rented')
                <form method="POST" action="{{ route('manager.vehicles.toggleStatus', $v->id) }}" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="w-full text-xs font-semibold py-2 rounded-lg transition-colors
                                   {{ $v->status === 'available'
                                       ? 'bg-amber-100 text-amber-700 hover:bg-amber-200'
                                       : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                        {{ $v->status === 'available' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                @else
                <span class="flex-1 text-center text-xs font-semibold py-2 rounded-lg bg-slate-50 text-slate-300 cursor-not-allowed">
                    Sedang Disewa
                </span>
                @endif

                {{-- Hapus --}}
                @if($v->status !== 'rented')
                <form method="POST" action="{{ route('manager.vehicles.destroy', $v->id) }}"
                      onsubmit="return confirm('Yakin hapus kendaraan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
                @endif

            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
@if($vehicles->hasPages())
<div class="mt-6 flex justify-center">{{ $vehicles->links() }}</div>
@endif

@else
<div class="bg-white rounded-2xl border border-slate-200 py-16 text-center">
    <div class="text-5xl mb-3">🚗</div>
    <p class="text-slate-500 font-semibold mb-4">Belum ada kendaraan terdaftar.</p>
    <a href="{{ route('manager.vehicles.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold
              text-white bg-sky-500 hover:bg-sky-600 transition-colors">
        + Tambah Sekarang
    </a>
</div>
@endif

@endsection
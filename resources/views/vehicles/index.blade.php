@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('title', 'Katalog Kendaraan — Aspal Seru')
@section('show-search') @endsection

@section('content')

{{-- ── Hero strip desktop ── --}}
<div class="hidden md:block bg-navy py-8 px-8 border-b border-[#1e3a55]">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-extrabold text-black mb-1">Katalog Kendaraan</h1>
        <p class="text-sm text-sky-300">Temukan motor & mobil terbaik di Purwokerto</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 md:px-8 py-5 md:py-8">

    {{-- ── Filter Form ── --}}
    <form method="GET" action="{{ url('/vehicles') }}" id="filter-form">

        {{-- Desktop filter row --}}
        <div class="hidden md:flex items-center gap-3 mb-6 flex-wrap">

            {{-- Search --}}
            <div class="relative shrink-0">
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                       placeholder="Cari kendaraan..."
                       class="pl-9 pr-4 py-2 rounded-lg text-sm border border-slate-200
                              bg-slate-50 outline-none w-56 focus:border-sky-400">
                <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-slate-400"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <div class="w-px h-6 bg-slate-200"></div>

            {{-- Tipe chips --}}
            <button type="button" onclick="setFilter('type','')"
                    class="px-4 py-1.5 rounded-full text-xs font-semibold border-[1.5px] cursor-pointer
                           transition-all whitespace-nowrap
                           {{ empty($filters['type']) ? 'bg-sky-500 border-sky-500 text-white' : 'bg-white border-slate-200 text-slate-500 hover:border-sky-400 hover:text-sky-500' }}">
                Semua
            </button>
            <button type="button" onclick="setFilter('type','motor')"
                    class="px-4 py-1.5 rounded-full text-xs font-semibold border-[1.5px] cursor-pointer
                           transition-all whitespace-nowrap
                           {{ ($filters['type'] ?? '') === 'motor' ? 'bg-sky-500 border-sky-500 text-white' : 'bg-white border-slate-200 text-slate-500 hover:border-sky-400 hover:text-sky-500' }}">
                Motor
            </button>
            <button type="button" onclick="setFilter('type','mobil')"
                    class="px-4 py-1.5 rounded-full text-xs font-semibold border-[1.5px] cursor-pointer
                           transition-all whitespace-nowrap
                           {{ ($filters['type'] ?? '') === 'mobil' ? 'bg-sky-500 border-sky-500 text-white' : 'bg-white border-slate-200 text-slate-500 hover:border-sky-400 hover:text-sky-500' }}">
                Mobil
            </button>

            <input type="hidden" name="type" id="input-type" value="{{ $filters['type'] ?? '' }}">

            <div class="w-px h-6 bg-slate-200"></div>

            {{-- Sort --}}
            <select name="sort" onchange="this.form.submit()"
                    class="text-sm border border-slate-200 rounded-lg px-3 py-2
                           outline-none bg-slate-50 text-slate-500">
                <option value="price_asc"  {{ ($filters['sort'] ?? 'price_asc') === 'price_asc'  ? 'selected' : '' }}>Harga Terendah</option>
                <option value="price_desc" {{ ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                <option value="newest"     {{ ($filters['sort'] ?? '') === 'newest'     ? 'selected' : '' }}>Terbaru</option>
            </select>

            @if(array_filter($filters))
            <a href="{{ url('/vehicles') }}"
               class="text-sm font-medium text-red-500 hover:opacity-70">Reset</a>
            @endif
        </div>

        {{-- Mobile filter chips --}}
        <div class="md:hidden flex gap-2 overflow-x-auto pb-2 mb-4 [&::-webkit-scrollbar]:hidden">
            <button type="button" onclick="setFilter('type','')"
                    class="px-4 py-1.5 rounded-full text-xs font-semibold border-[1.5px] shrink-0 cursor-pointer
                           {{ empty($filters['type']) ? 'bg-sky-500 border-sky-500 text-white' : 'bg-white border-slate-200 text-slate-500' }}">
                Semua
            </button>
            <button type="button" onclick="setFilter('type','motor')"
                    class="px-4 py-1.5 rounded-full text-xs font-semibold border-[1.5px] shrink-0 cursor-pointer
                           {{ ($filters['type'] ?? '') === 'motor' ? 'bg-sky-500 border-sky-500 text-white' : 'bg-white border-slate-200 text-slate-500' }}">
                Motor
            </button>
            <button type="button" onclick="setFilter('type','mobil')"
                    class="px-4 py-1.5 rounded-full text-xs font-semibold border-[1.5px] shrink-0 cursor-pointer
                           {{ ($filters['type'] ?? '') === 'mobil' ? 'bg-sky-500 border-sky-500 text-white' : 'bg-white border-slate-200 text-slate-500' }}">
                Mobil
            </button>
        </div>

    </form>

    {{-- Result count --}}
    <p class="text-[13px] text-slate-400 mb-4">{{ $vehicles->total() }} kendaraan ditemukan</p>

    {{-- ── Grid ── --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

        @forelse($vehicles as $v)
        @php
            $detailUrl = url('/vehicles/' . $v->id);
            $bookUrl   = auth()->check() ? route('booking.create', $v->id) : route('login');
            $isPopular = $v->avg_rating >= 4.5 && $v->review_count >= 3;
        @endphp

        <div class="relative bg-white rounded-2xl flex flex-col overflow-hidden
                    border transition-all duration-200 hover:-translate-y-0.5
                    {{ $isPopular
                        ? 'border-2 border-sky-400 shadow-[0_4px_20px_rgba(14,165,233,.15)]'
                        : 'border-slate-200 hover:shadow-[0_8px_30px_rgba(14,165,233,.12)]' }}">

            {{-- Badge Populer --}}
            @if($isPopular)
            <div class="absolute top-0 right-0 z-10 bg-sky-500 text-white
                        text-[10px] font-bold px-3 py-1 rounded-bl-lg
                        uppercase tracking-wider">
                Populer
            </div>
            @endif

            {{-- Gambar — link ke detail --}}
            <a href="{{ $detailUrl }}">
                @if($v->image_url)
                    <img src="{{ $v->image_url }}" alt="{{ $v->name }}"
                         class="w-full h-36 md:h-44 object-cover">
                @else
                    <div class="w-full h-36 md:h-44 flex items-center justify-center
                                {{ $v->type === 'mobil' ? 'bg-sky-50' : 'bg-green-50' }}">
                        <span class="text-5xl">{{ $v->type === 'mobil' ? '🚗' : '🏍' }}</span>
                    </div>
                @endif
            </a>

            <div class="p-3 md:p-4 flex flex-col flex-grow">

                {{-- Judul — link ke detail --}}
                <a href="{{ $detailUrl }}" class="hover:text-sky-500 transition-colors">
                    <h3 class="font-bold text-sm md:text-base leading-tight text-slate-800">
                        {{ $v->name }}
                    </h3>
                </a>
                <p class="hidden md:block text-[10px] font-semibold uppercase tracking-wider text-slate-400 mt-1">
                    {{ strtoupper($v->type_label) }} · {{ $v->location }}
                </p>
                <p class="md:hidden text-[10px] text-slate-400 mt-0.5">{{ $v->type_label }}</p>

                {{-- Rating --}}
                @if($v->review_count > 0)
                <div class="flex items-center gap-0.5 mt-1.5">
                    @for($s = 1; $s <= 5; $s++)
                        <span class="text-[11px] {{ $s <= round($v->avg_rating) ? 'text-yellow-400' : 'text-slate-200' }}">★</span>
                    @endfor
                    <span class="text-[11px] text-slate-400 ml-1">
                        {{ $v->avg_rating }} ({{ $v->review_count }})
                    </span>
                </div>
                @endif

                {{-- Harga --}}
                <div class="mt-2 md:mt-3">
                    <span class="font-bold text-base md:text-xl text-sky-500">
                        Rp {{ number_format($v->price_per_day, 0, ',', '.') }}
                    </span>
                    <span class="text-[10px] md:text-xs text-slate-500">/ hari</span>
                </div>

                {{-- Status + Tombol --}}
                <div class="mt-auto pt-3 md:pt-4 flex justify-between items-center gap-2">
                    <span class="hidden md:flex items-center gap-1.5 text-[11px] font-semibold
                                 px-2.5 py-1 rounded-md bg-green-50 text-green-600 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        {{ $v->status_label }}
                    </span>
                    <a href="{{ $bookUrl }}"
                       class="flex-1 md:flex-none text-center text-xs md:text-sm font-semibold
                              px-3 md:px-4 py-2 rounded-lg text-white bg-sky-500
                              hover:bg-sky-600 transition-colors shadow-sm">
                        Pesan<span class="hidden md:inline"> →</span>
                    </a>
                </div>

            </div>
        </div>

        @empty
        <div class="col-span-full text-center py-16">
            <div class="text-5xl mb-3">🚗</div>
            <p class="text-[15px] text-slate-400">Tidak ada kendaraan yang cocok dengan filter kamu.</p>
            <a href="{{ url('/vehicles') }}" class="inline-block mt-3 text-sm font-semibold text-sky-500">
                Reset filter
            </a>
        </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($vehicles->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $vehicles->links() }}
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
function setFilter(name, value) {
    document.getElementById('input-' + name).value = value;
    document.getElementById('filter-form').submit();
}
</script>
@endpush
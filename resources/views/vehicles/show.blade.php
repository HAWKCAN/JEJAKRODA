@extends(auth()->check() ? 'layouts.app' : 'layouts.guest')

@section('title', $vehicle->name . ' — Aspal Seru')

@section('content')

<div class="max-w-7xl mx-auto px-4 md:px-8 py-5 md:py-8">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-400 mb-4">
        <a href="{{ url('/') }}" class="text-sky-500 hover:opacity-70">Beranda</a>
        <span class="mx-1.5">›</span>
        <a href="{{ url('/vehicles') }}" class="text-sky-500 hover:opacity-70">Katalog</a>
        <span class="mx-1.5">›</span>
        <span class="text-slate-700">{{ $vehicle->name }}</span>
    </nav>

    <div class="md:grid md:grid-cols-[1fr_340px] md:gap-8">

        {{-- ── KIRI ── --}}
        <div>

            {{-- Gambar utama --}}
            @if($vehicle->image_url)
                <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->name }}"
                     class="w-full h-64 md:h-96 object-cover rounded-2xl">
            @else
                <div class="w-full h-64 md:h-96 rounded-2xl flex items-center justify-center
                            {{ $vehicle->type === 'mobil' ? 'bg-sky-50' : 'bg-green-50' }}">
                    <svg class="w-20 h-20 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        @if($vehicle->type === 'mobil')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 10l1.5-4h13L21 10M3 10h18M3 10v4a1 1 0 001 1h1M21 10v4a1 1 0 01-1 1h-1"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM9 17h6M5 17l4-8h4l2 4M9 9l3-4 4 1"/>
                        @endif
                    </svg>
                </div>
            @endif

            {{-- Nama + Status --}}
            <div class="mt-5 flex items-start justify-between gap-3 flex-wrap">
                <div>
                    <h1 class="text-xl md:text-2xl font-extrabold text-navy">{{ $vehicle->name }}</h1>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mt-1">
                        {{ $vehicle->type_label }} · {{ $vehicle->location }}
                    </p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold
                             {{ $vehicle->status === 'available' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }}">
                    <span class="w-2 h-2 rounded-full {{ $vehicle->status === 'available' ? 'bg-green-500' : 'bg-yellow-400' }}"></span>
                    {{ $vehicle->status_label }}
                </span>
            </div>

            {{-- Rating summary --}}
            @if($vehicle->review_count > 0)
            <div class="flex items-center gap-1 mt-2">
                @for($s = 1; $s <= 5; $s++)
                    <span class="text-base {{ $s <= round($vehicle->avg_rating) ? 'text-yellow-400' : 'text-slate-200' }}">★</span>
                @endfor
                <span class="text-sm font-bold text-slate-800 ml-1">{{ $vehicle->avg_rating }}</span>
                <span class="text-sm text-slate-400">({{ $vehicle->review_count }} ulasan)</span>
            </div>
            @else
            <p class="text-sm text-slate-400 mt-2">Belum ada ulasan</p>
            @endif

            {{-- Spesifikasi --}}
            <div class="grid grid-cols-4 gap-2 mt-5">
                <div class="flex flex-col items-center gap-1 py-3 px-2 rounded-xl bg-slate-50 border border-slate-200 text-center">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Tipe</span>
                    <span class="text-[12px] font-bold text-slate-700">{{ $vehicle->type_label }}</span>
                </div>
                <div class="flex flex-col items-center gap-1 py-3 px-2 rounded-xl bg-slate-50 border border-slate-200 text-center">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Lokasi</span>
                    <span class="text-[12px] font-bold text-slate-700">{{ $vehicle->location }}</span>
                </div>
                <div class="flex flex-col items-center gap-1 py-3 px-2 rounded-xl bg-slate-50 border border-slate-200 text-center">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 10l1.5-4h13L21 10M3 10h18M3 10v4a1 1 0 001 1h1M21 10v4a1 1 0 01-1 1h-1"/>
                    </svg>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Plat</span>
                    <span class="text-[12px] font-bold text-slate-700">{{ $vehicle->plate_number }}</span>
                </div>
                <div class="flex flex-col items-center gap-1 py-3 px-2 rounded-xl bg-slate-50 border border-slate-200 text-center">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Status</span>
                    <span class="text-[12px] font-bold text-slate-700">{{ $vehicle->status_label }}</span>
                </div>
            </div>

            {{-- Info pemilik --}}
            @if($vehicle->rentalOwner)
            <div class="mt-5 p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-navy flex items-center justify-center
                            text-sm font-bold text-white shrink-0">
                    {{ strtoupper(substr($vehicle->rentalOwner->business_name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-slate-800">{{ $vehicle->rentalOwner->business_name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ $vehicle->rentalOwner->business_address }}</p>
                </div>
                @if($vehicle->rentalOwner->verification_status === 'verified')
                <span class="ml-auto inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-600 shrink-0">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Terverifikasi
                </span>
                @endif
            </div>

            {{-- Jam Operasional --}}
            @if($vehicle->rentalOwner->operating_hours)
                @php
                    [$jamBuka, $jamTutup] = array_map('trim', explode('-', $vehicle->rentalOwner->operating_hours));
                    $sekarang = now()->format('H:i');
                    $isOpen = $sekarang >= $jamBuka && $sekarang <= $jamTutup;
                @endphp
                <div class="flex items-center gap-2 mt-3">
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $isOpen ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isOpen ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        {{ $isOpen ? 'Buka sekarang' : 'Tutup' }}
                    </span>
                    <span class="text-xs text-slate-400">
                        Jam operasional: {{ $vehicle->rentalOwner->operating_hours }}
                    </span>
                </div>
            @endif

            {{-- Tombol WhatsApp --}}
            @if($vehicle->rentalOwner->whatsapp_number)
                @php
                    $waClean = preg_replace('/[^0-9]/', '', $vehicle->rentalOwner->whatsapp_number);
                    $waClean = ltrim($waClean, '0');
                    $waLink = 'https://wa.me/62' . $waClean;
                @endphp
                <a href="{{ $waLink }}" target="_blank"
                class="inline-flex items-center gap-2 text-sm font-semibold text-green-600
                        border border-green-200 bg-green-50 px-3 py-1.5 rounded-lg mt-3
                        hover:bg-green-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 20l1.65-3.8a9 9 0 1113.4 0L20 20l-4-1.5a9 9 0 01-8 0L3 20z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 10a.5.5 0 001 0V9a.5.5 0 00-1 0v1zM9 10a5 5 0 005 5"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
            @endif
            @endif

            {{-- Mobile CTA --}}
            <div class="md:hidden mt-5 sticky bottom-16 z-30 pb-2">
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xl font-extrabold text-sky-500">
                                Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-slate-500"> / hari</span>
                        </div>
                        @if($vehicle->status === 'available')
                        <a href="{{ auth()->check() ? route('bookings.create', $vehicle->id) : route('login') }}"
                           class="px-5 py-2.5 rounded-lg font-bold text-sm text-white bg-sky-500 hover:bg-sky-600 transition-colors shadow-sm">
                            {{ auth()->check() ? 'Pesan Sekarang' : 'Login untuk Pesan' }}
                        </a>
                        @else
                        <span class="px-4 py-2.5 rounded-lg font-bold text-sm bg-slate-100 text-slate-400">
                            Tidak Tersedia
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Ulasan ── --}}
            <div class="mt-8">
                <h2 class="text-base font-bold text-navy mb-4">
                    Ulasan Pelanggan
                    @if($vehicle->review_count > 0)
                        <span class="text-sm font-normal text-slate-400 ml-1">({{ $vehicle->review_count }})</span>
                    @endif
                </h2>

                @if($vehicle->review_count > 0)

                {{-- Ringkasan rating --}}
                <div class="flex gap-6 items-center p-4 rounded-xl border border-slate-200 bg-slate-50 mb-5">
                    <div class="text-center shrink-0">
                        <div class="text-4xl font-extrabold text-navy">{{ $vehicle->avg_rating }}</div>
                        <div class="flex justify-center gap-0.5 mt-1">
                            @for($s = 1; $s <= 5; $s++)
                                <span class="text-base {{ $s <= round($vehicle->avg_rating) ? 'text-yellow-400' : 'text-slate-200' }}">★</span>
                            @endfor
                        </div>
                        <div class="text-[11px] text-slate-400 mt-1">{{ $vehicle->review_count }} ulasan</div>
                    </div>
                    <div class="flex-1 flex flex-col gap-1.5">
                        @foreach($ratingDistribution as $bintang => $data)
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] text-slate-500 w-3 text-right">{{ $bintang }}</span>
                            <span class="text-[11px] text-yellow-400">★</span>
                            <div class="flex-1 h-1.5 rounded-full bg-slate-200 overflow-hidden">
                                <div class="h-full rounded-full bg-yellow-400 transition-all duration-500"
                                     style="width:{{ $data['percent'] }}%"></div>
                            </div>
                            <span class="text-[11px] text-slate-400 w-5">{{ $data['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- List ulasan --}}
                <div class="flex flex-col gap-3">
                    @foreach($ulasan as $r)
                    <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-full bg-navy flex items-center justify-center
                                        text-[11px] font-bold text-white shrink-0">
                                {{ strtoupper(substr($r->user->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[13px] font-bold text-slate-800">{{ $r->user->name ?? 'Pengguna' }}</p>
                                <div class="flex gap-0.5">
                                    @for($s = 1; $s <= 5; $s++)
                                        <span class="text-[11px] {{ $s <= $r->rating ? 'text-yellow-400' : 'text-slate-200' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <span class="ml-auto text-[11px] text-slate-400">{{ $r->created_at->diffForHumans() }}</span>
                        </div>
                        @if($r->comment)
                        <p class="text-[13px] text-slate-600 leading-relaxed">{{ $r->comment }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>

                @else
                <div class="text-center py-10 text-slate-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-sm">Belum ada ulasan untuk kendaraan ini.</p>
                </div>
                @endif

                {{-- ── Flash messages ── --}}
                @if(session('success'))
                <div class="mt-4 px-4 py-3 rounded-lg text-sm font-semibold bg-green-50 text-green-700 border border-green-200">
                    {{ session('success') }}
                </div>
                @endif
                @if($errors->has('review'))
                <div class="mt-4 px-4 py-3 rounded-lg text-sm font-semibold bg-red-50 text-red-600 border border-red-200">
                    {{ $errors->first('review') }}
                </div>
                @endif

                {{-- ── Form Ulasan ── --}}
                @auth
                @php
                    $sudahReview = \App\Models\Review::where('user_id', auth()->id())
                        ->where('vehicle_id', $vehicle->id)->exists();
                    $bolehReview = \App\Models\Booking::where('user_id', auth()->id())
                        ->where('vehicle_id', $vehicle->id)
                        ->where('status', 'completed')->exists();
                @endphp

                <div class="mt-6 p-5 rounded-xl border border-slate-200 bg-slate-50">
                    @if($sudahReview)
                    <div class="text-center py-4">
                        <svg class="w-8 h-8 mx-auto text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm font-semibold text-green-600 mt-2">Kamu sudah memberikan ulasan.</p>
                    </div>

                    @elseif(!$bolehReview)
                    <div class="text-center py-4">
                        <svg class="w-8 h-8 mx-auto text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <p class="text-sm font-semibold text-slate-500 mt-2">
                            Kamu bisa memberikan ulasan setelah menyewa kendaraan ini.
                        </p>
                    </div>

                    @else
                    <h3 class="text-sm font-bold text-navy mb-4">Tulis Ulasan</h3>
                    <form method="POST" action="{{ url('/reviews') }}">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                        {{-- Bintang --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-500 mb-2">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-1" id="star-container">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" data-value="{{ $i }}"
                                        onclick="setRating({{ $i }})"
                                        onmouseover="hoverRating({{ $i }})"
                                        onmouseout="resetHover()"
                                        class="star-btn text-4xl leading-none text-slate-200
                                               hover:scale-110 transition-transform bg-transparent border-none cursor-pointer p-0">
                                    ★
                                </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                            @error('rating')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-500 mb-2">
                                Komentar <span class="text-slate-400">(opsional)</span>
                            </label>
                            <textarea name="comment" rows="3" maxlength="1000"
                                      placeholder="Ceritakan pengalaman kamu..."
                                      class="w-full rounded-lg px-4 py-3 text-sm border border-slate-200
                                             bg-white text-slate-800 outline-none resize-none
                                             focus:border-sky-400 transition-colors">{{ old('comment') }}</textarea>
                            @error('comment')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="px-6 py-2.5 rounded-lg text-sm font-bold text-white
                                       bg-sky-500 hover:bg-sky-600 transition-colors">
                            Kirim Ulasan
                        </button>
                    </form>
                    @endif
                </div>

                @else
                <div class="mt-6 p-5 rounded-xl border border-slate-200 bg-slate-50 text-center">
                    <p class="text-sm text-slate-500">
                        <a href="{{ route('login') }}" class="text-sky-500 font-bold">Login</a>
                        untuk memberikan ulasan.
                    </p>
                </div>
                @endauth

            </div>{{-- /ulasan --}}

        </div>{{-- /kiri --}}

        {{-- ── KANAN: Booking Panel (desktop) ── --}}
        <div class="hidden md:block">
            <div class="sticky top-4 bg-white rounded-2xl border border-slate-200 p-6 shadow-lg">
                <div class="mb-4">
                    <div class="text-2xl font-extrabold text-sky-500">
                        Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                    </div>
                    <div class="text-xs text-slate-500">per hari</div>
                </div>

                <div class="border-y border-slate-100 py-4 mb-4 flex flex-col gap-2">
                    @foreach([
                        ['Tipe',$vehicle->type_label],
                        ['Lokasi',$vehicle->location],
                    ] as [$k,$v2])
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">{{ $k }}</span>
                        <span class="font-semibold text-slate-800">{{ $v2 }}</span>
                    </div>
                    @endforeach
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Status</span>
                        <span class="font-semibold {{ $vehicle->status === 'available' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $vehicle->status_label }}
                        </span>
                    </div>
                    @if($vehicle->review_count > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Rating</span>
                        <span class="font-semibold text-slate-800">★ {{ $vehicle->avg_rating }} / 5</span>
                    </div>
                    @endif
                </div>

                @if($vehicle->status === 'available')
                    @auth
                    <a href="{{ route('bookings.create', $vehicle->id) }}"
                       class="block w-full text-center py-3 rounded-xl font-bold text-white
                              bg-sky-500 hover:bg-sky-600 transition-colors shadow-md">
                        Pesan Sekarang →
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                       class="block w-full text-center py-3 rounded-xl font-bold text-white
                              bg-sky-500 hover:bg-sky-600 transition-colors shadow-md">
                        Login untuk Memesan
                    </a>
                    <p class="text-center text-xs text-slate-400 mt-2">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-sky-500 font-semibold">Daftar</a>
                    </p>
                    @endauth
                @else
                <button disabled class="w-full py-3 rounded-xl font-bold text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                    Sedang Tidak Tersedia
                </button>
                @endif

                @if($vehicle->rentalOwner)
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-[11px] text-slate-400 mb-1">Disediakan oleh</p>
                    <p class="text-sm font-bold text-slate-800">{{ $vehicle->rentalOwner->business_name }}</p>
                </div>
                @endif
            </div>
        </div>

    </div>{{-- /grid --}}

    {{-- Kendaraan Serupa --}}
    @if($kendaraanSerupa->count() > 0)
    <div class="mt-10">
        <h2 class="text-base font-bold text-navy mb-4">Kendaraan Serupa</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($kendaraanSerupa as $s)
            <a href="{{ url('/vehicles/' . $s->id) }}"
               class="block bg-white rounded-xl border border-slate-200 overflow-hidden
                      hover:shadow-[0_4px_16px_rgba(14,165,233,.1)] transition-shadow">
                @if($s->image_url)
                    <img src="{{ $s->image_url }}" alt="{{ $s->name }}" class="w-full h-28 object-cover">
                @else
                    <div class="w-full h-28 bg-slate-50 flex items-center justify-center">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0zM3 10l1.5-4h13L21 10M3 10h18M3 10v4a1 1 0 001 1h1M21 10v4a1 1 0 01-1 1h-1"/>
                        </svg>
                    </div>
                @endif
                <div class="p-3">
                    <p class="text-[13px] font-bold text-slate-800">{{ $s->name }}</p>
                    <p class="text-[13px] font-bold text-sky-500 mt-0.5">
                        Rp {{ number_format($s->price_per_day, 0, ',', '.') }}
                        <span class="text-[11px] font-normal text-slate-400">/hari</span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
let currentRating = {{ old('rating', 0) }};

function setRating(v) {
    currentRating = v;
    document.getElementById('rating-input').value = v;
    paintStars(v);
}
function hoverRating(v) { paintStars(v); }
function resetHover()   { paintStars(currentRating); }

function paintStars(v) {
    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.style.color = parseInt(btn.dataset.value) <= v ? '#FBBF24' : '#E2E8F0';
    });
}
if (currentRating > 0) paintStars(currentRating);
</script>
@endpush
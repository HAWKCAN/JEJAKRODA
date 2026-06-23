{{--
    Component: Cara Sewa
    Menampilkan SOP "Cara Menyewa Kendaraan" dari tabel platform_policies.
    Cara pakai: @include('components.cara-sewa', ['sopCaraSewa' => $sopCaraSewa])
--}}

@if($sopCaraSewa)
<section id="cara-sewa" class="py-12 md:py-16" style="background:#F8FAFC;">
    <div class="max-w-5xl mx-auto px-4 md:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold" style="color:#162740;">{{ $sopCaraSewa->title }}</h2>
            <p class="text-sm mt-2" style="color:#94A3B8;">Ikuti langkah-langkah berikut untuk menyewa kendaraan</p>
        </div>

        @php
            // Pecah content jadi array step berdasarkan format "1. ... 2. ..." dst
            $steps = preg_split('/\r?\n/', trim($sopCaraSewa->content));
            $steps = array_filter($steps, fn($s) => trim($s) !== '');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($steps as $index => $step)
                @php
                    // Hilangkan prefix nomor "1. " dari teks
                    $stepText = preg_replace('/^\d+\.\s*/', '', trim($step));
                @endphp
                <div class="bg-white rounded-xl p-5 border" style="border-color:#E2E8F0;">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center font-bold text-sm mb-3 text-white"
                         style="background:#0EA5E9;">
                        {{ $index + 1 }}
                    </div>
                    <p class="text-sm leading-relaxed" style="color:#475569;">{{ $stepText }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
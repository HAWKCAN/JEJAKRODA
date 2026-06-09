@extends('layouts.app')

@section('title', 'Pesan Kendaraan - ' . $vehicle->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Pesan Kendaraan</h1>
            <p class="text-gray-500 text-sm mt-1">Isi formulir di bawah untuk melakukan pemesanan</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- Info Kendaraan --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                    @if($vehicle->image_url)
                        <img src="{{ Storage::url($vehicle->image_url) }}" alt="{{ $vehicle->name }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 17l4-4 4 4m-4-4V3M3 8l4-4 4 4M3 16l4 4 4-4"/>
                            </svg>
                        </div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $vehicle->type === 'motor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                {{ ucfirst($vehicle->type) }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                Tersedia
                            </span>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">{{ $vehicle->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $vehicle->plate_number }}</p>
                        <p class="text-sm text-gray-500">{{ $vehicle->location }}</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-400 uppercase tracking-wide font-medium">Harga Sewa</p>
                            <p class="text-xl font-bold text-indigo-600 mt-1">
                                Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                <span class="text-sm font-normal text-gray-400">/ hari</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Pemesanan --}}
            <div class="lg:col-span-3">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">

                        <h3 class="font-semibold text-gray-800 text-lg border-b pb-3">Detail Pemesanan</h3>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Mulai Sewa <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ old('start_date') }}"
                                   class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                          @error('start_date') border-red-400 @enderror">
                            @error('start_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Selesai Sewa <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="end_date" name="end_date"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   value="{{ old('end_date') }}"
                                   class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                          @error('end_date') border-red-400 @enderror">
                            @error('end_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Catatan <span class="text-gray-400 font-normal">(opsional)</span>
                            </label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Contoh: tujuan perjalanan, kebutuhan khusus, dsb."
                                      class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Rincian Harga (dinamis via JS) --}}
                        <div id="price-breakdown" class="hidden bg-indigo-50 rounded-xl p-4 space-y-2">
                            <h4 class="text-sm font-semibold text-indigo-800 mb-3">Rincian Biaya</h4>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Durasi Sewa</span>
                                <span id="days-display" class="font-medium">-</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span id="subtotal-display" class="font-medium">-</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Biaya Platform (5%)</span>
                                <span id="fee-display" class="font-medium text-orange-600">-</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold text-indigo-900 border-t border-indigo-200 pt-2 mt-2">
                                <span>Total Bayar</span>
                                <span id="total-display">-</span>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold py-3 rounded-xl transition-colors duration-150 text-sm">
                            Buat Pemesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const pricePerDay  = {{ $vehicle->price_per_day }};
    const feePercent   = 5;

    const startInput   = document.getElementById('start_date');
    const endInput     = document.getElementById('end_date');
    const breakdown    = document.getElementById('price-breakdown');

    function formatRupiah(number) {
        return 'Rp ' + number.toLocaleString('id-ID');
    }

    function calculatePrice() {
        const start = new Date(startInput.value);
        const end   = new Date(endInput.value);

        if (!startInput.value || !endInput.value || end <= start) {
            breakdown.classList.add('hidden');
            return;
        }

        const diffMs   = end - start;
        const totalDays = Math.max(1, Math.ceil(diffMs / (1000 * 60 * 60 * 24)));
        const subtotal  = totalDays * pricePerDay;
        const fee       = subtotal * (feePercent / 100);
        const total     = subtotal + fee;

        document.getElementById('days-display').textContent    = totalDays + ' hari';
        document.getElementById('subtotal-display').textContent = formatRupiah(subtotal);
        document.getElementById('fee-display').textContent     = formatRupiah(fee);
        document.getElementById('total-display').textContent   = formatRupiah(total);

        breakdown.classList.remove('hidden');

        // Sesuaikan min end_date berdasarkan start_date
        endInput.min = new Date(start.getTime() + 86400000).toISOString().split('T')[0];
    }

    startInput.addEventListener('change', calculatePrice);
    endInput.addEventListener('change', calculatePrice);

    // Hitung ulang jika sudah ada nilai (old input)
    if (startInput.value && endInput.value) calculatePrice();
</script>
@endpush
@endsection
@extends('layouts.manager')

@section('title', 'Catat Pengembalian #' . $booking->id)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('manager.bookings.show', $booking) }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Detail Booking
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Catat Pengembalian</h1>
            <p class="text-gray-500 text-sm mt-1">Booking <span class="font-medium text-indigo-600">#{{ $booking->id }}</span> atas nama <span class="font-medium">{{ $booking->user->name }}</span></p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- Info Booking --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-6 space-y-4">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Info Sewa</h3>

                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">Kendaraan</p>
                            <p class="font-semibold text-gray-900">{{ $booking->vehicle->name }}</p>
                            <p class="text-gray-500 text-xs">{{ $booking->vehicle->plate_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Pelanggan</p>
                            <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Tanggal Mulai</p>
                            <p class="font-medium text-gray-800">{{ $booking->start_date->format('d M Y') }}</p>
                        </div>
                        <div class="bg-red-50 border border-red-100 rounded-xl p-3">
                            <p class="text-red-500 text-xs font-medium mb-0.5">Batas Pengembalian</p>
                            <p class="font-bold text-red-700">{{ $booking->end_date->format('d M Y') }}</p>
                            <p class="text-red-500 text-xs">Pukul 23:59</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Harga per Hari</p>
                            <p class="font-semibold text-indigo-600">Rp {{ number_format($booking->vehicle->price_per_day, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-orange-50 border border-orange-100 rounded-xl p-3">
                            <p class="text-orange-600 text-xs font-medium">Tarif Denda per Jam</p>
                            <p class="font-bold text-orange-700">
                                Rp {{ number_format($booking->vehicle->price_per_day / 24, 0, ',', '.') }}
                            </p>
                            <p class="text-orange-500 text-xs">(harga/hari ÷ 24 jam)</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Pengembalian --}}
            <div class="lg:col-span-3">
               <form action="{{ route('manager.returns.store', ['booking' => $booking->id]) }}" method="POST" id="return-form">
                    @csrf
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
                        <h3 class="font-semibold text-gray-800 text-lg border-b pb-3">Detail Pengembalian</h3>

                        {{-- Waktu Pengembalian Aktual --}}
                        <div>
                            <label for="returned_at" class="block text-sm font-medium text-gray-700 mb-1">
                                Waktu Pengembalian Aktual <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" id="returned_at" name="returned_at"
                                   value="{{ old('returned_at', now()->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                                          @error('returned_at') border-red-400 @enderror">
                            @error('returned_at')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Preview Denda Otomatis --}}
                        <div id="late-fee-preview" class="hidden rounded-xl p-4 border">
                            <div id="no-late" class="hidden">
                                <div class="flex items-center gap-2 text-green-700">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-semibold">Tidak ada keterlambatan — Tidak ada denda</span>
                                </div>
                            </div>
                            <div id="has-late" class="hidden">
                                <p class="text-sm font-semibold text-red-700 mb-2">⚠️ Terlambat!</p>
                                <div class="space-y-1 text-sm text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Keterlambatan</span>
                                        <span id="hours-late-display" class="font-medium text-red-600"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Tarif per jam</span>
                                        <span class="font-medium">Rp {{ number_format($booking->vehicle->price_per_day / 24, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between font-bold text-red-700 border-t pt-2 mt-2">
                                        <span>Total Denda</span>
                                        <span id="late-fee-display"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kondisi Kendaraan --}}
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">
                                Kondisi Kendaraan Saat Dikembalikan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="condition" name="condition" rows="4"
                                      placeholder="Contoh: Kondisi baik, tidak ada kerusakan. Atau: Terdapat goresan di bumper kiri, bensin terisi penuh."
                                      class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none
                                             @error('condition') border-red-400 @enderror">{{ old('condition') }}</textarea>
                            @error('condition')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition-colors text-sm">
                            Simpan Pengembalian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const pricePerDay   = {{ $booking->vehicle->price_per_day }};
    const endDateStr    = '{{ $booking->end_date->format('Y-m-d') }}T23:59:59';
    const dueAt         = new Date(endDateStr);

    function formatRupiah(n) {
        return 'Rp ' + Math.round(n).toLocaleString('id-ID');
    }

    document.getElementById('returned_at').addEventListener('change', function () {
        const returnedAt = new Date(this.value);
        const preview    = document.getElementById('late-fee-preview');
        const noLate     = document.getElementById('no-late');
        const hasLate    = document.getElementById('has-late');

        if (!this.value) { preview.classList.add('hidden'); return; }

        preview.classList.remove('hidden');

        if (returnedAt <= dueAt) {
            preview.className = 'rounded-xl p-4 border bg-green-50 border-green-200';
            noLate.classList.remove('hidden');
            hasLate.classList.add('hidden');
        } else {
            const diffMinutes = (returnedAt - dueAt) / 60000;
            const hoursLate   = Math.ceil(diffMinutes / 60);
            const hourlyRate  = pricePerDay / 24;
            const lateFee     = hoursLate * hourlyRate;

            const h = Math.floor(diffMinutes / 60);
            const m = Math.floor(diffMinutes % 60);
            document.getElementById('hours-late-display').textContent =
                h + ' jam ' + (m > 0 ? m + ' menit (dibulatkan ke atas → ' + hoursLate + ' jam)' : '');
            document.getElementById('late-fee-display').textContent = formatRupiah(lateFee);

            preview.className = 'rounded-xl p-4 border bg-red-50 border-red-200';
            hasLate.classList.remove('hidden');
            noLate.classList.add('hidden');
        }
    });

    // Trigger on load
    document.getElementById('returned_at').dispatchEvent(new Event('change'));
</script>
@endpush
@endsection
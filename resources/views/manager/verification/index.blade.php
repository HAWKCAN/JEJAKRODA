@extends('layouts.manager')

@section('title', 'Verifikasi Akun — Aspal Seru')

@section('content')

<div class="max-w-2xl mx-auto px-4 py-8">

    <h1 class="text-xl font-bold mb-2" style="color:#1E293B;">Verifikasi Akun Rental</h1>
    <p class="text-sm mb-6" style="color:#64748B;">
        Lengkapi dokumen berikut agar akun Anda dapat diverifikasi oleh admin dan dapat mulai menyewakan kendaraan.
    </p>

    {{-- Status badge --}}
    <div class="mb-6">
        @php
            $status = $rentalOwner->verification_status;
            $badge = match($status) {
                'verified' => ['bg' => '#F0FDF4', 'text' => '#16A34A', 'label' => 'Terverifikasi'],
                'rejected' => ['bg' => '#FEF2F2', 'text' => '#DC2626', 'label' => 'Ditolak'],
                default    => ['bg' => '#FEF9C3', 'text' => '#CA8A04', 'label' => 'Menunggu Verifikasi'],
            };
        @endphp
        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1 rounded-full"
              style="background:{{ $badge['bg'] }}; color:{{ $badge['text'] }};">
            {{ $badge['label'] }}
        </span>
    </div>

    @if(session('success'))
        <div class="text-sm rounded-lg p-3 mb-4" style="background-color:#F0FDF4; border:1px solid #BBF7D0; color:#16A34A;">
            {{ session('success') }}
        </div>
    @endif

    @if($status === 'rejected' && !empty($rentalOwner->rejection_reason))
        <div class="text-sm rounded-lg p-3 mb-4" style="background-color:#FEF2F2; border:1px solid #FCA5A5; color:#7F1D1D;">
            <strong class="block mb-1">Alasan Ditolak:</strong>
            {{ $rentalOwner->rejection_reason }}
        </div>
    @endif

    @if($errors->any())
        <div class="text-sm rounded-lg p-3 mb-4" style="background-color:#FCEBEB; border:1px solid #F09595; color:#A32D2D;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if($status === 'verified')
        <div class="text-sm rounded-lg p-3 mb-4" style="background-color:#FEF9C3; border:1px solid #FDE68A; color:#92400E;">
            Akun Anda sudah <strong>terverifikasi</strong>. Jika Anda mengubah data di bawah ini, status verifikasi
            akan kembali menjadi <strong>Pending</strong> dan akan diperiksa ulang oleh Super Admin.
        </div>
    @endif

    <form method="POST" action="{{ route('manager.verification.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1" style="color:#4A4540;">Nama Usaha / Rental</label>
            <input type="text" name="business_name" value="{{ old('business_name', $rentalOwner->business_name ?? '') }}"
                placeholder="Masukkan nama usaha rental"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border:1px solid #D4CFC6; color:#1A1A1A; background-color:#FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:#4A4540;">Alamat Usaha</label>
            <input type="text" name="business_address" value="{{ old('business_address', $rentalOwner->business_address ?? '') }}"
                placeholder="Masukkan alamat usaha"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border:1px solid #D4CFC6; color:#1A1A1A; background-color:#FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:#4A4540;">NPWP (Nomor Pajak)</label>
            <input type="text" name="tax_number" value="{{ old('tax_number', $rentalOwner->tax_number ?? '') }}"
                placeholder="Opsional"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border:1px solid #D4CFC6; color:#1A1A1A; background-color:#FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:#4A4540;">NIB (Nomor Induk Berusaha)</label>
            <input type="text" name="nib" value="{{ old('nib', $rentalOwner->nib) }}"
                placeholder="Masukkan NIB"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border:1px solid #D4CFC6; color:#1A1A1A; background-color:#FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color:#4A4540;">Foto KTP</label>

            @if($rentalOwner->ktp_image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$rentalOwner->ktp_image) }}" alt="KTP" class="h-32 rounded-lg border" style="border-color:#E2E8F0;">
                    <p class="text-xs mt-1" style="color:#94A3B8;">Dokumen saat ini. Upload baru untuk mengganti.</p>
                </div>
            @endif

            <input type="file" name="ktp_image" accept="image/*"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border:1px solid #D4CFC6; color:#1A1A1A; background-color:#FFFFFF;">
            <p class="text-xs mt-1" style="color:#9A9488;">Format JPG/PNG, maksimal 2MB.</p>
        </div>

        <button type="submit"
            class="w-full py-2 rounded-lg font-medium text-sm transition"
            style="background-color:#0EA5E9; color:#FFFFFF;"
            onmouseover="this.style.backgroundColor='#0C1B33'"
            onmouseout="this.style.backgroundColor='#0EA5E9'">
            @if($status === 'rejected')
                Kirim Ulang
            @elseif($status === 'verified')
                Simpan & Ajukan Verifikasi Ulang
            @else
                Kirim Dokumen
            @endif
        </button>
    </form>

</div>

@endsection
@extends('layouts.manager')

@section('title', 'Pengaturan Toko — Manager')
@section('page-title', 'Pengaturan Toko')

@section('content')

@if(session('success'))
    <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#16A34A;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#FEE2E2;border:1px solid #FCA5A5;color:#DC2626;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        <ul style="margin:0;padding-left:1.1rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ url('manager/settings') }}">
    @csrf @method('PATCH')

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;width:100%;">

        {{-- ===== KOLOM KIRI: OPERASIONAL TOKO ===== --}}
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Operasional Toko</span>
            </div>
            <div style="padding:1.25rem;">

                <div style="margin-bottom:1.25rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                        Jam Operasional
                    </label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <input type="time" name="jam_buka"
                            value="{{ old('jam_buka', $jamBuka ?? '08:00') }}"
                            style="flex:1;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;
                                font-size:.83rem;color:#1E293B;outline:none;box-sizing:border-box;">
                        <span style="color:#94A3B8;font-size:.83rem;">sampai</span>
                        <input type="time" name="jam_tutup"
                            value="{{ old('jam_tutup', $jamTutup ?? '20:00') }}"
                            style="flex:1;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;
                                font-size:.83rem;color:#1E293B;outline:none;box-sizing:border-box;">
                    </div>
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                        Nomor WhatsApp
                    </label>
                    <input type="text" name="whatsapp_number"
                        value="{{ old('whatsapp_number', $rentalOwner->whatsapp_number ?? '') }}"
                        placeholder="08xxxxxxxxxx"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                </div>

                <div style="margin-bottom:0;display:flex;align-items:center;gap:.6rem;">
                    <input type="checkbox" name="auto_confirm_booking" value="1"
                        id="autoConfirm"
                        {{ old('auto_confirm_booking', $rentalOwner->auto_confirm_booking ?? false) ? 'checked' : '' }}
                        style="width:1rem;height:1rem;">
                    <label for="autoConfirm" style="font-size:.83rem;color:#1E293B;">
                        Otomatis konfirmasi setiap pesanan baru
                    </label>
                </div>

            </div>
        </div>

        {{-- ===== KOLOM KANAN: DATA BANK ===== --}}
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Data Bank (Pencairan Dana)</span>
            </div>
            <div style="padding:1.25rem;">

                <div style="margin-bottom:1.25rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                        Nama Bank
                    </label>
                    <input type="text" name="bank_name"
                        value="{{ old('bank_name', $rentalOwner->bank_name ?? '') }}"
                        placeholder="Contoh: BCA, BRI, Mandiri"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                </div>

                <div style="margin-bottom:1.25rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                        Nomor Rekening
                    </label>
                    <input type="text" name="bank_account_number"
                        value="{{ old('bank_account_number', $rentalOwner->bank_account_number ?? '') }}"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                </div>

                <div style="margin-bottom:0;">
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                        Nama Pemilik Rekening
                    </label>
                    <input type="text" name="bank_account_holder"
                        value="{{ old('bank_account_holder', $rentalOwner->bank_account_holder ?? '') }}"
                        placeholder="Sesuai nama di buku tabungan"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                </div>

            </div>
        </div>

    </div>

    <button type="submit"
        style="width:100%;background:#162740;color:#fff;border:none;
               border-radius:.5rem;padding:.75rem;font-size:.85rem;
               font-weight:700;cursor:pointer;display:block;margin-top:1.25rem;">
        Simpan Pengaturan
    </button>

</form>

@endsection
@extends('layouts.superAdmin')

@section('title', 'Detail Pengguna — Super Admin')
@section('page-title', 'Detail Pengguna')

@section('content')

{{-- Flash message --}}
@if(session('success'))
    <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#16A34A;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#FEE2E2;border:1px solid #FCA5A5;color:#DC2626;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        {{ session('error') }}
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

{{-- Tombol kembali --}}
<div style="margin-bottom:1rem;">
    <a href="{{ url('superadmin/users') }}"
       style="color:#0EA5E9;font-size:.83rem;font-weight:600;text-decoration:none;">
        ← Kembali ke Daftar Pengguna
    </a>
</div>

{{-- ====================== HEADER PROFIL ====================== --}}
<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;
            padding:1.25rem;margin-bottom:1.25rem;
            display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">

    <div style="display:flex;align-items:center;gap:1rem;">
        <div style="width:3.25rem;height:3.25rem;border-radius:50%;
                    background:#162740;color:#fff;font-size:1.1rem;
                    font-weight:700;display:flex;align-items:center;
                    justify-content:center;flex-shrink:0;">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div>
            <div style="font-size:1.05rem;font-weight:700;color:#1E293B;">{{ $user->name }}</div>
            <div style="font-size:.8rem;color:#64748B;">{{ $user->email }}</div>
            <div style="font-size:.72rem;color:#94A3B8;margin-top:.15rem;">
                Daftar {{ $user->created_at->diffForHumans() }} &middot; No. Telp: {{ $user->phone_number ?? '-' }}
            </div>
        </div>
    </div>

    <div>
        @if($user->role === 'superAdmin')
            <span style="background:#F5F3FF;color:#7C3AED;font-size:.7rem;font-weight:700;padding:.3rem .75rem;border-radius:99px;">Super Admin</span>
        @elseif($user->role === 'manager')
            <span style="background:#DBEAFE;color:#1D4ED8;font-size:.7rem;font-weight:700;padding:.3rem .75rem;border-radius:99px;">Manager</span>
        @else
            <span style="background:#F1F5F9;color:#64748B;font-size:.7rem;font-weight:700;padding:.3rem .75rem;border-radius:99px;">User</span>
        @endif
    </div>
</div>

@if($user->role === 'manager' && $user->rentalOwner)
@php $rentalOwner = $user->rentalOwner; @endphp

{{-- ====================== STATUS VERIFIKASI ====================== --}}
<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;margin-bottom:1.25rem;">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;display:flex;justify-content:space-between;align-items:center;">
        <span style="font-size:.9rem;font-weight:700;color:#162740;">Status Verifikasi Toko</span>
        @if($rentalOwner->verification_status === 'verified')
            <span style="background:#DCFCE7;color:#16A34A;font-size:.7rem;font-weight:700;padding:.3rem .75rem;border-radius:99px;">Verified</span>
        @elseif($rentalOwner->verification_status === 'rejected')
            <span style="background:#FEE2E2;color:#DC2626;font-size:.7rem;font-weight:700;padding:.3rem .75rem;border-radius:99px;">Rejected</span>
        @else
            <span style="background:#FEF9C3;color:#CA8A04;font-size:.7rem;font-weight:700;padding:.3rem .75rem;border-radius:99px;">Pending</span>
        @endif
    </div>

    @if($rentalOwner->verification_status === 'rejected' && $rentalOwner->rejection_reason)
    <div style="padding:1rem 1.25rem;background:#FEF2F2;">
        <div style="font-size:.72rem;font-weight:700;color:#DC2626;margin-bottom:.25rem;text-transform:uppercase;">Alasan Ditolak</div>
        <p style="font-size:.83rem;color:#7F1D1D;margin:0;">{{ $rentalOwner->rejection_reason }}</p>
    </div>
    @endif
</div>

{{-- ====================== GRID 2 KOLOM ====================== --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">

    {{-- ===== KOLOM KIRI: DATA DIRI & LEGALITAS ===== --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Data Diri & Legalitas Usaha</span>
            </div>
            <div style="padding:1.25rem;">

                <div style="margin-bottom:1rem;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Nama Usaha / Rental</div>
                    <div style="font-size:.85rem;color:#1E293B;font-weight:600;">{{ $rentalOwner->business_name ?? '-' }}</div>
                </div>

                <div style="margin-bottom:1rem;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Alamat Usaha</div>
                    <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->business_address ?? '-' }}</div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:0;">
                    <div>
                        <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">NPWP</div>
                        <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->tax_number ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">NIB</div>
                        <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->nib ?? '-' }}</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- FOTO KTP --}}
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Foto KTP</span>
            </div>
            <div style="padding:1.25rem;">
                @if($rentalOwner->ktp_image)
                    <a href="{{ asset('storage/'.$rentalOwner->ktp_image) }}" target="_blank">
                        <img src="{{ asset('storage/'.$rentalOwner->ktp_image) }}" alt="KTP"
                             style="max-width:100%;border:1px solid #E2E8F0;border-radius:.5rem;display:block;">
                    </a>
                    <span style="font-size:.72rem;color:#94A3B8;display:block;margin-top:.4rem;">Klik gambar untuk memperbesar.</span>
                @else
                    <span style="font-size:.83rem;color:#94A3B8;">Belum ada foto KTP diunggah.</span>
                @endif
            </div>
        </div>

    </div>

    {{-- ===== KOLOM KANAN: OPERASIONAL & BANK ===== --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- OPERASIONAL TOKO --}}
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Operasional Toko</span>
            </div>
            <div style="padding:1.25rem;">

                <div style="margin-bottom:1rem;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Jam Operasional</div>
                    <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->operating_hours ?? '-' }}</div>
                </div>

                <div style="margin-bottom:1rem;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Nomor WhatsApp</div>
                    <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->whatsapp_number ?? '-' }}</div>
                </div>

                <div style="margin-bottom:0;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Konfirmasi Otomatis</div>
                    <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->auto_confirm_booking ? 'Aktif' : 'Nonaktif' }}</div>
                </div>

            </div>
        </div>

        {{-- DATA BANK --}}
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Data Bank (Pencairan Dana)</span>
            </div>
            <div style="padding:1.25rem;">

                <div style="margin-bottom:1rem;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Nama Bank</div>
                    <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->bank_name ?? '-' }}</div>
                </div>

                <div style="margin-bottom:1rem;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Nomor Rekening</div>
                    <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->bank_account_number ?? '-' }}</div>
                </div>

                <div style="margin-bottom:0;">
                    <div style="font-size:.7rem;font-weight:600;color:#94A3B8;text-transform:uppercase;margin-bottom:.2rem;">Nama Pemilik Rekening</div>
                    <div style="font-size:.85rem;color:#1E293B;">{{ $rentalOwner->bank_account_holder ?? '-' }}</div>
                </div>

            </div>
        </div>

    </div>

</div>

{{-- ====================== AKSI VERIFIKASI ====================== --}}
@if($rentalOwner->verification_status === 'pending' || $rentalOwner->verification_status === 'rejected')
<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;margin-top:1.25rem;">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
        <span style="font-size:.9rem;font-weight:700;color:#162740;">Tindakan Verifikasi</span>
    </div>
    <div style="padding:1.25rem;">

        <div style="display:flex;gap:1rem;flex-wrap:wrap;">

            {{-- Form Verifikasi (langsung submit, tanpa alasan) --}}
            <form method="POST" action="{{ url('superadmin/users/'.$user->id.'/verify') }}" style="flex:1;min-width:220px;">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="verified">
                <button type="submit"
                    style="width:100%;background:#DCFCE7;color:#16A34A;border:none;
                           border-radius:.5rem;padding:.65rem;font-size:.83rem;
                           font-weight:700;cursor:pointer;">
                    ✓ Verifikasi Akun Ini
                </button>
            </form>

            {{-- Tombol buka form reject --}}
            <button type="button" onclick="document.getElementById('rejectBox').style.display='block'; this.style.display='none';"
                style="flex:1;min-width:220px;background:#FEE2E2;color:#DC2626;border:none;
                       border-radius:.5rem;padding:.65rem;font-size:.83rem;
                       font-weight:700;cursor:pointer;">
                ✗ Tolak Akun Ini
            </button>

        </div>

        {{-- Form Reject dengan alasan, tersembunyi sampai tombol di atas diklik --}}
        <div id="rejectBox" style="display:none;margin-top:1rem;border-top:1px solid #F1F5F9;padding-top:1rem;">
            <form method="POST" action="{{ url('superadmin/users/'.$user->id.'/verify') }}">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="rejected">

                <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                    Alasan Penolakan
                </label>
                <textarea name="rejection_reason" rows="3" required
                    placeholder="Jelaskan alasan penolakan, misalnya: foto KTP tidak jelas, NIB tidak valid, dll."
                    style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;
                           font-size:.83rem;color:#1E293B;outline:none;box-sizing:border-box;resize:vertical;">{{ old('rejection_reason') }}</textarea>

                <button type="submit"
                    style="margin-top:.75rem;background:#DC2626;color:#fff;border:none;
                           border-radius:.5rem;padding:.6rem 1.25rem;font-size:.83rem;
                           font-weight:700;cursor:pointer;">
                    Kirim Penolakan
                </button>
            </form>
        </div>

    </div>
</div>
@endif

@else
{{-- User biasa / bukan manager dengan rentalOwner --}}
<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;padding:2rem;text-align:center;color:#94A3B8;font-size:.85rem;">
    Pengguna ini tidak memiliki data toko rental untuk diverifikasi.
</div>
@endif

@endsection
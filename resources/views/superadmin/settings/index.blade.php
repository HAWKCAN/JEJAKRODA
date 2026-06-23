@extends('layouts.superAdmin')

@section('title', 'Pengaturan Platform — Super Admin')
@section('page-title', 'Pengaturan Platform')

@section('content')

@if(session('success'))
    <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#16A34A;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        {{ session('success') }}
    </div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;align-items:start;">

    {{-- Form Pengaturan --}}
    <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
            <span style="font-size:.9rem;font-weight:700;color:#162740;">Pengaturan Platform</span>
        </div>
        <div style="padding:1.25rem;">
            <form method="POST" action="{{ url('superadmin/settings') }}">
                @csrf @method('PATCH')

                {{-- Fee Platform --}}
                <div style="margin-bottom:1.25rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                        Fee Platform (%)
                    </label>
                    <div style="position:relative;">
                        <input type="number" name="platformFeePercent"
                            value="{{ old('platformFeePercent', $settings['platformFeePercent'] ?? 5) }}"
                            min="0" max="100" step="0.1"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.55rem 2.5rem .55rem .85rem;font-size:.83rem;
                                   color:#1E293B;outline:none;box-sizing:border-box;">
                        <span style="position:absolute;right:.85rem;top:50%;transform:translateY(-50%);
                                     font-size:.83rem;color:#94A3B8;font-weight:600;">%</span>
                    </div>
                    <div style="font-size:.72rem;color:#94A3B8;margin-top:.25rem;">
                        Persentase potongan dari setiap transaksi booking
                    </div>
                    @error('platformFeePercent')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Denda Keterlambatan --}}
                <div style="margin-bottom:1.25rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                        Denda Keterlambatan (per jam)
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:.85rem;top:50%;transform:translateY(-50%);
                                     font-size:.83rem;color:#94A3B8;font-weight:600;">Rp</span>
                        <input type="number" name="lateFeePerHour"
                            value="{{ old('lateFeePerHour', $settings['lateFeePerHour'] ?? 15000) }}"
                            min="0"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.55rem .85rem .55rem 2.3rem;font-size:.83rem;
                                   color:#1E293B;outline:none;box-sizing:border-box;">
                    </div>
                    @error('lateFeePerHour')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Min & Max Hari Sewa --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.5rem;">
                    <div>
                        <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                            Minimal Hari Sewa
                        </label>
                        <input type="number" name="minBookingDays"
                            value="{{ old('minBookingDays', $settings['minBookingDays'] ?? 1) }}"
                            min="1"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                                   outline:none;box-sizing:border-box;">
                        @error('minBookingDays')
                            <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">
                            Maksimal Hari Sewa
                        </label>
                        <input type="number" name="maxBookingDays"
                            value="{{ old('maxBookingDays', $settings['maxBookingDays'] ?? 30) }}"
                            min="1"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                                   outline:none;box-sizing:border-box;">
                        @error('maxBookingDays')
                            <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                    style="width:100%;background:#162740;color:#fff;border:none;
                           border-radius:.5rem;padding:.65rem;font-size:.85rem;
                           font-weight:700;cursor:pointer;">
                    Simpan Pengaturan
                </button>

            </form>
        </div>
    </div>

    {{-- Panel Info --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">

        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Nilai Aktif Saat Ini</span>
            </div>
            <div style="padding:1.25rem;display:flex;flex-direction:column;gap:.6rem;">

                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:.6rem .85rem;background:#F8FAFC;border-radius:.5rem;">
                    <span style="font-size:.78rem;color:#64748B;font-weight:600;">Fee Platform</span>
                    <span style="font-size:.82rem;font-weight:700;color:#162740;">
                        {{ $settings['platformFeePercent'] ?? 5 }}%
                    </span>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:.6rem .85rem;background:#F8FAFC;border-radius:.5rem;">
                    <span style="font-size:.78rem;color:#64748B;font-weight:600;">Denda / Jam</span>
                    <span style="font-size:.82rem;font-weight:700;color:#162740;">
                        Rp {{ number_format($settings['lateFeePerHour'] ?? 15000, 0, ',', '.') }}
                    </span>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:.6rem .85rem;background:#F8FAFC;border-radius:.5rem;">
                    <span style="font-size:.78rem;color:#64748B;font-weight:600;">Durasi Sewa</span>
                    <span style="font-size:.82rem;font-weight:700;color:#162740;">
                        {{ $settings['minBookingDays'] ?? 1 }} – {{ $settings['maxBookingDays'] ?? 30 }} hari
                    </span>
                </div>

            </div>
        </div>

        <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:.75rem;padding:1rem 1.25rem;">
            <div style="font-size:.78rem;font-weight:700;color:#92400E;margin-bottom:.4rem;">
                Perhatian
            </div>
            <div style="font-size:.75rem;color:#78350F;line-height:1.6;">
                Perubahan pengaturan hanya berlaku untuk transaksi baru.
                Transaksi yang sudah berjalan tidak terpengaruh.
            </div>
        </div>

    </div>
</div>

@endsection
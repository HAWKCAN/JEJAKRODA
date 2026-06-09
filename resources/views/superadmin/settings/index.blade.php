@extends('layouts.superAdmin')

@section('title', 'Pengaturan Platform — Super Admin')
@section('page-title', 'Pengaturan Platform')

@section('content')

{{-- Flash --}}
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
            <span style="font-size:.9rem;font-weight:700;color:#162740;">Pengaturan Umum</span>
        </div>
        <div style="padding:1.25rem;">
            <form method="POST" action="{{ url('superadmin/settings') }}">
                @csrf @method('PATCH')

                {{-- App Name --}}
                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">
                        Nama Aplikasi
                    </label>
                    <input type="text" name="app_name"
                        value="{{ $settings['app_name'] ?? '' }}"
                        placeholder="Contoh: RentCo"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                    @error('app_name')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Platform Fee --}}
                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">
                        Fee Platform (%)
                    </label>
                    <div style="position:relative;">
                        <input type="number" name="platform_fee_percent"
                            value="{{ $settings['platform_fee_percent'] ?? '' }}"
                            min="0" max="100" step="0.1"
                            placeholder="Contoh: 10"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.55rem 2.5rem .55rem .85rem;font-size:.83rem;
                                   color:#1E293B;outline:none;box-sizing:border-box;">
                        <span style="position:absolute;right:.85rem;top:50%;transform:translateY(-50%);
                                     font-size:.83rem;color:#94A3B8;font-weight:600;">%</span>
                    </div>
                    <div style="font-size:.72rem;color:#94A3B8;margin-top:.25rem;">
                        Persentase fee yang dipotong dari setiap transaksi
                    </div>
                    @error('platform_fee_percent')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contact Email --}}
                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">
                        Email Kontak
                    </label>
                    <input type="email" name="contact_email"
                        value="{{ $settings['contact_email'] ?? '' }}"
                        placeholder="admin@rentco.id"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                    @error('contact_email')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contact Phone --}}
                <div style="margin-bottom:1.5rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">
                        Nomor Telepon Kontak
                    </label>
                    <input type="text" name="contact_phone"
                        value="{{ $settings['contact_phone'] ?? '' }}"
                        placeholder="08xxxxxxxxxx"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.55rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                    @error('contact_phone')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
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

        {{-- Preview nilai aktif --}}
        <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
                <span style="font-size:.9rem;font-weight:700;color:#162740;">Nilai Aktif Saat Ini</span>
            </div>
            <div style="padding:1.25rem;display:flex;flex-direction:column;gap:.75rem;">

                @foreach([
                    ['label' => 'Nama Aplikasi',    'key' => 'app_name',             'icon' => '🏷️'],
                    ['label' => 'Fee Platform',      'key' => 'platform_fee_percent', 'icon' => '💰', 'suffix' => '%'],
                    ['label' => 'Email Kontak',      'key' => 'contact_email',        'icon' => '✉️'],
                    ['label' => 'Telepon Kontak',    'key' => 'contact_phone',        'icon' => '📞'],
                ] as $item)
                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:.6rem .85rem;background:#F8FAFC;border-radius:.5rem;">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <span style="font-size:.9rem;">{{ $item['icon'] }}</span>
                        <span style="font-size:.78rem;color:#64748B;font-weight:600;">
                            {{ $item['label'] }}
                        </span>
                    </div>
                    <span style="font-size:.82rem;font-weight:700;color:#162740;">
                        {{ $settings[$item['key']] ?? '—' }}{{ isset($item['suffix']) && isset($settings[$item['key']]) ? $item['suffix'] : '' }}
                    </span>
                </div>
                @endforeach

            </div>
        </div>

        {{-- Catatan --}}
        <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:.75rem;padding:1rem 1.25rem;">
            <div style="font-size:.78rem;font-weight:700;color:#92400E;margin-bottom:.4rem;">
                ⚠️ Perhatian
            </div>
            <div style="font-size:.75rem;color:#78350F;line-height:1.6;">
                Perubahan <strong>Fee Platform</strong> hanya berlaku untuk transaksi baru.
                Transaksi yang sudah berjalan tidak terpengaruh.
            </div>
        </div>

    </div>
</div>

@endsection
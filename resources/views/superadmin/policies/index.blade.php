@extends('layouts.superAdmin')

@section('title', 'Kebijakan Platform — Super Admin')
@section('page-title', 'Kelola Kebijakan')

@section('content')

@if(session('success'))
    <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#16A34A;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        {{ session('success') }}
    </div>
@endif

<div style="display:grid;grid-template-columns:1fr 360px;gap:1rem;align-items:start;">

    {{-- Daftar Kebijakan --}}
    <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;
                    display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:.9rem;font-weight:700;color:#162740;">Daftar Kebijakan</span>
            <span style="font-size:.72rem;color:#94A3B8;">{{ $policies->count() }} kebijakan</span>
        </div>

        @forelse($policies as $policy)
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;">
                <div style="min-width:0;">

                    {{-- Title + badges --}}
                    <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.3rem;flex-wrap:wrap;">
                        <span style="font-size:.85rem;font-weight:700;color:#1E293B;">
                            {{ $policy->title }}
                        </span>

                        {{-- Type badge --}}
                        @php
                            $typeColor = match($policy->type) {
                                'sop'   => ['bg'=>'#DBEAFE','color'=>'#1D4ED8'],
                                'tos'   => ['bg'=>'#F5F3FF','color'=>'#7C3AED'],
                                'faq'   => ['bg'=>'#DCFCE7','color'=>'#16A34A'],
                                default => ['bg'=>'#F1F5F9','color'=>'#64748B'],
                            };
                        @endphp
                        <span style="background:{{ $typeColor['bg'] }};color:{{ $typeColor['color'] }};
                                     font-size:.65rem;font-weight:700;padding:.15rem .5rem;
                                     border-radius:99px;text-transform:uppercase;">
                            {{ $policy->type }}
                        </span>

                        {{-- Active badge --}}
                        @if($policy->is_active)
                            <span style="background:#DCFCE7;color:#16A34A;font-size:.65rem;
                                         font-weight:700;padding:.15rem .5rem;border-radius:99px;">
                                Aktif
                            </span>
                        @else
                            <span style="background:#FEE2E2;color:#DC2626;font-size:.65rem;
                                         font-weight:700;padding:.15rem .5rem;border-radius:99px;">
                                Nonaktif
                            </span>
                        @endif
                    </div>

                    <div style="font-size:.72rem;color:#94A3B8;margin-bottom:.4rem;">
                        Diperbarui {{ $policy->updated_at->diffForHumans() }}
                    </div>
                    <div style="font-size:.78rem;color:#475569;
                                display:-webkit-box;-webkit-line-clamp:2;
                                -webkit-box-orient:vertical;overflow:hidden;">
                        {{ $policy->content }}
                    </div>
                </div>

                {{-- Aksi --}}
                <div style="display:flex;gap:.4rem;flex-shrink:0;">
                    <button onclick="toggleEdit({{ $policy->id }})"
                        style="background:#F1F5F9;color:#475569;border:none;border-radius:.35rem;
                               padding:.3rem .65rem;font-size:.75rem;font-weight:600;cursor:pointer;">
                        Edit
                    </button>
                    <form method="POST"
                          action="{{ url('superadmin/policies/'.$policy->id) }}"
                          onsubmit="return confirm('Hapus kebijakan ini?')"
                          style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="background:#FEE2E2;color:#DC2626;border:none;border-radius:.35rem;
                                   padding:.3rem .65rem;font-size:.75rem;font-weight:600;cursor:pointer;">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Form Edit --}}
            <div id="edit-{{ $policy->id }}" style="display:none;margin-top:.85rem;">
                <form method="POST" action="{{ url('superadmin/policies/'.$policy->id) }}">
                    @csrf @method('PUT')
                    <div style="margin-bottom:.6rem;">
                        <input type="text" name="title" value="{{ $policy->title }}"
                            placeholder="Judul"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.5rem .85rem;font-size:.83rem;color:#1E293B;
                                   outline:none;box-sizing:border-box;">
                    </div>
                    <div style="margin-bottom:.6rem;">
                        <select name="type"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.5rem .85rem;font-size:.83rem;color:#1E293B;outline:none;">
                            <option value="sop"   {{ $policy->type === 'sop'   ? 'selected' : '' }}>SOP</option>
                            <option value="tos"   {{ $policy->type === 'tos'   ? 'selected' : '' }}>Terms of Service</option>
                            <option value="faq"   {{ $policy->type === 'faq'   ? 'selected' : '' }}>FAQ</option>
                            <option value="other" {{ $policy->type === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div style="margin-bottom:.6rem;">
                        <textarea name="content" rows="4"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.5rem .85rem;font-size:.83rem;color:#1E293B;
                                   outline:none;resize:vertical;box-sizing:border-box;">{{ $policy->content }}</textarea>
                    </div>
                    <div style="margin-bottom:.6rem;display:flex;align-items:center;gap:.5rem;">
                        <input type="checkbox" name="is_active" id="active-{{ $policy->id }}"
                               {{ $policy->is_active ? 'checked' : '' }}>
                        <label for="active-{{ $policy->id }}"
                               style="font-size:.78rem;color:#475569;font-weight:600;">
                            Aktifkan kebijakan
                        </label>
                    </div>
                    <div style="display:flex;gap:.5rem;">
                        <button type="submit"
                            style="background:#0EA5E9;color:#fff;border:none;border-radius:.5rem;
                                   padding:.4rem 1rem;font-size:.8rem;font-weight:600;cursor:pointer;">
                            Simpan
                        </button>
                        <button type="button" onclick="toggleEdit({{ $policy->id }})"
                            style="background:#F1F5F9;color:#64748B;border:none;border-radius:.5rem;
                                   padding:.4rem 1rem;font-size:.8rem;font-weight:600;cursor:pointer;">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @empty
        <div style="padding:2rem;text-align:center;color:#94A3B8;font-size:.85rem;">
            Belum ada kebijakan
        </div>
        @endforelse
    </div>

    {{-- Form Tambah --}}
    <div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;
                position:sticky;top:1rem;">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;">
            <span style="font-size:.9rem;font-weight:700;color:#162740;">Tambah Kebijakan</span>
        </div>
        <div style="padding:1.25rem;">
            <form method="POST" action="{{ url('superadmin/policies') }}">
                @csrf
                <div style="margin-bottom:.75rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">Judul</label>
                    <input type="text" name="title" placeholder="Contoh: Syarat & Ketentuan"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.5rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;box-sizing:border-box;">
                    @error('title')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div style="margin-bottom:.75rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">Tipe</label>
                    <select name="type"
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.5rem .85rem;font-size:.83rem;color:#1E293B;outline:none;">
                        <option value="sop">SOP</option>
                        <option value="tos">Terms of Service</option>
                        <option value="faq">FAQ</option>
                        <option value="other">Other</option>
                    </select>
                    @error('type')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div style="margin-bottom:.75rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">Isi Kebijakan</label>
                    <textarea name="content" rows="6" placeholder="Tulis isi kebijakan..."
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.5rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;resize:vertical;box-sizing:border-box;"></textarea>
                    @error('content')
                        <div style="color:#DC2626;font-size:.72rem;margin-top:.25rem;">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit"
                    style="width:100%;background:#162740;color:#fff;border:none;border-radius:.5rem;
                           padding:.6rem;font-size:.83rem;font-weight:700;cursor:pointer;">
                    Tambah Kebijakan
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function toggleEdit(id) {
    const el = document.getElementById('edit-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>

@endsection
@extends('layouts.superadmin')

@section('title', 'Kebijakan Platform — Super Admin')
@section('page-title', 'Kelola Kebijakan')

@section('content')

{{-- Flash --}}
@if(session('success'))
    <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#16A34A;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        {{ session('success') }}
    </div>
@endif

<div style="display:grid;grid-template-columns:1fr 360px;gap:1rem;align-items:start;">

    {{-- Daftar kebijakan --}}
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
                    <div style="font-size:.85rem;font-weight:700;color:#1E293B;margin-bottom:.25rem;">
                        {{ $policy->title }}
                    </div>
                    <div style="font-size:.75rem;color:#94A3B8;margin-bottom:.5rem;">
                        /policies/{{ $policy->slug }}
                        · Diperbarui {{ $policy->updated_at->diffForHumans() }}
                    </div>
                    <div style="font-size:.78rem;color:#475569;
                                display:-webkit-box;-webkit-line-clamp:2;
                                -webkit-box-orient:vertical;overflow:hidden;">
                        {{ $policy->content }}
                    </div>
                </div>

                {{-- Aksi --}}
                <div style="display:flex;gap:.4rem;flex-shrink:0;">
                    {{-- Tombol Edit (toggle form) --}}
                    <button onclick="toggleEdit({{ $policy->id }})"
                        style="background:#F1F5F9;color:#475569;border:none;border-radius:.35rem;
                               padding:.3rem .65rem;font-size:.75rem;font-weight:600;cursor:pointer;">
                        Edit
                    </button>
                    {{-- Hapus --}}
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

            {{-- Form Edit (tersembunyi) --}}
            <div id="edit-{{ $policy->id }}" style="display:none;margin-top:.85rem;">
                <form method="POST" action="{{ url('superadmin/policies/'.$policy->id) }}">
                    @csrf @method('PUT')
                    <div style="margin-bottom:.6rem;">
                        <input type="text" name="title" value="{{ $policy->title }}"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.5rem .85rem;font-size:.83rem;color:#1E293B;
                                   outline:none;box-sizing:border-box;">
                    </div>
                    <div style="margin-bottom:.6rem;">
                        <textarea name="content" rows="4"
                            style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                                   padding:.5rem .85rem;font-size:.83rem;color:#1E293B;
                                   outline:none;resize:vertical;box-sizing:border-box;">{{ $policy->content }}</textarea>
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

    {{-- Form tambah kebijakan --}}
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
                </div>
                <div style="margin-bottom:.75rem;">
                    <label style="display:block;font-size:.75rem;font-weight:600;
                                  color:#64748B;margin-bottom:.35rem;">Isi Kebijakan</label>
                    <textarea name="content" rows="6" placeholder="Tulis isi kebijakan..."
                        style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;
                               padding:.5rem .85rem;font-size:.83rem;color:#1E293B;
                               outline:none;resize:vertical;box-sizing:border-box;"></textarea>
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
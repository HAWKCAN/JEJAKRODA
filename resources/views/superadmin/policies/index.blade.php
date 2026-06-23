@extends('layouts.superAdmin')

@section('title', 'Kebijakan Platform — Super Admin')
@section('page-title', 'SOP & Kebijakan')

@section('content')

@if(session('success'))
    <div style="background:#DCFCE7;border:1px solid #86EFAC;color:#16A34A;
                padding:.75rem 1rem;border-radius:.5rem;margin-bottom:1rem;font-size:.85rem;">
        {{ session('success') }}
    </div>
@endif

{{-- Filter + Tombol Tambah --}}
<div style="display:flex;justify-content:space-between;align-items:center;
            margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem;">

    <div style="display:flex;gap:.5rem;">
        <a href="{{ route('superadmin.policies.index') }}"
           style="padding:.5rem 1rem;border-radius:99px;font-size:.78rem;font-weight:600;text-decoration:none;
                  {{ !request('type') ? 'background:#162740;color:#fff;' : 'background:#fff;color:#64748B;border:1px solid #E2E8F0;' }}">
            Semua
        </a>
        <a href="{{ route('superadmin.policies.index', ['type' => 'sop']) }}"
           style="padding:.5rem 1rem;border-radius:99px;font-size:.78rem;font-weight:600;text-decoration:none;
                  {{ request('type') === 'sop' ? 'background:#0EA5E9;color:#fff;' : 'background:#fff;color:#64748B;border:1px solid #E2E8F0;' }}">
            SOP
        </a>
        <a href="{{ route('superadmin.policies.index', ['type' => 'tos']) }}"
           style="padding:.5rem 1rem;border-radius:99px;font-size:.78rem;font-weight:600;text-decoration:none;
                  {{ request('type') === 'tos' ? 'background:#8B5CF6;color:#fff;' : 'background:#fff;color:#64748B;border:1px solid #E2E8F0;' }}">
            TOS
        </a>
        <a href="{{ route('superadmin.policies.index', ['type' => 'faq']) }}"
           style="padding:.5rem 1rem;border-radius:99px;font-size:.78rem;font-weight:600;text-decoration:none;
                  {{ request('type') === 'faq' ? 'background:#22C55E;color:#fff;' : 'background:#fff;color:#64748B;border:1px solid #E2E8F0;' }}">
            FAQ
        </a>
    </div>

    <button onclick="openModal('createModal')"
        style="background:#0EA5E9;color:#fff;border:none;border-radius:.5rem;
               padding:.6rem 1.25rem;font-size:.83rem;font-weight:600;cursor:pointer;">
        + Tambah Kebijakan
    </button>
</div>

{{-- Tabel --}}
<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#F8FAFC;">
                <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;border-bottom:1px solid #E2E8F0;">Judul</th>
                <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;border-bottom:1px solid #E2E8F0;">Tipe</th>
                <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;border-bottom:1px solid #E2E8F0;">Status</th>
                <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;border-bottom:1px solid #E2E8F0;">Diperbarui</th>
                <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;font-weight:700;color:#64748B;text-transform:uppercase;border-bottom:1px solid #E2E8F0;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($policies as $policy)
            <tr style="border-bottom:1px solid #F1F5F9;">
                <td style="padding:.75rem 1rem;font-size:.83rem;font-weight:600;color:#1E293B;">{{ $policy->title }}</td>
                <td style="padding:.75rem 1rem;">
                    @php
                        $badge = match($policy->type) {
                            'sop' => ['#EFF6FF', '#0EA5E9'],
                            'tos' => ['#F5F3FF', '#8B5CF6'],
                            'faq' => ['#F0FDF4', '#22C55E'],
                            default => ['#F1F5F9', '#64748B'],
                        };
                    @endphp
                    <span style="background:{{ $badge[0] }};color:{{ $badge[1] }};font-size:.67rem;font-weight:700;padding:.2rem .6rem;border-radius:99px;text-transform:uppercase;">
                        {{ $policy->type }}
                    </span>
                </td>
                <td style="padding:.75rem 1rem;">
                    @if($policy->is_active)
                    <span style="background:#DCFCE7;color:#16A34A;font-size:.67rem;font-weight:700;padding:.2rem .6rem;border-radius:99px;">Aktif</span>
                    @else
                    <span style="background:#F1F5F9;color:#64748B;font-size:.67rem;font-weight:700;padding:.2rem .6rem;border-radius:99px;">Nonaktif</span>
                    @endif
                </td>
                <td style="padding:.75rem 1rem;font-size:.78rem;color:#94A3B8;">{{ $policy->updated_at->diffForHumans() }}</td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;">
                        <button onclick='openEditModal(@json($policy))'
                            style="background:#F1F5F9;color:#475569;border:none;border-radius:.35rem;
                                   padding:.3rem .65rem;font-size:.75rem;font-weight:600;cursor:pointer;">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('superadmin.policies.destroy', $policy->id) }}"
                              onsubmit="return confirm('Hapus kebijakan ini?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit"
                                style="background:#FEE2E2;color:#DC2626;border:none;border-radius:.35rem;
                                       padding:.3rem .65rem;font-size:.75rem;font-weight:600;cursor:pointer;">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:2rem;color:#94A3B8;font-size:.85rem;">
                    Belum ada kebijakan untuk kategori ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($policies->hasPages())
    <div style="padding:.85rem 1rem;border-top:1px solid #F1F5F9;">
        {{ $policies->links() }}
    </div>
    @endif
</div>

{{-- Modal Tambah --}}
<div id="createModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:60;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:.75rem;width:90%;max-width:520px;max-height:85vh;overflow-y:auto;">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:.95rem;font-weight:700;color:#162740;">Tambah Kebijakan</span>
            <button onclick="closeModal('createModal')" style="background:none;border:none;cursor:pointer;font-size:1.2rem;color:#94A3B8;">&times;</button>
        </div>
        <form method="POST" action="{{ route('superadmin.policies.store') }}" style="padding:1.25rem;">
            @csrf

            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">Judul</label>
                <input type="text" name="title" required
                    style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;font-size:.83rem;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">Tipe</label>
                <select name="type" required
                    style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;font-size:.83rem;box-sizing:border-box;">
                    <option value="sop">SOP</option>
                    <option value="tos">Terms of Service</option>
                    <option value="faq">FAQ</option>
                    <option value="other">Lainnya</option>
                </select>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">Isi Konten</label>
                <textarea name="content" rows="6" required
                    style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;font-size:.83rem;box-sizing:border-box;resize:vertical;"></textarea>
            </div>

            <button type="submit"
                style="width:100%;background:#0EA5E9;color:#fff;border:none;border-radius:.5rem;
                       padding:.65rem;font-size:.85rem;font-weight:700;cursor:pointer;">
                Simpan
            </button>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:60;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:.75rem;width:90%;max-width:520px;max-height:85vh;overflow-y:auto;">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F1F5F9;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:.95rem;font-weight:700;color:#162740;">Edit Kebijakan</span>
            <button onclick="closeModal('editModal')" style="background:none;border:none;cursor:pointer;font-size:1.2rem;color:#94A3B8;">&times;</button>
        </div>
        <form method="POST" id="editForm" style="padding:1.25rem;">
            @csrf @method('PATCH')

            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">Judul</label>
                <input type="text" name="title" id="edit_title" required
                    style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;font-size:.83rem;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">Tipe</label>
                <select name="type" id="edit_type" required
                    style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;font-size:.83rem;box-sizing:border-box;">
                    <option value="sop">SOP</option>
                    <option value="tos">Terms of Service</option>
                    <option value="faq">FAQ</option>
                    <option value="other">Lainnya</option>
                </select>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.75rem;font-weight:600;color:#64748B;margin-bottom:.35rem;">Isi Konten</label>
                <textarea name="content" id="edit_content" rows="6" required
                    style="width:100%;border:1px solid #E2E8F0;border-radius:.5rem;padding:.55rem .85rem;font-size:.83rem;box-sizing:border-box;resize:vertical;"></textarea>
            </div>

            <div style="margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;">
                <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                <label for="edit_is_active" style="font-size:.83rem;color:#1E293B;">Tampilkan ke publik</label>
            </div>

            <button type="submit"
                style="width:100%;background:#0EA5E9;color:#fff;border:none;border-radius:.5rem;
                       padding:.65rem;font-size:.85rem;font-weight:700;cursor:pointer;">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
function openEditModal(policy) {
    document.getElementById('edit_title').value = policy.title;
    document.getElementById('edit_type').value = policy.type;
    document.getElementById('edit_content').value = policy.content;
    document.getElementById('edit_is_active').checked = policy.is_active == 1;
    document.getElementById('editForm').action = '/superadmin/policies/' + policy.id;
    openModal('editModal');
}
</script>
@endpush
@extends('layouts.superAdmin')

@section('title', 'Kelola User — Super Admin')
@section('page-title', 'Kelola Pengguna')

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

{{-- Filter & Search --}}
<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;
            padding:1rem 1.25rem;margin-bottom:1rem;
            display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;">

    <form method="GET" action="{{ url('superadmin/users') }}"
          style="display:flex;gap:.75rem;flex:1;flex-wrap:wrap;">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            style="flex:1;min-width:200px;border:1px solid #E2E8F0;border-radius:.5rem;
                   padding:.5rem .85rem;font-size:.83rem;outline:none;color:#1E293B;">

        <select name="role"
            style="border:1px solid #E2E8F0;border-radius:.5rem;
                   padding:.5rem .85rem;font-size:.83rem;color:#1E293B;outline:none;">
            <option value="">Semua Role</option>
            <option value="user"       {{ request('role') === 'user'       ? 'selected' : '' }}>User</option>
            <option value="manager"    {{ request('role') === 'manager'    ? 'selected' : '' }}>Manager</option>
            <option value="superAdmin" {{ request('role') === 'superAdmin' ? 'selected' : '' }}>Super Admin</option>
        </select>

        <button type="submit"
            style="background:#0EA5E9;color:#fff;border:none;border-radius:.5rem;
                   padding:.5rem 1.25rem;font-size:.83rem;font-weight:600;cursor:pointer;">
            Filter
        </button>

        @if(request('search') || request('role'))
            <a href="{{ url('superadmin/users') }}"
               style="background:#F1F5F9;color:#64748B;border-radius:.5rem;
                      padding:.5rem 1rem;font-size:.83rem;font-weight:600;text-decoration:none;">
                Reset
            </a>
        @endif

    </form>
</div>

{{-- Tabel User --}}
<div style="background:#fff;border:1px solid #E2E8F0;border-radius:.75rem;overflow:hidden;">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8FAFC;">
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;
                               font-weight:700;color:#64748B;text-transform:uppercase;
                               letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Nama</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;
                               font-weight:700;color:#64748B;text-transform:uppercase;
                               letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Email</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;
                               font-weight:700;color:#64748B;text-transform:uppercase;
                               letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">No. Telepon</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;
                               font-weight:700;color:#64748B;text-transform:uppercase;
                               letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Role</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;
                               font-weight:700;color:#64748B;text-transform:uppercase;
                               letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Status Manager</th>
                    <th style="padding:.65rem 1rem;text-align:left;font-size:.68rem;
                               font-weight:700;color:#64748B;text-transform:uppercase;
                               letter-spacing:.05em;border-bottom:1px solid #E2E8F0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom:1px solid #F1F5F9;">

                    {{-- Nama + avatar --}}
                    <td style="padding:.75rem 1rem;">
                        <div style="display:flex;align-items:center;gap:.65rem;">
                            <div style="width:2rem;height:2rem;border-radius:50%;
                                        background:#162740;color:#fff;font-size:.7rem;
                                        font-weight:700;display:flex;align-items:center;
                                        justify-content:center;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:.83rem;font-weight:600;color:#1E293B;">
                                    {{ $user->name }}
                                </div>
                                <div style="font-size:.7rem;color:#94A3B8;">
                                    Daftar {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td style="padding:.75rem 1rem;font-size:.83rem;color:#1E293B;">
                        {{ $user->email }}
                    </td>

                    {{-- No Telepon --}}
                    <td style="padding:.75rem 1rem;font-size:.83rem;color:#1E293B;">
                        {{ $user->phone_number ?? '-' }}
                    </td>

                    {{-- Role badge --}}
                    <td style="padding:.75rem 1rem;">
                        @if($user->role === 'superAdmin')
                            <span style="background:#F5F3FF;color:#7C3AED;font-size:.67rem;
                                         font-weight:700;padding:.2rem .6rem;border-radius:99px;">
                                Super Admin
                            </span>
                        @elseif($user->role === 'manager')
                            <span style="background:#DBEAFE;color:#1D4ED8;font-size:.67rem;
                                         font-weight:700;padding:.2rem .6rem;border-radius:99px;">
                                Manager
                            </span>
                        @else
                            <span style="background:#F1F5F9;color:#64748B;font-size:.67rem;
                                         font-weight:700;padding:.2rem .6rem;border-radius:99px;">
                                User
                            </span>
                        @endif
                    </td>

                    {{-- Status verifikasi manager --}}
                    <td style="padding:.75rem 1rem;">
                        @if($user->role === 'manager' && $user->rentalOwner)
                            @if($user->rentalOwner->verification_status === 'verified')
                                <span style="background:#DCFCE7;color:#16A34A;font-size:.67rem;
                                             font-weight:700;padding:.2rem .6rem;border-radius:99px;">
                                    Verified
                                </span>
                            @elseif($user->rentalOwner->verification_status === 'rejected')
                                <span style="background:#FEE2E2;color:#DC2626;font-size:.67rem;
                                             font-weight:700;padding:.2rem .6rem;border-radius:99px;">
                                    Rejected
                                </span>
                            @else
                                <div style="display:flex;gap:.4rem;align-items:center;">
                                    <span style="background:#FEF9C3;color:#CA8A04;font-size:.67rem;
                                                 font-weight:700;padding:.2rem .6rem;border-radius:99px;">
                                        Pending
                                    </span>
                                    {{-- Tombol verify/reject --}}
                                    <form method="POST"
                                          action="{{ url('superadmin/users/'.$user->id.'/verify') }}"
                                          style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="verified">
                                        <button type="submit"
                                            style="background:#DCFCE7;color:#16A34A;border:none;
                                                   border-radius:.3rem;padding:.2rem .5rem;
                                                   font-size:.67rem;font-weight:700;cursor:pointer;">
                                            ✓
                                        </button>
                                    </form>
                                    <form method="POST"
                                          action="{{ url('superadmin/users/'.$user->id.'/verify') }}"
                                          style="display:inline;">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit"
                                            style="background:#FEE2E2;color:#DC2626;border:none;
                                                   border-radius:.3rem;padding:.2rem .5rem;
                                                   font-size:.67rem;font-weight:700;cursor:pointer;">
                                            ✗
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <span style="color:#CBD5E1;font-size:.8rem;">—</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td style="padding:.75rem 1rem;">
                        <div style="display:flex;gap:.5rem;align-items:center;">

                            {{-- Detail --}}
                            <a href="{{ url('superadmin/users/'.$user->id) }}"
                               style="background:#F1F5F9;color:#475569;border-radius:.35rem;
                                      padding:.3rem .65rem;font-size:.75rem;font-weight:600;
                                      text-decoration:none;">
                                Detail
                            </a>

                            {{-- Hapus — sembunyikan kalau diri sendiri --}}
                            @if(auth()->id() !== $user->id)
                            <form method="POST"
                                  action="{{ url('superadmin/users/'.$user->id) }}"
                                  onsubmit="return confirm('Hapus user {{ $user->name }}?')"
                                  style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="background:#FEE2E2;color:#DC2626;border:none;
                                           border-radius:.35rem;padding:.3rem .65rem;
                                           font-size:.75rem;font-weight:600;cursor:pointer;">
                                    Hapus
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6"
                        style="text-align:center;padding:2rem;color:#94A3B8;font-size:.85rem;">
                        Tidak ada user ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
    <div style="padding:.85rem 1rem;border-top:1px solid #F1F5F9;">
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
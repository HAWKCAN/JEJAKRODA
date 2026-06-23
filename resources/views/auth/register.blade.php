@extends('layouts.auth')

@section('title', 'Daftar — Jejak Roda')

@section('content')

    <h2 class="text-xl font-semibold mb-6" style="color: #0C1B33;">Buat akun baru</h2>

    @if($errors->any())
        <div class="text-sm rounded-lg p-3 mb-4" style="background-color: #FCEBEB; border: 1px solid #F09595; color: #A32D2D;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/register" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                placeholder="contoh@email.com"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">No. Telepon</label>
            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                placeholder="08xx-xxxx-xxxx"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Password</label>
            <input type="password" name="password"
                placeholder="Minimal 8 karakter"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                placeholder="Ulangi password"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Daftar sebagai</label>
            <select name="role" id="role"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onchange="document.getElementById('manager-fields').style.display = this.value === 'manager' ? 'block' : 'none'">
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Pelanggan</option>
                <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Pemilik Rental</option>
            </select>
        </div>

        <div id="manager-fields" class="space-y-4" style="display: {{ old('role') === 'manager' ? 'block' : 'none' }};">

            <div>
                <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Nama Usaha</label>
                <input type="text" name="business_name" value="{{ old('business_name') }}"
                    placeholder="Contoh: Aspal Seru Rental"
                    class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                    style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                    onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Alamat Usaha</label>
                <input type="text" name="business_address" value="{{ old('business_address') }}"
                    placeholder="Alamat lengkap usaha"
                    class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                    style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                    onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" style="color: #4A4540;">NPWP (opsional)</label>
                <input type="text" name="tax_number" value="{{ old('tax_number') }}"
                    placeholder="Nomor NPWP"
                    class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                    style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                    onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
            </div>

        </div>

        <button type="submit"
            class="w-full py-2 rounded-lg font-medium text-sm transition"
            style="background-color: #0EA5E9; color: #FFFFFF;"
            onmouseover="this.style.backgroundColor='#0C1B33'"
            onmouseout="this.style.backgroundColor='#0EA5E9'">
            Daftar
        </button>
    </form>

    <p class="text-center text-sm mt-6" style="color: #9A9488;">
        Sudah punya akun?
        <a href="/login" class="font-medium hover:underline" style="color: #0EA5E9;">Masuk</a>
    </p>

@endsection
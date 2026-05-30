@extends('layouts.auth')

@section('title', 'Masuk — Jejak Roda')

@section('content')

    <h2 class="text-xl font-semibold mb-6" style="color: #0C1B33;">Masuk ke akun</h2>

    @if($errors->any())
        <div class="text-sm rounded-lg p-3 mb-4" style="background-color: #FCEBEB; border: 1px solid #F09595; color: #A32D2D;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                placeholder="contoh@email.com"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1" style="color: #4A4540;">Password</label>
            <input type="password" name="password"
                placeholder="Password kamu"
                class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                style="border: 1px solid #D4CFC6; color: #1A1A1A; background-color: #FFFFFF;"
                onfocus="this.style.borderColor='#0EA5E9'" onblur="this.style.borderColor='#D4CFC6'">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded">
            <label for="remember" class="text-sm" style="color: #4A4540;">Ingat saya</label>
        </div>

        <button type="submit"
            class="w-full py-2 rounded-lg font-medium text-sm transition"
            style="background-color: #0EA5E9; color: #FFFFFF;"
            onmouseover="this.style.backgroundColor='#0C1B33'"
            onmouseout="this.style.backgroundColor='#0EA5E9'">
            Masuk
        </button>
    </form>

    <p class="text-center text-sm mt-6" style="color: #9A9488;">
        Belum punya akun?
        <a href="/register" class="font-medium hover:underline" style="color: #0EA5E9;">Daftar sekarang</a>
    </p>

@endsection
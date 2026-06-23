@extends('layouts.superAdmin')

@section('content')
<div class="bg-white min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <article class="max-w-3xl mx-auto">
        
        <!-- Back Navigation Link -->
        <div class="mb-6">
            <a href="{{ route('policies.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar Kebijakan
            </a>
        </div>

        <!-- Entry Metadata Header -->
        <header class="border-b border-slate-200 pb-6 mb-8">
            @php
                $badgeStyle = match($policy->type) {
                    'sop'   => 'bg-blue-50 text-blue-700 border-blue-200',
                    'tos'   => 'bg-purple-50 text-purple-700 border-purple-200',
                    'faq'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    default => 'bg-slate-50 text-slate-700 border-slate-200',
                };
            @endphp
            <span class="inline-flex items-center px-3 py-0.5 rounded-md text-xs font-bold border tracking-wider uppercase mb-3 {{ $badgeStyle }}">
                {{ $policy->type }}
            </span>
            
            <h1 class="text-2xl font-extrabold text-slate-950 sm:text-3xl tracking-tight">
                {{ $policy->title }}
            </h1>
            
            <div class="mt-3 flex items-center text-xs text-slate-500 gap-2">
                <span>Pembaruan terakhir: <b>{{ $policy->updated_at->translatedFormat('d F Y') }}</b></span>
            </div>
        </header>

        <!-- Main Formatted Text Document Body Container -->
        <div class="whitespace-pre-line text-slate-800 text-base leading-relaxed space-y-4">
            {{ $policy->content }}
        </div>

    </article>
</div>
@endsection
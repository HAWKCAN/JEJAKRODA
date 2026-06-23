@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-slate-950 sm:text-4xl tracking-tight">
                SOP & Kebijakan Platform
            </h1>
            <p class="mt-3 max-w-2xl mx-auto text-base text-slate-600">
                Pusat informasi regulasi publik, Panduan Standar Operasional Prosedur (SOP), dan Pertanyaan Umum (FAQ).
            </p>
        </div>

        <!-- Filter Tabs Component -->
        <div class="flex flex-wrap justify-center items-center gap-2 mb-8">
            <a href="{{ route('policies.index') }}" 
               class="px-4 py-2 rounded-full text-sm font-semibold tracking-wide transition-colors {{ !request('type') ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Semua Dokumen
            </a>
            <a href="{{ route('policies.index', ['type' => 'sop']) }}" 
               class="px-4 py-2 rounded-full text-sm font-semibold tracking-wide transition-colors {{ request('type') === 'sop' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                SOP
            </a>
            <a href="{{ route('policies.index', ['type' => 'tos']) }}" 
               class="px-4 py-2 rounded-full text-sm font-semibold tracking-wide transition-colors {{ request('type') === 'tos' ? 'bg-purple-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                Terms of Service
            </a>
            <a href="{{ route('policies.index', ['type' => 'faq']) }}" 
               class="px-4 py-2 rounded-full text-sm font-semibold tracking-wide transition-colors {{ request('type') === 'faq' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                FAQ
            </a>
        </div>

        <!-- Document Grid -->
        @if($policies->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center text-slate-500">
                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2-1 0 01-2-2V5a2 2-1 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2-1 0 01-2 2z"></path></svg>
                Tidak ada dokumen kebijakan kategori ini yang aktif publik saat ini.
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($policies as $policy)
                    <div class="bg-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between overflow-hidden">
                        <div class="p-6">
                            <!-- Category Badge -->
                            <div class="flex items-center justify-between mb-3">
                                @php
                                    $badgeStyle = match($policy->type) {
                                        'sop'   => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'tos'   => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'faq'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        default => 'bg-slate-50 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold border tracking-wider uppercase {{ $badgeStyle }}">
                                    {{ $policy->type }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    {{ $policy->updated_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Document Title -->
                            <h2 class="text-lg font-bold text-slate-900 line-clamp-1 mb-2 hover:text-blue-600">
                                <a href="{{ route('superadmin.policies.show', $policy->slug) }}">
                                    {{ $policy->title }}
                                </a>
                            </h2>

                            <!-- Content Preview Snippet -->
                            <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                {{ strip_tags($policy->content) }}
                            </p>
                        </div>

                        <!-- Card Footer Action Button -->
                        <div class="px-6 pb-6 pt-0">
                            <a href="{{ route('superadmin.policies.show', $policy->slug) }}" 
                               class="w-full text-center block px-4 py-2 rounded-lg text-xs font-bold bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-700 transition-colors">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Laravel Tailwind Pagination Links -->
            <div class="mt-10">
                {{ $policies->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
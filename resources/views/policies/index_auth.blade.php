@extends(auth()->user()->role === 'manager' ? 'layouts.manager' : 'layouts.app')

@section('title', 'SOP & Kebijakan')
@section('page-title', 'SOP & Kebijakan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">SOP & Kebijakan</h1>
            <p class="text-gray-500 text-sm mt-1">Panduan dan ketentuan resmi penggunaan layanan Aspal Seru</p>
        </div>

        @if($policies->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 font-medium">Belum ada SOP yang dipublikasikan</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($policies as $policy)
                <a href="{{ route('policies.show', $policy->slug) }}"
                   class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md hover:border-indigo-200 transition-all">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $policy->title }}</p>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($policy->content), 120) }}
                                </p>
                                <span class="inline-block mt-2 text-[10px] font-semibold uppercase tracking-wide px-2 py-0.5 rounded-full
                                    {{ $policy->type === 'sop' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ strtoupper($policy->type) }}
                                </span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $policies->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
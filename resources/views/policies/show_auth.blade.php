@extends(auth()->user()->role === 'manager' ? 'layouts.manager' : 'layouts.app')

@section('title', $policy->title)
@section('page-title', $policy->title)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('policies.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar SOP
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <span class="inline-block mb-3 text-[10px] font-semibold uppercase tracking-wide px-2 py-0.5 rounded-full
                {{ $policy->type === 'sop' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                {{ strtoupper($policy->type) }}
            </span>
            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $policy->title }}</h1>

            @php
                $lines = preg_split('/\r?\n/', trim($policy->content));
                $lines = array_filter($lines, fn($l) => trim($l) !== '');
                $isNumberedList = count($lines) > 1 && preg_match('/^\d+\.\s/', trim($lines[0]));
            @endphp

            @if($isNumberedList)
                <ol class="space-y-3">
                    @foreach($lines as $line)
                        @php $text = preg_replace('/^\d+\.\s*/', '', trim($line)); @endphp
                        <li class="flex gap-3 text-gray-700 text-sm leading-relaxed">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex items-center justify-center">
                                {{ $loop->iteration }}
                            </span>
                            <span class="pt-0.5">{{ $text }}</span>
                        </li>
                    @endforeach
                </ol>
            @else
                <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                    {{ $policy->content }}
                </div>
            @endif

            <p class="text-xs text-gray-400 mt-6 pt-4 border-t border-gray-100">
                Diperbarui {{ $policy->updated_at->format('d M Y') }}
            </p>
        </div>
    </div>
</div>
@endsection
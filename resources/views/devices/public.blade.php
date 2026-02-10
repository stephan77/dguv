@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">

    @php
        $last = $device->inspections->sortByDesc('inspection_date')->first();
    @endphp

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-lg border border-slate-200 p-6 text-center">

            {{-- Gerätename --}}
            <h1 class="text-lg font-semibold mb-1">
                {{ $device->name }}
            </h1>

            <p class="text-sm text-slate-500 mb-6">
                {{ $device->manufacturer }} {{ $device->model }}
            </p>

            @if($last)
{{-- AMPEL --}}
<div class="flex justify-center mb-6">
    <div class="relative">

        <div class="w-36 h-36 rounded-full flex items-center justify-center
            {{ $last->passed ? 'bg-green-500' : 'bg-red-500' }}
            shadow-2xl">

            @if($last->passed)
                {{-- Haken --}}
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" stroke-width="4"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>
            @else
                {{-- X --}}
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" stroke-width="4"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 6l12 12M6 18L18 6"/>
                </svg>
            @endif

        </div>

        {{-- Glow Effekt --}}
        <div class="absolute inset-0 rounded-full blur-2xl opacity-40
            {{ $last->passed ? 'bg-green-400' : 'bg-red-400' }}">
        </div>

    </div>
</div>

                {{-- STATUS TEXT --}}
                <div class="text-3xl font-bold mb-2
                    {{ $last->passed ? 'text-green-600' : 'text-red-600' }}">
                    {{ $last->passed ? 'BESTANDEN' : 'NICHT BESTANDEN' }}
                </div>

                {{-- DATUM --}}
                <div class="text-sm text-slate-600">
                    Letzte Prüfung<br>
                    <span class="font-semibold">
                        {{ $last->inspection_date->format('d.m.Y') }}
                    </span>
                </div>

            @else

                <div class="py-10 text-slate-500">
                    Noch keine Prüfung vorhanden
                </div>

            @endif

        </div>

    </div>
</div>
@endsection
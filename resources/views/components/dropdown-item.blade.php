{{-- 
Dropdown Item Component
Usage: <x-dropdown-item href="/settings">Settings</x-dropdown-item>
       <x-dropdown-item>Logout</x-dropdown-item>
--}}

@props([
    'href' => null,
    'icon' => null,
    'danger' => false
])

@php
    $baseClasses = 'flex items-center gap-3 px-4 py-2 text-sm transition';
    $colorClasses = $danger 
        ? 'text-red-400 hover:bg-red-500/10' 
        : 'text-white/70 hover:bg-white/5 hover:text-white';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $colorClasses]) }}>
        @if($icon)
            <i class="{{ $icon }} w-4"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => $baseClasses . ' ' . $colorClasses . ' w-full text-left']) }}>
        @if($icon)
            <i class="{{ $icon }} w-4"></i>
        @endif
        {{ $slot }}
    </button>
@endif

{{-- 
Badge Component
Usage: <x-badge type="success">Active</x-badge>
--}}

@props([
    'type' => 'default',
    'size' => 'md'
])

@php
    $types = [
        'default' => 'bg-white/10 text-white/70',
        'primary' => 'bg-primary-500/20 text-primary-400',
        'success' => 'bg-green-500/20 text-green-400',
        'warning' => 'bg-amber-500/20 text-amber-400',
        'error' => 'bg-red-500/20 text-red-400',
        'info' => 'bg-blue-500/20 text-blue-400',
        // Status badges
        'active' => 'bg-green-500/20 text-green-400',
        'trial' => 'bg-amber-500/20 text-amber-400',
        'locked' => 'bg-red-500/20 text-red-400',
        'expired' => 'bg-gray-500/20 text-gray-400',
        'premium' => 'bg-gradient-to-r from-amber-500 to-yellow-400 text-black',
        'basic' => 'bg-white/20 text-white',
    ];
    
    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
        'lg' => 'px-3 py-1.5 text-sm',
    ];
    
    $typeClass = $types[$type] ?? $types['default'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium rounded-full ' . $typeClass . ' ' . $sizeClass]) }}>
    {{ $slot }}
</span>

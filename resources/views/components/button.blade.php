{{-- 
Glass Button Component
Usage: <x-button>Click me</x-button>
       <x-button variant="secondary" size="lg">Large Button</x-button>
--}}

@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
    'loading' => false,
    'disabled' => false
])

@php
    $baseClasses = 'glass-btn';
    
    $variants = [
        'primary' => '',
        'secondary' => 'glass-btn-secondary',
        'ghost' => 'glass-btn-ghost',
        'danger' => 'glass-btn-danger',
    ];
    
    $sizes = [
        'sm' => 'glass-btn-sm',
        'md' => '',
        'lg' => 'glass-btn-lg',
    ];
    
    $classes = $baseClasses . ' ' . ($variants[$variant] ?? '') . ' ' . ($sizes[$size] ?? '');
    
    if ($loading) $classes .= ' glass-btn-loading';
    if ($disabled) $classes .= ' opacity-50 cursor-not-allowed';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @disabled($disabled)>
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
    </button>
@endif

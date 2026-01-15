{{-- 
Alert Component
Usage: <x-alert type="success">Message</x-alert>
--}}

@props([
    'type' => 'info',
    'dismissible' => false,
    'icon' => null
])

@php
    $types = [
        'success' => [
            'bg' => 'bg-green-500/10 border-green-500/30',
            'icon' => 'fa-solid fa-check-circle text-green-400',
            'text' => 'text-green-300'
        ],
        'error' => [
            'bg' => 'bg-red-500/10 border-red-500/30',
            'icon' => 'fa-solid fa-times-circle text-red-400',
            'text' => 'text-red-300'
        ],
        'warning' => [
            'bg' => 'bg-amber-500/10 border-amber-500/30',
            'icon' => 'fa-solid fa-exclamation-triangle text-amber-400',
            'text' => 'text-amber-300'
        ],
        'info' => [
            'bg' => 'bg-blue-500/10 border-blue-500/30',
            'icon' => 'fa-solid fa-info-circle text-blue-400',
            'text' => 'text-blue-300'
        ],
    ];
    
    $config = $types[$type] ?? $types['info'];
    $iconClass = $icon ?: $config['icon'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-start gap-3 p-4 rounded-xl border ' . $config['bg']]) }}
     role="alert">
    <i class="{{ $iconClass }} mt-0.5"></i>
    <div class="flex-1 {{ $config['text'] }}">
        {{ $slot }}
    </div>
    @if($dismissible)
        <button type="button" class="text-white/40 hover:text-white/70 transition" onclick="this.parentElement.remove()">
            <i class="fa-solid fa-times"></i>
        </button>
    @endif
</div>

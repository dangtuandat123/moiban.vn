{{-- 
Dropdown Component
Usage: 
<x-dropdown>
    <x-slot name="trigger">
        <button>Options</button>
    </x-slot>
    
    <x-dropdown-item href="/settings">Settings</x-dropdown-item>
    <x-dropdown-item>Logout</x-dropdown-item>
</x-dropdown>
--}}

@props([
    'align' => 'right',
    'width' => 'w-48'
])

@php
    $alignmentClasses = [
        'left' => 'left-0',
        'right' => 'right-0',
    ];
@endphp

<div class="glass-dropdown relative" x-data="{ open: false }" @click.away="open = false">
    <!-- Trigger -->
    <div @click="open = !open" class="cursor-pointer">
        {{ $trigger }}
    </div>
    
    <!-- Dropdown Content -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-2 {{ $width }} {{ $alignmentClasses[$align] }} glass-panel-elevated rounded-xl overflow-hidden"
         style="display: none;">
        {{ $slot }}
    </div>
</div>

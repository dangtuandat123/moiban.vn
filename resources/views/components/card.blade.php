{{-- 
Glass Card Component
Usage: <x-card>Content</x-card>
--}}

@props([
    'hover' => true,
    'padding' => true
])

<div {{ $attributes->merge([
    'class' => 'glass-card' . 
               ($padding ? ' p-6' : '') . 
               ($hover ? ' hover:border-primary-500/30' : '')
]) }}>
    {{ $slot }}
</div>

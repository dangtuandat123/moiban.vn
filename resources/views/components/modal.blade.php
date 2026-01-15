{{-- 
Modal Component
Usage: 
<x-modal id="my-modal" title="Modal Title">
    Content here
    <x-slot name="footer">Footer buttons</x-slot>
</x-modal>

Trigger: <button data-modal-target="#my-modal">Open</button>
--}}

@props([
    'id',
    'title' => null,
    'size' => 'md',
    'closable' => true
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-full mx-4',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div id="{{ $id }}" 
     class="fixed inset-0 z-[999] hidden" 
     aria-hidden="true"
     role="dialog"
     aria-modal="true"
     aria-labelledby="{{ $id }}-title">
    
    <!-- Overlay -->
    <div class="modal-overlay absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="modal-content relative w-full {{ $sizeClass }} glass-panel-elevated rounded-2xl transform scale-95 opacity-0 transition-all duration-300">
            
            <!-- Header -->
            @if($title || $closable)
            <div class="flex items-center justify-between p-5 border-b border-white/10">
                @if($title)
                    <h3 id="{{ $id }}-title" class="text-lg font-semibold">{{ $title }}</h3>
                @endif
                @if($closable)
                    <button type="button" 
                            data-modal-close
                            class="text-white/40 hover:text-white transition p-1"
                            aria-label="Đóng">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                @endif
            </div>
            @endif
            
            <!-- Body -->
            <div class="p-5">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            @if(isset($footer))
            <div class="flex items-center justify-end gap-3 p-5 border-t border-white/10">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div>

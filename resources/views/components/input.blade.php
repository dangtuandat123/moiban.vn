{{-- 
Glass Input Component
Usage: <x-input name="email" label="Email" type="email" />
--}}

@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'helper' => null,
    'icon' => null
])

@php
    $hasError = $error || $errors->has($name);
    $errorMessage = $error ?: $errors->first($name);
    
    $inputClasses = 'glass-input';
    if ($hasError) $inputClasses .= ' input-error';
    if ($icon) $inputClasses .= ' pl-10';
@endphp

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-400">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-white/40">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        
        @if($type === 'textarea')
            <textarea 
                id="{{ $name }}"
                name="{{ $name }}"
                class="{{ $inputClasses }}"
                placeholder="{{ $placeholder }}"
                @required($required)
                @disabled($disabled)
                rows="4"
                aria-describedby="{{ $hasError ? $name . '-error' : '' }}"
            >{{ old($name, $value) }}</textarea>
        @else
            <input 
                type="{{ $type }}"
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ old($name, $value) }}"
                class="{{ $inputClasses }}"
                placeholder="{{ $placeholder }}"
                @required($required)
                @disabled($disabled)
                aria-describedby="{{ $hasError ? $name . '-error' : '' }}"
            >
        @endif
    </div>
    
    @if($hasError)
        <p id="{{ $name }}-error" class="mt-2 text-sm text-red-400" role="alert">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $errorMessage }}
        </p>
    @elseif($helper)
        <p class="mt-2 text-sm text-white/50">{{ $helper }}</p>
    @endif
</div>

@extends('layouts.admin')

@section('title', 'Quản lý Templates - Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Templates</h1>
        <p class="text-white/60">Quản lý mẫu thiệp</p>
    </div>
    <a href="{{ route('admin.templates.create') }}" class="glass-btn">
        <i class="fa-solid fa-upload mr-2"></i> Upload Template
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($templates as $template)
    <div class="glass-card overflow-hidden {{ $template->trashed() ? 'opacity-50' : '' }}">
        <div class="aspect-video bg-gradient-to-br from-rose-gold/20 to-purple-500/20 relative overflow-hidden">
            @php
                $thumbnailPath = 'images/templates/' . $template->slug . '.png';
            @endphp
            @if(file_exists(public_path($thumbnailPath)))
                <img src="{{ asset($thumbnailPath) }}" alt="{{ $template->name }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fa-solid fa-image text-4xl text-white/20"></i>
                </div>
            @endif
        </div>
        <div class="p-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold">{{ $template->name }}</h3>
                <span class="px-2 py-1 text-xs rounded {{ $template->type === 'premium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400' }}">
                    {{ $template->type }}
                </span>
            </div>
            <p class="text-sm text-white/60 mb-4">{{ Str::limit($template->description, 60) }}</p>
            <div class="flex items-center justify-between">
                <span class="text-xs {{ $template->is_active ? 'text-green-400' : 'text-red-400' }}">
                    {{ $template->is_active ? 'Active' : 'Inactive' }}
                </span>
                <div class="space-x-2">
                    <a href="{{ route('admin.templates.edit', $template) }}" class="text-white/60 hover:text-white">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

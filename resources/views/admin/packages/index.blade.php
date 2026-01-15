@extends('layouts.admin')

@section('title', 'Quản lý Gói - Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Gói dịch vụ</h1>
        <p class="text-white/60">Quản lý các gói giá</p>
    </div>
    <a href="{{ route('admin.packages.create') }}" class="glass-btn">
        <i class="fa-solid fa-plus mr-2"></i> Thêm gói
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($packages as $package)
    <div class="glass-card p-6 {{ !$package->is_active ? 'opacity-50' : '' }}">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-lg font-semibold">{{ $package->name }}</h3>
                <span class="px-2 py-1 text-xs rounded {{ $package->type === 'premium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400' }}">
                    {{ $package->type }}
                </span>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-gradient">{{ $package->formatted_price }}</p>
                <p class="text-sm text-white/60">{{ $package->duration_label }}</p>
            </div>
        </div>
        
        <p class="text-sm text-white/60 mb-4">{{ $package->description }}</p>
        
        @if($package->features)
        <div class="flex flex-wrap gap-1 mb-4">
            @foreach($package->features as $feature)
            <span class="text-xs px-2 py-1 rounded bg-white/10">{{ $feature }}</span>
            @endforeach
        </div>
        @endif
        
        <div class="flex items-center justify-between pt-4 border-t border-white/10">
            <span class="text-xs {{ $package->is_active ? 'text-green-400' : 'text-red-400' }}">
                {{ $package->is_active ? 'Active' : 'Inactive' }}
            </span>
            <a href="{{ route('admin.packages.edit', $package) }}" class="text-white/60 hover:text-white">
                <i class="fa-solid fa-pen"></i> Sửa
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection

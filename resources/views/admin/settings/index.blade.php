@extends('layouts.admin')

@section('title', 'Cài đặt - Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Cài đặt hệ thống</h1>
    <p class="text-white/60">Cấu hình các thông số hệ thống</p>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    
    @foreach($settings as $group => $items)
    <div class="glass-card p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4 capitalize">{{ $group ?: 'General' }}</h2>
        <div class="space-y-4">
            @foreach($items as $setting)
            <div>
                <label class="block text-sm font-medium mb-2">{{ $setting->key }}</label>
                <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" 
                       class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white">
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    
    <button type="submit" class="glass-btn px-6 py-3">
        <i class="fa-solid fa-save mr-2"></i> Lưu cài đặt
    </button>
</form>
@endsection

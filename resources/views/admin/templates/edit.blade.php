@extends('layouts.admin')

@section('title', 'Edit Template - Admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.templates.index') }}" class="text-white/60 hover:text-white">
        <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
    </a>
</div>

<div class="max-w-2xl">
    <h1 class="text-2xl font-semibold mb-6">Chỉnh sửa: {{ $template->name }}</h1>
    
    <form action="{{ route('admin.templates.update', $template) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="glass-card p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium mb-2">Tên template</label>
                <input type="text" name="name" value="{{ old('name', $template->name) }}" 
                       class="w-full p-3 bg-white/10 border border-white/20 rounded-lg" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Mô tả</label>
                <textarea name="description" rows="3" 
                          class="w-full p-3 bg-white/10 border border-white/20 rounded-lg">{{ old('description', $template->description) }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Loại</label>
                <select name="type" class="w-full p-3 bg-white/10 border border-white/20 rounded-lg">
                    <option value="basic" {{ $template->type === 'basic' ? 'selected' : '' }}>Basic</option>
                    <option value="premium" {{ $template->type === 'premium' ? 'selected' : '' }}>Premium</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Thứ tự</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $template->sort_order) }}" 
                       class="w-full p-3 bg-white/10 border border-white/20 rounded-lg">
            </div>
            
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="is_active" value="1" id="is_active"
                       {{ $template->is_active ? 'checked' : '' }} 
                       class="w-5 h-5 rounded bg-white/10 border-white/20">
                <label for="is_active">Kích hoạt</label>
            </div>
            
            <button type="submit" class="glass-btn px-6 py-3">
                <i class="fa-solid fa-save mr-2"></i> Lưu
            </button>
        </div>
    </form>
</div>
@endsection

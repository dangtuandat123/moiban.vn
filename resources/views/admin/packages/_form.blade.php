@php $package = $package ?? null; @endphp

<div class="glass-card p-6 space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium mb-2">Tên gói</label>
            <input type="text" name="name" value="{{ old('name', $package?->name) }}" 
                   class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Loại</label>
            <select name="type" class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white">
                <option value="basic" {{ ($package?->type ?? '') === 'basic' ? 'selected' : '' }}>Basic</option>
                <option value="premium" {{ ($package?->type ?? '') === 'premium' ? 'selected' : '' }}>Premium</option>
            </select>
        </div>
    </div>
    
    <div>
        <label class="block text-sm font-medium mb-2">Mô tả</label>
        <textarea name="description" rows="2" 
                  class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white">{{ old('description', $package?->description) }}</textarea>
    </div>
    
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium mb-2">Giá (VND)</label>
            <input type="number" name="price" value="{{ old('price', $package?->price ?? 0) }}" min="0"
                   class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Thời hạn (ngày, 0 = vĩnh viễn)</label>
            <input type="number" name="duration_days" value="{{ old('duration_days', $package?->duration_days ?? 0) }}" min="0"
                   class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white" required>
        </div>
    </div>
    
    <div>
        <label class="block text-sm font-medium mb-2">Thứ tự hiển thị</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $package?->sort_order ?? 0) }}" 
               class="w-full p-3 bg-white/10 border border-white/20 rounded-lg text-white">
    </div>
    
    <div class="flex items-center space-x-3">
        <input type="checkbox" name="is_active" value="1" id="is_active"
               {{ ($package?->is_active ?? true) ? 'checked' : '' }} 
               class="w-5 h-5 rounded bg-white/10 border-white/20">
        <label for="is_active">Kích hoạt</label>
    </div>
    
    <button type="submit" class="glass-btn px-6 py-3">
        <i class="fa-solid fa-save mr-2"></i> Lưu
    </button>
</div>

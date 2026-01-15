@extends('layouts.app')

@section('title', 'Chỉnh sửa thiệp - Mời Bạn')

@section('content')
<div class="flex h-[calc(100vh-4rem)]">
    <!-- Sidebar Editor -->
    <div class="w-80 bg-slate-900 border-r border-white/10 overflow-y-auto p-4">
        <div class="mb-6">
            <a href="{{ route('user.invitations.show', $invitation) }}" class="text-white/60 hover:text-white text-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Quay lại
            </a>
            <h2 class="text-lg font-semibold mt-2">Chỉnh sửa thiệp</h2>
        </div>
        
        <form id="editor-form" method="POST" action="{{ route('user.invitations.editor.save', $invitation) }}">
            @csrf
            <input type="hidden" name="title" value="{{ $invitation->title }}">
            
            <!-- Thông tin cơ bản -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-white/70 mb-3 uppercase">Thông tin</h3>
                
                @foreach($fields as $key => $field)
                <div class="mb-4">
                    <label class="block text-xs text-white/60 mb-1">{{ $field['label'] ?? ucfirst($key) }}</label>
                    
                    @if(($field['type'] ?? 'text') === 'textarea' || ($field['type'] ?? 'text') === 'richtext')
                    <textarea name="content[{{ $key }}]" rows="3" 
                              class="w-full p-2 text-sm bg-white/10 border border-white/20 rounded-lg resize-none">{{ $invitation->content[$key] ?? $field['default'] ?? '' }}</textarea>
                    @elseif(($field['type'] ?? 'text') === 'date')
                    <input type="date" name="content[{{ $key }}]" 
                           value="{{ $invitation->content[$key] ?? $field['default'] ?? '' }}"
                           class="w-full p-2 text-sm bg-white/10 border border-white/20 rounded-lg">
                    @elseif(($field['type'] ?? 'text') === 'time')
                    <input type="time" name="content[{{ $key }}]" 
                           value="{{ $invitation->content[$key] ?? $field['default'] ?? '' }}"
                           class="w-full p-2 text-sm bg-white/10 border border-white/20 rounded-lg">
                    @elseif(($field['type'] ?? 'text') === 'color')
                    <input type="color" name="content[{{ $key }}]" 
                           value="{{ $invitation->content[$key] ?? $field['default'] ?? '#b76e79' }}"
                           class="w-full h-10 p-1 bg-white/10 border border-white/20 rounded-lg cursor-pointer">
                    @elseif(($field['type'] ?? 'text') === 'select')
                    <select name="content[{{ $key }}]" class="w-full p-2 text-sm bg-white/10 border border-white/20 rounded-lg">
                        @foreach($field['options'] ?? [] as $option)
                        <option value="{{ $option }}" {{ ($invitation->content[$key] ?? '') === $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <input type="text" name="content[{{ $key }}]" 
                           value="{{ $invitation->content[$key] ?? $field['default'] ?? '' }}"
                           class="w-full p-2 text-sm bg-white/10 border border-white/20 rounded-lg">
                    @endif
                </div>
                @endforeach
            </div>
            
            <!-- Widgets -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-white/70 mb-3 uppercase">Widgets</h3>
                
                @foreach($invitation->widgets as $widget)
                <div class="flex items-center justify-between p-3 mb-2 rounded-lg bg-white/5">
                    <div class="flex items-center space-x-3">
                        <i class="{{ $widget->icon }} text-white/60"></i>
                        <span class="text-sm">{{ $widget->label }}</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="widgets[{{ $widget->widget_type }}][enabled]" value="1"
                               {{ $widget->is_enabled ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-9 h-5 bg-white/20 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-gold"></div>
                    </label>
                </div>
                @endforeach
            </div>
            
            <button type="submit" class="glass-btn w-full py-3">
                <i class="fa-solid fa-save mr-2"></i> Lưu thay đổi
            </button>
        </form>
    </div>
    
    <!-- Preview Panel -->
    <div class="flex-1 bg-slate-800 p-4 overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold">Xem trước</h3>
            <a href="{{ $invitation->public_url }}" target="_blank" class="text-sm text-rose-gold hover:underline">
                <i class="fa-solid fa-external-link mr-1"></i> Mở trong tab mới
            </a>
        </div>
        <div class="bg-white rounded-xl overflow-hidden h-[calc(100%-3rem)]">
            <iframe src="{{ $invitation->public_url }}" class="w-full h-full border-0"></iframe>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    main { padding-top: 0 !important; }
</style>
@endpush
